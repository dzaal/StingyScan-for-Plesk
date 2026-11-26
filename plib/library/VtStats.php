<?php
require_once __DIR__ . '/VtDataDir.php';
require_once __DIR__ . '/VtSettings.php';
require_once __DIR__ . '/PleskDomains.php';

/**
 * VtStats: installation statistics, "Talk to mama" (Settings → Maintenance, administrator only).
 *
 * Off by default (opt-in: setting stats_share, default false); on only once the server administrator ticks it. When on, the
 * 5-minute background task sends at most once every 7 days a JSON POST to the collector with exactly:
 *
 *   installation_id  random, 32 hex characters (random_bytes), kept in the data folder (vt_installation_id)
 *   hostname         the server host name configured in Plesk (never the browser's Host header)
 *   version          the installed Stingy Scanner version
 *   hosted_sites     active hosted domains and subdomains in Plesk (no aliases, no external sites)
 *
 * Nothing else: no domain names, customers, API keys or scan results. When the site inventory cannot be
 * read, nothing is sent (rather than a false zero). A failed request is retried after RETRY seconds; the
 * check-in runs after the task's own work, with short timeouts, and never stops a scan.
 *
 * State (vt_stats.json): {last_ok, next_try, last_error, last_status}. The ID survives upgrades, host
 * name changes and switching sharing off and on; it is only made when sharing is first switched on.
 */
class VtStats
{
    const URL      = 'https://stats.digizaal.nl/check-in';
    const INTERVAL = 7 * 86400;  // at most once a week
    const RETRY    = 6 * 3600;   // after a failed request
    const ID_FILE  = 'vt_installation_id';
    const STATE    = 'vt_stats.json';

    /** Is sharing switched on? Only when the administrator switched it on (never saved: off). */
    public static function enabled(): bool
    {
        return (new VtSettings('admin'))->get('stats_share', false) === true;
    }

    /** The installation ID; made (and saved) only when $create. Null when there is none (yet). */
    public static function installationId(bool $create = false): ?string
    {
        $file = VtDataDir::path(self::ID_FILE);
        $id   = strtolower(trim((string)@file_get_contents($file)));
        if (preg_match('/^[a-f0-9]{32}$/', $id)) return $id;
        if (!$create) return null;
        VtDataDir::ensureExists();
        $id  = bin2hex(random_bytes(16));
        $tmp = $file . '.' . getmypid() . '.tmp';
        if (@file_put_contents($tmp, $id . "\n") === false) return null;
        @chmod($tmp, 0600);
        // Two runs at once: the first link wins, the other reads it back
        if (!@link($tmp, $file)) { @unlink($tmp); $id = strtolower(trim((string)@file_get_contents($file))); return preg_match('/^[a-f0-9]{32}$/', $id) ? $id : null; }
        @unlink($tmp);
        return $id;
    }

    /** The server host name as configured in Plesk (Tools & Settings → Server Settings), else the machine's name */
    public static function hostname(): ?string
    {
        $h = '';
        $pdo = PleskDomains::pdo();
        if ($pdo) {
            try { $h = (string)$pdo->query("SELECT val FROM misc WHERE param = 'FullHostName' LIMIT 1")->fetchColumn(); }
            catch (\PDOException $e) { $h = ''; }
        }
        if ($h === '') $h = (string)(gethostname() ?: '');
        $h = strtolower(rtrim(trim($h), '.'));
        return self::validHostname($h) ? $h : null;
    }

    public static function validHostname(string $h): bool
    {
        return strlen($h) <= 253 && (bool)preg_match('/^(?=.{1,253}$)([a-z0-9](?:[a-z0-9\-]{0,61}[a-z0-9])?)(\.[a-z0-9](?:[a-z0-9\-]{0,61}[a-z0-9])?)*$/', $h);
    }

    /** The installed version (meta.xml of the module) */
    public static function version(): string
    {
        $file = dirname(__DIR__) . '/meta.xml';
        if (is_file($file) && preg_match('#<version>\s*([^<\s]+)\s*</version>#', (string)file_get_contents($file), $m)) return $m[1];
        return '';
    }

