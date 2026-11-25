<?php
require_once __DIR__ . '/VtDataDir.php';

/**
 * VtServerName: the name of this server as people know it.
 *
 * The machine's own host name (gethostname(), for example vps42.example.net) is often not the
 * name the administrator uses to open Plesk (for example server22.example.com). Stingy Scanner
 * remembers the name the administrator last used in the browser, and uses it in e-mails and links,
 * with the internal name in brackets when it differs.
 *
 * Stored in vt_server_name.json { host: "server22.example.com", port: 8443, at }.
 */
class VtServerName
{
    private static function file(): string { return VtDataDir::path('vt_server_name.json'); }

    /** Remember the host name from the browser's request (administrator only; IP addresses are ignored) */
    public static function remember(string $httpHost): void
    {
        $httpHost = strtolower(trim($httpHost));
        if (!preg_match('/^([a-z0-9][a-z0-9.\-]*\.[a-z][a-z0-9\-]+)(?::(\d{1,5}))?$/', $httpHost, $m)) return; // not a name (or an IP address)
        $host = $m[1];
        $port = isset($m[2]) ? (int)$m[2] : 443;
        $old  = self::load();
        if (($old['host'] ?? '') === $host && (int)($old['port'] ?? 0) === $port) return;
        @file_put_contents(self::file(), json_encode(['host' => $host, 'port' => $port, 'at' => time()]));
    }

    private static function load(): array
    {
        $d = json_decode((string)@file_get_contents(self::file()), true);
        return is_array($d) ? $d : [];
    }

    /** The machine's own host name */
    public static function internal(): string
    {
        return strtolower((string)(gethostname() ?: 'localhost'));
    }

    /** The name the administrator uses (falls back to the internal name) */
    public static function used(): string
    {
        return (string)(self::load()['host'] ?? '') ?: self::internal();
    }

    /** "server22.example.com (vps42.example.net)", or just the name when both are the same */
    public static function label(): string
    {
        $u = self::used(); $i = self::internal();
        return $u === $i ? $u : $u . ' (' . $i . ')';
    }

    /** Address of Stingy Scanner on this server, as the administrator opens it */
    public static function panelUrl(): string
    {
        $d = self::load();
        $port = (int)($d['port'] ?? 8443);
        if (empty($d['host'])) $port = 8443;
        return 'https://' . self::used() . ($port === 443 ? '' : ':' . $port) . '/modules/stingyscan/';
    }
}
