<?php
require_once __DIR__ . '/VtDataDir.php';

/**
 * VtExternal: sites that are NOT hosted on this server, added by hand to watch their reputation.
 *
 * They are listed with the hosted sites (Infected, Suspicious, Clean …) and checked by the online
 * services (VirusTotal, Google Safe Browsing, Avast / AVG). There are no files or databases here,
 * so the file scanners (ClamAV, Maldet, Imunify) and the Pwned check never apply to them.
 *
 * Each Plesk user has their own list; the administrator sees (and may remove) every one.
 * Stored in vt_external.json { domain: {by, role, added} }.
 */
class VtExternal
{
    const MAX = 500; // external sites per server

    private static function file(): string { return VtDataDir::path('vt_external.json'); }

    /** [domain => {by, role, added}] */
    public static function all(): array
    {
        $d = json_decode((string)@file_get_contents(self::file()), true);
        return is_array($d) ? $d : [];
    }

    public static function is(string $domain): bool
    {
        return isset(self::all()[$domain]);
    }

    /** External sites one user sees: every one for the administrator, otherwise the ones they added */
    public static function forUser(string $login, string $role): array
    {
        $out = [];
        foreach (self::all() as $d => $e) {
            if ($role === 'admin' || ($e['by'] ?? '') === $login) $out[] = (string)$d;
        }
        sort($out);
        return $out;
    }

    /** External sites of the user in the current Plesk session ([] when the session is unknown) */
    public static function forCurrentUser(): array
    {
        try {
            $c = class_exists('pm_Session') ? pm_Session::getClient() : null;
            if (!$c) return [];
            return self::forUser($c->getLogin(), $c->isAdmin() ? 'admin' : ($c->isReseller() ? 'reseller' : 'client'));
        } catch (\Throwable $e) {
            return [];
        }
    }

    /** Domain names as typed: "https://www.Example.com/path" → "example.com" ('' when not a domain name) */
    public static function normalize(string $d): string
    {
        $d = strtolower(trim($d));
        $d = preg_replace('#^[a-z]+://#', '', $d);
        $d = preg_replace('#[/?\#].*$#', '', $d);
        $d = preg_replace('/:\d+$/', '', $d);
        $d = preg_replace('/^www\./', '', rtrim($d, '.'));
        if (strlen($d) > 253 || !preg_match('/^(?:[a-z0-9](?:[a-z0-9\-]{0,61}[a-z0-9])?\.)+[a-z][a-z0-9\-]{1,62}$/', $d)) return '';
        return $d;
    }

    /**
     * Add a site. $hosted = the hostnames hosted on this server (those cannot be added).
     * Returns ['ok' => true, 'domain' => …] or ['error' => …].
     */
    public static function add(string $raw, string $by, string $role, array $hosted): array
    {
        $d = self::normalize($raw);
        if ($d === '') return ['error' => 'That is not a domain name'];
        if (in_array($d, $hosted, true)) return ['error' => $d . ' is hosted on this server, so it is already in the list'];
        return self::locked(function (array $all) use ($d, $by, $role) {
            if (isset($all[$d])) return [$all, ['error' => $d . ' is already in the list' . (($all[$d]['by'] ?? '') !== $by ? ' (added by ' . $all[$d]['by'] . ')' : '')]];
            if (count($all) >= self::MAX) return [$all, ['error' => 'At most ' . self::MAX . ' external sites']];
            $all[$d] = ['by' => $by, 'role' => $role, 'added' => time()];
            ksort($all);
            return [$all, ['ok' => true, 'domain' => $d]];
        });
    }

    /** Remove a site: the user who added it, or the administrator */
    public static function remove(string $d, string $login, string $role): array
    {
        return self::locked(function (array $all) use ($d, $login, $role) {
            if (!isset($all[$d])) return [$all, ['error' => $d . ' is not an external site']];
            if ($role !== 'admin' && ($all[$d]['by'] ?? '') !== $login) return [$all, ['error' => 'Only ' . $all[$d]['by'] . ' or the administrator can remove this site']];
            unset($all[$d]);
            return [$all, ['ok' => true, 'domain' => $d]];
        });
    }

    /** Read, change and write the list under a lock. $fn(array $all): [new list, result] */
    private static function locked(callable $fn): array
    {
        $f  = self::file();
        $fp = @fopen($f . '.lock', 'c');
        if ($fp) flock($fp, LOCK_EX);
        try {
            [$all, $res] = $fn(self::all());
            if (!empty($res['ok']) && @file_put_contents($f . '.tmp', json_encode($all, JSON_PRETTY_PRINT)) !== false) @rename($f . '.tmp', $f);
            return $res;
        } finally {
            if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        }
    }
}
