<?php
require_once __DIR__ . '/VtDataDir.php';
require_once __DIR__ . '/VtSettings.php';
require_once __DIR__ . '/PleskDomains.php';

/**
 * VtPwned: are the e-mail addresses of the WordPress administrators (and addresses added by hand)
 * in a known data breach?
 *
 * Accounts: every user with the administrator role in the database of each hosted WordPress site
 * (the install that wp-config.php points to; old copies are skipped). Read-only.
 *
 * Breach data, chosen by the administrator (Pwned tab → settings):
 *   hibp  Have I Been Pwned, with the administrator's own (paid) API key. The rate limit of the
 *         subscription is read when the key is saved.
 *   xon   XposedOrNot, free and without a key (about 1 request per second, 100 per day).
 * Only the e-mail address is sent. Nothing is sent while no source is chosen.
 *
 * A checked address is never checked again: breaches are history, the result stays valid.
 * Failed checks are tried again.
 *
 * Files: vt_pwned.json      { email: {state: ok|failed, checked_at, source, breaches: [{name, title?, date?, data?}], error?} }
 *        vt_pwned_custom.json { email: {by, added} }
 *        vt_pwned_state.json  { day, calls, next_at }
 *        vt_wp_admins.json    { t, sites: { host: [{login, email, registered}] } }
 */
class VtPwned
{
    const SOURCES   = ['hibp' => 'Have I Been Pwned', 'xon' => 'XposedOrNot'];
    const HIBP_API  = 'https://haveibeenpwned.com/api/v3/';
    const XON_API   = 'https://api.xposedornot.com/v1/check-email/';
    const UA        = 'Stingy-Scanner-for-Plesk';
    const XON_DAY   = 90;     // stay below XposedOrNot's 100 requests per day
    const XON_GAP   = 150;    // seconds between two XposedOrNot requests: it allows about 25 per hour (429 with a 30-minute wait above that)
    const RETRY     = 3600;   // a failed check is tried again after an hour
    const ACCOUNTS_TTL = 21600; // the account list is read again after 6 hours
    const MAX_CUSTOM = 1000;

    // ── Settings (administrator, server-wide) ──────────────────

    public static function source(): string
    {
        $s = (string)(new VtSettings('admin'))->get('pwned_source', '');
        if ($s === 'hibp' && self::hibpKey() === '') return '';
        return isset(self::SOURCES[$s]) ? $s : '';
    }

    public static function hibpKey(): string
    {
        return trim((string)(new VtSettings('admin'))->get('pwned_hibp_key', ''));
    }

    public static function maskedKey(): string
    {
        $k = self::hibpKey();
        return $k === '' ? '' : '…' . substr($k, -4);
    }

    /** Seconds between two requests */
    private static function spacing(string $src): float
    {
        if ($src === 'hibp') return 60 / max(1, (int)(new VtSettings('admin'))->get('pwned_hibp_rpm', 10)) + 0.5;
        return self::XON_GAP;
    }

    /** Test a Have I Been Pwned key: [ok, message, rpm] */
    public static function testHibpKey(string $key): array
    {
        [$code, $body] = self::get(self::HIBP_API . 'subscription/status', ['hibp-api-key: ' . $key]);
        if ($code === 200) {
            $j = json_decode($body, true) ?: [];
            return [true, 'Key accepted (' . ($j['SubscriptionName'] ?? 'subscription') . ', ' . (int)($j['Rpm'] ?? 10) . ' requests per minute)', (int)($j['Rpm'] ?? 10)];
        }
        if ($code === 401) return [false, 'Have I Been Pwned did not accept this key', 0];
        if ($code === 0) return [false, 'Could not reach haveibeenpwned.com', 0];
        return [false, 'Have I Been Pwned answered HTTP ' . $code, 0];
    }

    // ── Results ────────────────────────────────────────────────

    public static function results(): array
    {
        $d = json_decode((string)@file_get_contents(VtDataDir::path('vt_pwned.json')), true);
        return is_array($d) ? $d : [];
    }

