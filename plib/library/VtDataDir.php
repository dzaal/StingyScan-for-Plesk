<?php
/**
 * VtDataDir — centrale locatie voor persistente extensie-data.
 *
 * Binnen Plesk: /usr/local/psa/var/modules/stingyscan/data/
 * CLI/cron:     zelfde pad (altijd beschikbaar op de server)
 */
class VtDataDir
{
    const BASE = '/usr/local/psa/var/modules/stingyscan/data';

    /** Another folder instead of BASE (tests only) */
    private static ?string $base = null;
    public static function useBase(?string $dir): void { self::$base = $dir; }

    public static function path(string $filename): string
    {
        return (self::$base ?? self::BASE) . '/' . $filename;
    }

    public static function ensureExists(): void
    {
        $dir = self::$base ?? self::BASE;
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
    }
}
