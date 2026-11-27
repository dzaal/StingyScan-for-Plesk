<?php
require_once __DIR__ . '/VtDataDir.php';
require_once __DIR__ . '/VtSettings.php';

/**
 * VtPanelNotify — Stingy Scanner news in Plesk's own notifications (the bell at the top of Plesk), for the
 * administrator. Which kinds are sent is a setting (panel_notify, Settings → Notifications); Plesk itself can also
 * switch each kind off (Tools & Settings → Notifications → Panel). Status changes are collected and sent as one
 * notification per kind when the 5-minute or nightly task runs; admin changes are sent right after the hourly check.
 */
class VtPanelNotify
{
    const CODE_PREFIX = 'stingyscan_';
    const KINDS = [
        'infected'     => ['title' => 'site became infected',          'category' => 'Alert',       'area' => 'Security'],
        'suspicious'   => ['title' => 'site became suspicious',        'category' => 'Warning',     'area' => 'Security'],
        'clean'        => ['title' => 'site is clean again',           'category' => 'Information', 'area' => 'Security'],
        'admin_change' => ['title' => 'admin rights changed on a site','category' => 'Warning',     'area' => 'Accounts'],
        'test'         => ['title' => 'test notification',             'category' => 'Alert',       'area' => 'Security'], // an Alert, like an infected site, so it shows the same way
    ];
    const DEFAULT = ['infected', 'suspicious', 'admin_change'];
    private const QUEUE = 'vt_panel_queue.json';

    /** Kinds switched on in Settings */
    public static function kinds(): array
    {
        $v = (new VtSettings('admin'))->get('panel_notify', null);
        return is_array($v) ? array_values(array_intersect($v, array_keys(self::KINDS))) : self::DEFAULT;
    }

    public static function available(): bool
    {
        return class_exists('pm_Notification') && class_exists('pm_Notifications_PanelNotification');
    }

    /** A status change of a site: remembered until the next flush (only for kinds that are switched on) */
    public static function statusChanged(string $domain, ?string $from, string $to): void
    {
        if (!isset(self::KINDS[$to]) || $to === 'test' || !in_array($to, self::kinds(), true)) return;
        if ($to === 'clean' && !in_array($from, ['infected', 'suspicious'], true)) return;
        self::queue(function (array $q) use ($domain, $from, $to) {
            foreach (['infected', 'suspicious', 'clean'] as $k) unset($q[$k][$domain]); // the latest change per site wins
            $q[$to][$domain] = $from;
            return $q;
        });
    }

    /** Send the collected status changes: one notification per kind */
    public static function flush(): int
    {
        $sent = 0;
        $q = self::queue(fn(array $q) => []);   // take everything, leave an empty queue
        foreach (['infected', 'suspicious', 'clean'] as $kind) {
            $sites = array_keys($q[$kind] ?? []);
            if (!$sites || !in_array($kind, self::kinds(), true)) continue;
            $n = count($sites);
            $word = ['infected' => 'became infected', 'suspicious' => 'became suspicious', 'clean' => 'are clean again'][$kind];
            $subject = $n === 1 ? $sites[0] . ' ' . ($kind === 'clean' ? 'is clean again' : $word)
                                : $n . ' sites ' . $word;
            $message = ($n === 1 ? 'According to VirusTotal, ' . $sites[0] . ' ' . ($kind === 'clean' ? 'is clean again' : $word) . '.'
                                 : 'According to VirusTotal: ' . implode(', ', array_slice($sites, 0, 12)) . ($n > 12 ? ' and ' . ($n - 12) . ' more' : '') . '.')
                     . ($kind === 'clean' ? '' : ' Open Stingy Scanner to see which vendors flag ' . ($n === 1 ? 'it' : 'them') . ' and what to do.');
            if (self::send($kind, $subject, $message)) $sent++;
        }
        return $sent;
    }

    /** Admin rights changed (from the hourly admin check): one notification */
    public static function adminChanges(array $events): bool
    {
        if (!$events || !in_array('admin_change', self::kinds(), true)) return false;
        $sites = array_values(array_unique(array_column($events, 'host')));
        $n = count($events); $s = count($sites);
        $subject = 'Admin rights changed on ' . ($s === 1 ? $sites[0] : $s . ' sites');
        $first = $events[0];
        $message = $n . ' change' . ($n === 1 ? '' : 's') . ' to review'
            . ($n === 1 ? ': ' . (($first['login'] ?? '') !== '' ? $first['login'] . ' on ' : '') . $first['host']
                        : ' on ' . implode(', ', array_slice($sites, 0, 8)) . ($s > 8 ? ' and ' . ($s - 8) . ' more' : ''))
            . '. Approve it if you or the site owner did this; if not, the site is probably hacked.';
        return self::send('admin_change', $subject, $message);
    }

    public static function test(): bool
    {
        return self::send('test', 'Test from Stingy Scanner', 'Plesk notifications from Stingy Scanner work. Choose which kinds you get in Stingy Scanner → Settings → Notifications.');
    }

    /** One panel notification to the administrator; false when Plesk can't (older Plesk, or outside the panel) */
    public static function send(string $kind, string $subject, string $message): bool
    {
        if (!self::available()) return false;
        try {
            $link = class_exists('pm_Context') ? pm_Context::getActionUrl('index') : '';
            (new pm_Notification())->send(self::CODE_PREFIX . $kind, ['subject' => mb_substr($subject, 0, 250), 'message' => $message, 'link' => $link]);
            return true;
        } catch (\Throwable $e) {
            @error_log('Stingy Scanner panel notification failed: ' . $e->getMessage());
            return false;
        }
    }

    private static function queue(callable $change): array
    {
        $f  = VtDataDir::path(self::QUEUE);
        $fp = @fopen($f . '.lock', 'c');
        if ($fp) flock($fp, LOCK_EX);
        $q = json_decode((string)@file_get_contents($f), true);
        $q = is_array($q) ? $q : [];
        $new = $change($q);
        if (@file_put_contents($f . '.tmp', json_encode($new)) !== false) @rename($f . '.tmp', $f);
        if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        return $q;
    }
}