    /**
     * Results of the per-site check of 2.5.7 (vt_xon_cache.json, keyed by md5 of the address)
     * are copied into this store once, so those addresses are not asked again.
     */
    public static function importXonCache(array $emails): void
    {
        $old = VtDataDir::path('vt_xon_cache.json');
        if (!is_file($old)) return;
        $cache = json_decode((string)@file_get_contents($old), true);
        if (!is_array($cache) || !$cache) return;
        $byMd5 = [];
        foreach ($emails as $e) $byMd5[md5(strtolower(trim($e)))] = $e;
        $add = [];
        foreach ($cache as $k => $c) {
            if (!isset($byMd5[$k]) || !is_array($c['d'] ?? null)) continue;
            $add[$byMd5[$k]] = ['state' => 'ok', 'checked_at' => (int)($c['t'] ?? time()), 'source' => 'xon',
                                'breaches' => array_map(fn($n) => ['name' => (string)$n, 'title' => (string)$n], $c['d'])];
        }
        if (!$add) return;
        self::lockedResults(function (array $all) use ($add) {
            foreach ($add as $e => $r) if (!isset($all[$e]) || ($all[$e]['state'] ?? '') !== 'ok') $all[$e] = $r;
            return $all;
        });
    }

    public static function needsCheck(?array $r): bool
    {
        if (!$r) return true;
        if (($r['state'] ?? '') === 'ok') return false;
        return time() - (int)($r['checked_at'] ?? 0) > self::RETRY;
    }

    /**
     * Check one address now, if the rate limit allows it.
     * Returns the stored result, or ['state' => 'wait', 'retry_after' => s, 'reason' => limit|day], or ['state' => 'off'].
     */
    public static function check(string $email): array
    {
        $src = self::source();
        if ($src === '') return ['state' => 'off'];
        $wait = self::reserve($src);
        if ($wait > 0) return ['state' => 'wait', 'retry_after' => $wait, 'reason' => self::$why];
        $r = $src === 'hibp' ? self::hibp($email) : self::xon($email);
        if (($r['state'] ?? '') === 'wait') return $r;
        $r += ['checked_at' => time(), 'source' => $src];
        self::lockedResults(function (array $all) use ($email, $r) { $all[$email] = $r; return $all; });
        return $r;
    }

    private static function hibp(string $email): array
    {
        [$code, $body, $hdr] = self::get(self::HIBP_API . 'breachedaccount/' . rawurlencode($email) . '?truncateResponse=false',
                                         ['hibp-api-key: ' . self::hibpKey()]);
        if ($code === 404) return ['state' => 'ok', 'breaches' => []];
        if ($code === 200) {
            $out = [];
            foreach (json_decode($body, true) ?: [] as $b) {
                $out[] = ['name' => (string)($b['Name'] ?? ''), 'title' => (string)($b['Title'] ?? $b['Name'] ?? ''),
                          'date' => (string)($b['BreachDate'] ?? ''), 'data' => array_slice(array_map('strval', (array)($b['DataClasses'] ?? [])), 0, 12)];
            }
            usort($out, fn($a, $b) => strcmp($b['date'], $a['date']));
            return ['state' => 'ok', 'breaches' => $out];
        }
        if ($code === 429) return self::backoff((int)($hdr['retry-after'] ?? 10));
        return ['state' => 'failed', 'breaches' => [], 'error' => $code === 401 ? 'API key not accepted' : ($code ? 'HTTP ' . $code : 'no connection')];
    }

    private static function xon(string $email): array
    {
        [$code, $body, $hdr] = self::get(self::XON_API . rawurlencode($email));
        $j = json_decode($body, true);
        if ($code === 404 || ($code === 200 && isset($j['Error']))) return ['state' => 'ok', 'breaches' => []];
        if ($code === 200 && isset($j['breaches'])) {
            $names = [];
            array_walk_recursive($j['breaches'], function ($n) use (&$names) { if (is_string($n) && $n !== '') $names[] = $n; });
            return ['state' => 'ok', 'breaches' => array_map(fn($n) => ['name' => $n, 'title' => $n], array_values(array_unique($names)))];
        }
        if ($code === 429) return self::backoff((int)($hdr['retry-after'] ?? 60));
        return ['state' => 'failed', 'breaches' => [], 'error' => $code ? 'HTTP ' . $code : 'no connection'];
    }