    /**
     * The check-in body, or null when something cannot be determined (then nothing is sent).
     * $d: dependencies, replaced in tests (hostname, sites, version).
     */
    public static function payload(string $id, array $d = []): ?array
    {
        $host  = ($d['hostname'] ?? [self::class, 'hostname'])();
        $sites = ($d['sites'] ?? [PleskDomains::class, 'countHostedSites'])();
        $ver   = ($d['version'] ?? [self::class, 'version'])();
        if (!is_string($host) || !self::validHostname($host)) return null;
        if (!is_int($sites) || $sites < 0) return null;            // inventory failed: no false zero
        if (!is_string($ver) || !preg_match('/^[0-9A-Za-z.\-+]{1,32}$/', $ver)) return null;
        return ['installation_id' => $id, 'hostname' => $host, 'version' => $ver, 'hosted_sites' => $sites];
    }

    /**
     * Send the weekly check-in when it is due. Safe to call often (every 5 minutes): it returns at once
     * when sharing is off or nothing is due, and only one run at a time can send.
     * Returns what happened: off, not_due, busy, no_id, inventory, sent, failed.
     * $d: dependencies for tests: enabled, now, send(url, json) => [ok, status, error], plus payload's.
     */
    public static function checkIn(array $d = []): string
    {
        $enabled = $d['enabled'] ?? [self::class, 'enabled'];
        if (!$enabled()) return 'off';
        $now   = (int)(isset($d['now']) ? $d['now']() : time());
        $state = self::state();
        if ($now < (int)($state['next_try'] ?? 0)) return 'not_due';

        $lock = @fopen(VtDataDir::path('vt_stats.lock'), 'c');
        if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) return 'busy';
        try {
            $state = self::state(); // again, inside the lock: another run may just have sent
            if ($now < (int)($state['next_try'] ?? 0)) return 'not_due';
            if (!$enabled()) return 'off'; // switched off a moment ago
            $id = self::installationId(true);
            if ($id === null) return 'no_id';
            $body = self::payload($id, $d);
            if ($body === null) { // try again in an hour, without counting it as a failed request
                self::saveState(['next_try' => $now + 3600, 'last_status' => 'inventory'] + $state);
                return 'inventory';
            }
            if (!$enabled()) return 'off';
            [$ok, $code, $err] = ($d['send'] ?? [self::class, 'send'])(self::URL, json_encode($body, JSON_UNESCAPED_SLASHES));
            if ($ok) {
                self::saveState(['last_ok' => $now, 'next_try' => $now + self::INTERVAL, 'last_status' => 'sent', 'last_error' => ''] + $state);
                return 'sent';
            }
            self::saveState(['next_try' => $now + self::RETRY + random_int(0, 900), 'last_status' => 'failed',
                             'last_error' => mb_substr(($code ? 'HTTP ' . $code . ' ' : '') . $err, 0, 200)] + $state);
            return 'failed';
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }

    /** POST over HTTPS with normal certificate checks and short timeouts: [ok, http status, error] */
    public static function send(string $url, string $json): array
    {
        if (!function_exists('curl_init')) return [false, 0, 'curl missing'];
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'Accept: application/json'],
            CURLOPT_USERAGENT      => 'StingyScan-stats/1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_TIMEOUT        => 8,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_PROTOCOLS      => CURLPROTO_HTTPS,
            CURLOPT_FOLLOWLOCATION => false,
        ]);
        curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err  = curl_error($ch);
        curl_close($ch);
        return [$code >= 200 && $code < 300, $code, $err];
    }

    /** What Settings shows, computed here (the collector is never asked) */
    public static function localInfo(): array
    {
        $s = self::state();
        return ['enabled' => self::enabled(), 'hostname' => self::hostname(), 'hosted_sites' => PleskDomains::countHostedSites(),
                'version' => self::version(), 'has_id' => self::installationId() !== null,
                'last_ok' => (int)($s['last_ok'] ?? 0), 'next_try' => (int)($s['next_try'] ?? 0),
                'last_status' => (string)($s['last_status'] ?? ''), 'last_error' => (string)($s['last_error'] ?? '')];
    }

    public static function state(): array
    {
        $d = json_decode((string)@file_get_contents(VtDataDir::path(self::STATE)), true);
        return is_array($d) ? $d : [];
    }

    private static function saveState(array $s): void
    {
        $f = VtDataDir::path(self::STATE);
        @file_put_contents($f . '.tmp', json_encode($s));
        @rename($f . '.tmp', $f);
    }
}
