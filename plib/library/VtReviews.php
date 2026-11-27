<?php
require_once __DIR__ . '/VtDataDir.php';

/**
 * VtReviews — remembers when a review was requested from a vendor for a site
 * (a click on the vendor's review link in the Why? panel).
 *
 * Stored in vt_reviews.json as:
 *   { "example.com": { "BitDefender": {"ts": 1795297156, "by": "admin"}, ... }, ... }
 */
class VtReviews
{
    private const FILE = 'vt_reviews.json';

    /** All requests for these domains: [domain => [vendor => {ts, by}]] */
    public static function forDomains(array $domains): array
    {
        return array_intersect_key(self::load(), array_flip($domains));
    }

    /** Record (or with $remove, forget) a review request; returns the requests of that domain */
    public static function mark(string $domain, string $vendor, string $by, bool $remove = false): array
    {
        $fp = @fopen(VtDataDir::path(self::FILE . '.lock'), 'c');
        if ($fp) flock($fp, LOCK_EX);
        $all = self::load();
        if ($remove) {
            unset($all[$domain][$vendor]);
            if (empty($all[$domain])) unset($all[$domain]);
        } else {
            $all[$domain][$vendor] = ['ts' => time(), 'by' => $by];
        }
        $f = VtDataDir::path(self::FILE);
        if (@file_put_contents($f . '.tmp', json_encode($all)) !== false) @rename($f . '.tmp', $f);
        if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        return $all[$domain] ?? [];
    }

    /** Record or undo that a vendor confirmed the delisting (adds/removes confirmed_at timestamp) */
    public static function confirm(string $domain, string $vendor, bool $undo = false): array
    {
        $fp = @fopen(VtDataDir::path(self::FILE . '.lock'), 'c');
        if ($fp) flock($fp, LOCK_EX);
        $all = self::load();
        if (isset($all[$domain][$vendor])) {
            if ($undo) unset($all[$domain][$vendor]['confirmed_at']);
            else $all[$domain][$vendor]['confirmed_at'] = time();
        }
        $f = VtDataDir::path(self::FILE);
        if (@file_put_contents($f . '.tmp', json_encode($all)) !== false) @rename($f . '.tmp', $f);
        if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        return $all[$domain] ?? [];
    }

    /**
     * Alert IDs from a vendor's block page (AVG Web Shield), per site: { domain: { avg: "b77f0e8e8af0" } }.
     * Kept so the vendor's false positive form can be opened already filled in.
     */
    private const ALERT_FILE = 'vt_alert_ids.json';

    public static function alertIds(array $domains): array
    {
        $d = json_decode((string)@file_get_contents(VtDataDir::path(self::ALERT_FILE)), true);
        return array_intersect_key(is_array($d) ? $d : [], array_flip($domains));
    }

    /** Store (or with '' remove) the alert ID of a site; returns that site's alert IDs */
    public static function setAlertId(string $domain, string $vendor, string $id): array
    {
        $f  = VtDataDir::path(self::ALERT_FILE);
        $fp = @fopen($f . '.lock', 'c');
        if ($fp) flock($fp, LOCK_EX);
        $all = json_decode((string)@file_get_contents($f), true);
        $all = is_array($all) ? $all : [];
        if ($id === '') { unset($all[$domain][$vendor]); if (empty($all[$domain])) unset($all[$domain]); }
        else $all[$domain][$vendor] = $id;
        if (@file_put_contents($f . '.tmp', json_encode($all)) !== false) @rename($f . '.tmp', $f);
        if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        return $all[$domain] ?? [];
    }

    private static function load(): array
    {
        $d = json_decode((string)@file_get_contents(VtDataDir::path(self::FILE)), true);
        return is_array($d) ? $d : [];
    }
}