    /** The service asked to slow down: no request before $s seconds from now */
    private static function backoff(int $s): array
    {
        $s = max(2, min(3600, $s));
        self::lockedState(function (array $st) use ($s) { $st['next_at'] = max((float)($st['next_at'] ?? 0), microtime(true) + $s); return $st; });
        return ['state' => 'wait', 'retry_after' => $s, 'reason' => 'limit'];
    }

    /** Reserve a request; returns seconds to wait (0 = go) */
    /** Why the last reserve() said wait: limit (request limit of the service) or day (daily maximum) */
    private static string $why = 'limit';

    private static function reserve(string $src): int
    {
        $wait = 0;
        self::lockedState(function (array $st) use ($src, &$wait) {
            $now = microtime(true);
            $day = gmdate('Y-m-d');
            if (($st['day'] ?? '') !== $day) $st = ['day' => $day, 'calls' => 0, 'next_at' => (float)($st['next_at'] ?? 0)];
            self::$why = 'limit';
            if ($src === 'xon' && $st['calls'] >= self::XON_DAY) { $wait = strtotime('tomorrow UTC') - (int)$now; self::$why = 'day'; return $st; }
            if ($st['next_at'] > $now) { $wait = max(1, (int)ceil($st['next_at'] - $now)); return $st; }
            $st['calls']++;
            $st['next_at'] = $now + self::spacing($src);
            return $st;
        });
        return $wait;
    }

    public static function callsToday(): int
    {
        $st = json_decode((string)@file_get_contents(VtDataDir::path('vt_pwned_state.json')), true);
        return is_array($st) && ($st['day'] ?? '') === gmdate('Y-m-d') ? (int)$st['calls'] : 0;
    }

    // ── Breach details (XposedOrNot only gives names per address) ──

    const XON_CATALOG = 'https://api.xposedornot.com/v1/breaches';

    /**
     * XposedOrNot's public list of all breaches, kept as { name: {date, data, pw} } in vt_xon_breaches.json.
     * Fetched at most once a week (one request, not per address); after a failed fetch, an hour later.
     */
    public static function xonCatalog(): array
    {
        $file = VtDataDir::path('vt_xon_breaches.json');
        $c    = json_decode((string)@file_get_contents($file), true);
        $age  = is_array($c) ? time() - (int)($c['t'] ?? 0) : PHP_INT_MAX;
        if ($age < (!empty($c['list']) ? 7 * 86400 : 3600)) return $c['list'] ?? [];
        [$code, $body] = self::get(self::XON_CATALOG);
        $list = [];
        foreach ((json_decode($body, true)['exposedBreaches'] ?? []) as $b) {
            if (empty($b['breachID'])) continue;
            $list[(string)$b['breachID']] = ['date' => substr((string)($b['breachedDate'] ?? ''), 0, 10),
                                             'data' => array_slice(array_map('strval', (array)($b['exposedData'] ?? [])), 0, 12),
                                             'pw'   => (string)($b['passwordRisk'] ?? '')];
        }
        if ($code !== 200 || !$list) $list = $c['list'] ?? []; // keep the old list; try again in an hour
        @file_put_contents($file, json_encode(['t' => time(), 'list' => $list]));
        return $list;
    }

    /** Add the date and the leaked data to XposedOrNot breaches (from the catalog), newest first */
    public static function withDetails(array $results): array
    {
        $need = false;
        foreach ($results as $r) foreach ($r['breaches'] ?? [] as $b) if (empty($b['date'])) { $need = true; break 2; }
        if (!$need) return $results;
        $cat = self::xonCatalog();
        foreach ($results as &$r) {
            if (empty($r['breaches'])) continue;
            foreach ($r['breaches'] as &$b) {
                $d = $cat[$b['name']] ?? null;
                if (!$d) continue;
                if (empty($b['date'])) $b['date'] = $d['date'];
                if (empty($b['data'])) $b['data'] = $d['data'];
                if (empty($b['pw']) && !empty($d['pw'])) $b['pw'] = $d['pw'];
            }
            unset($b);
            usort($r['breaches'], fn($a, $b) => strcmp((string)($b['date'] ?? ''), (string)($a['date'] ?? '')));
        }
        unset($r);
        return $results;
    }

    // ── Addresses added by hand ────────────────────────────────

    public static function custom(): array
    {
        $d = json_decode((string)@file_get_contents(VtDataDir::path('vt_pwned_custom.json')), true);
        return is_array($d) ? $d : [];
    }

    /** Addresses one user sees: all of them for the administrator, otherwise their own */
    public static function customFor(string $login, string $role): array
    {
        return array_filter(self::custom(), fn($e) => $role === 'admin' || ($e['by'] ?? '') === $login);
    }

    public static function addCustom(string $email, string $by): array
    {
        $email = strtolower(trim($email));
        if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) return ['error' => 'That is not an e-mail address'];
        return self::lockedCustom(function (array $all) use ($email, $by) {
            if (isset($all[$email])) return [$all, ['error' => $email . ' is already in the list']];
            if (count($all) >= self::MAX_CUSTOM) return [$all, ['error' => 'At most ' . self::MAX_CUSTOM . ' addresses']];
            $all[$email] = ['by' => $by, 'added' => time()];
            ksort($all);
            return [$all, ['ok' => true, 'email' => $email]];
        });
    }

    public static function removeCustom(string $email, string $login, string $role): array
    {
        $email = strtolower(trim($email));
        return self::lockedCustom(function (array $all) use ($email, $login, $role) {
            if (!isset($all[$email])) return [$all, ['error' => $email . ' is not in the list']];
            if ($role !== 'admin' && ($all[$email]['by'] ?? '') !== $login) return [$all, ['error' => 'Only ' . $all[$email]['by'] . ' or the administrator can remove this address']];
            unset($all[$email]);
            return [$all, ['ok' => true, 'email' => $email]];
        });
    }

    // ── WordPress administrators ───────────────────────────────

    /** Database and table prefix of every WordPress install on disk (root helper, cached for an hour) */
    public static function wpConfigs(): ?array
    {
        $cache = VtDataDir::path('vt_wpconfigs.json');
        if (is_file($cache) && time() - filemtime($cache) < 3600) {
            $d = json_decode((string)file_get_contents($cache), true);
            if (is_array($d)) return $d;
        }
        try {
            $res  = pm_ApiCli::callSbin('site-scan', ['wpconfigs'], pm_ApiCli::RESULT_FULL);
            $list = json_decode(trim((string)($res['stdout'] ?? '')), true)['configs'] ?? null;
        } catch (\Throwable $e) {
            $list = null;
        }
        if (!is_array($list)) return null;
        @file_put_contents($cache, json_encode($list));
        return $list;
    }

    /** Administrators of every hosted WordPress site: [host => [{login, email, registered}]] (cached) */
    public static function accounts(bool $fresh = false): array
    {
        $file = VtDataDir::path('vt_wp_admins.json');
        $c    = json_decode((string)@file_get_contents($file), true);
        if (!$fresh && is_array($c) && time() - (int)($c['t'] ?? 0) < self::ACCOUNTS_TTL && (int)($c['v'] ?? 1) >= 2) return $c['sites'] ?? [];
        $pdo = PleskDomains::pdo();
        if (!$pdo) return is_array($c) ? ($c['sites'] ?? []) : [];
        $hosted  = array_flip(PleskDomains::hostedAll());
        $configs = self::wpConfigs();
        $live    = [];
        foreach ($configs ?? [] as $cf) $live[$cf['db'] . "\0" . $cf['prefix']] = (string)$cf['path'];
        $byHost = [];
        foreach (PleskDomains::wordPressSources() ?? [] as $s) {
            if (isset($hosted[$s['host']])) $byHost[$s['host']][] = $s;
        }
        $sites = [];
        foreach ($byHost as $host => $list) {
            // The install wp-config.php points to; old copies of the site are skipped
            $use = array_values(array_filter($list, fn($s) => isset($live[$s['db'] . "\0" . $s['prefix']])));
            if (!$use) {
                if ($configs !== null && count($list) > 1) usort($list, fn($a, $b) => $b['tables'] <=> $a['tables']);
                $use = [$list[0]];
            }
            foreach ($use as $s) {
                $path = $live[$s['db'] . "\0" . $s['prefix']] ?? '';
                foreach (self::admins($pdo, $s['db'], $s['prefix']) as $a) $sites[$host][$a['email'] . '|' . $a['login']] = $a + ['path' => $path];
            }
            if (isset($sites[$host])) $sites[$host] = array_values($sites[$host]);
        }
        ksort($sites);
        @file_put_contents($file, json_encode(['t' => time(), 'v' => 2, 'sites' => $sites]));
        return $sites;
    }

    private static function admins(\PDO $pdo, string $db, string $prefix): array
    {
        if (!preg_match('/^[A-Za-z0-9_]{0,64}$/', $prefix) || !preg_match('/^[A-Za-z0-9_\-\$]{1,64}$/', $db)) return [];
        $t = fn($n) => '`' . str_replace('`', '', $db) . '`.`' . $prefix . $n . '`';
        try {
            $st = $pdo->prepare('SELECT u.ID, u.user_login, u.user_email, u.user_registered FROM ' . $t('users') . ' u JOIN ' . $t('usermeta')
                . ' m ON m.user_id = u.ID AND m.meta_key = ? WHERE m.meta_value LIKE ? ORDER BY u.user_login LIMIT 200');
            $st->execute([$prefix . 'capabilities', '%"administrator"%']);
            $out = [];
            foreach ($st->fetchAll(\PDO::FETCH_NUM) as [$id, $login, $email, $reg]) {
                $out[] = ['id' => (int)$id, 'login' => (string)$login, 'email' => strtolower(trim((string)$email)),
                          'registered' => $reg && $reg !== '0000-00-00 00:00:00' ? (int)strtotime($reg . ' UTC') : 0];
            }
            return $out;
        } catch (\PDOException $e) {
            return [];
        }
    }

    // ── Nightly ────────────────────────────────────────────────

    /** Check addresses that were never checked, for at most $seconds. Returns [checked, pwned]. */
    public static function checkPending(int $seconds = 600): array
    {
        if (self::source() === '') return [0, 0];
        $emails = array_keys(self::custom());
        foreach (self::accounts() as $list) foreach ($list as $a) $emails[] = $a['email'];
        $emails = array_values(array_unique(array_filter($emails, fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL))));
        $res = self::results();
        $end = time() + $seconds;
        $n = 0; $bad = 0;
        foreach ($emails as $e) {
            if (!self::needsCheck($res[$e] ?? null)) continue;
            while (true) {
                if (time() >= $end) return [$n, $bad];
                $r = self::check($e);
                if (($r['state'] ?? '') !== 'wait') break;
                if ($r['retry_after'] > $end - time()) return [$n, $bad];
                sleep(max(1, (int)$r['retry_after']));
            }
            $n++;
            if (!empty($r['breaches'])) $bad++;
        }
        return [$n, $bad];
    }

    // ── Helpers ────────────────────────────────────────────────

    /** GET → [http code, body, lower-case headers] */
    private static function get(string $url, array $headers = []): array
    {
        $hdr = [];
        $ch  = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15, CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_HTTPHEADER => array_merge(['User-Agent: ' . self::UA, 'Accept: application/json'], $headers),
            CURLOPT_HEADERFUNCTION => function ($c, $line) use (&$hdr) {
                if (strpos($line, ':') !== false) { [$k, $v] = explode(':', $line, 2); $hdr[strtolower(trim($k))] = trim($v); }
                return strlen($line);
            },
        ]);
        $body = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$body === false ? 0 : $code, (string)$body, $hdr];
    }

    private static function lockedResults(callable $fn): void
    {
        self::lockedJson('vt_pwned.json', fn($d) => [$fn($d), null]);
    }

    private static function lockedState(callable $fn): void
    {
        self::lockedJson('vt_pwned_state.json', fn($d) => [$fn($d), null]);
    }

    private static function lockedCustom(callable $fn): array
    {
        return self::lockedJson('vt_pwned_custom.json', $fn, true);
    }

    /** $fn(array $data): [new data, result]; with $onlyOk the data is written only when result['ok'] */
    private static function lockedJson(string $name, callable $fn, bool $onlyOk = false)
    {
        $f  = VtDataDir::path($name);
        $fp = @fopen($f . '.lock', 'c');
        if ($fp) flock($fp, LOCK_EX);
        try {
            $d = json_decode((string)@file_get_contents($f), true);
            [$new, $res] = $fn(is_array($d) ? $d : []);
            if ((!$onlyOk || !empty($res['ok'])) && @file_put_contents($f . '.tmp', json_encode($new)) !== false) @rename($f . '.tmp', $f);
            return $res;
        } finally {
            if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        }
    }
}
