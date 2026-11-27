<?php
require_once __DIR__ . '/VtDataDir.php';
require_once __DIR__ . '/VtSettings.php';
require_once __DIR__ . '/PleskDomains.php';

/**
 * VtAdminWatch: who has admin rights on each WordPress site (and on each Joomla, Drupal, Wotan, Nextcloud,
 * WHMCS and Laravel site that Pwned Admins reads), and what changed since the last scan.
 *
 * The strongest sign of a fake admin is not what an account looks like but that admin rights appeared
 * where there were none. So every WordPress install gets a baseline (the first scan) and each scan
 * after it is compared with the one before:
 *
 *   new_admin      a new account with admin rights
 *   promoted       an existing account got admin rights (with its previous role)
 *   caps           admin rights through capabilities, without the administrator role
 *   role_changed   a role (other than administrator) got admin capabilities
 *   super_admin    a new Multisite super admin
 *   email_changed  the e-mail address of an admin changed (possible account takeover)
 *   app_password   a new application password for an admin (a login that skips 2FA)
 *   removed        an account lost its admin rights or was deleted (information)
 *
 * "Admin rights" = the administrator role, or any role or capability that allows taking over the site
 * (DANGER below). Events of trusted addresses (Settings) are approved automatically; the others wait
 * for the administrator to approve them, and are e-mailed once.
 */
class VtAdminWatch
{
    const FILE  = 'vt_admin_watch.json';
    const EVERY = 3600; // scan at most once an hour (the 5-minute task asks)
    /** Capabilities that give control over the site: whoever has one of them can make themselves administrator */
    const DANGER = ['manage_options', 'promote_users', 'create_users', 'edit_users', 'delete_users', 'install_plugins', 'activate_plugins',
                    'edit_plugins', 'upload_plugins', 'install_themes', 'edit_themes', 'update_core', 'unfiltered_upload',
                    'manage_network', 'manage_sites', 'manage_network_users', 'manage_network_options'];
    /** Events that need a look (removed is information only) */
    const REVIEW = ['new_admin', 'promoted', 'caps', 'role_changed', 'super_admin', 'email_changed', 'app_password'];
    const LABELS = ['new_admin' => 'New admin account', 'promoted' => 'Existing account got admin rights', 'caps' => 'Admin rights without the administrator role',
                    'role_changed' => 'A role got admin rights', 'super_admin' => 'New Multisite super admin', 'email_changed' => 'Admin e-mail address changed',
                    'app_password' => 'New application password for an admin', 'removed' => 'Admin rights removed'];

    // ── Snapshot of one install ─────────────────────────────────

    /**
     * {users: {id: {login, email, registered, roles[], caps[], super, app: {uuid: name}}}, lesser: {id: "editor,…"},
     *  roles: {role: [danger caps]}} or null when the tables cannot be read
     */
    public static function snapshot(\PDO $pdo, string $db, string $prefix): ?array
    {
        if (!preg_match('/^[A-Za-z0-9_]{0,64}$/', $prefix) || !preg_match('/^[A-Za-z0-9_\-\$]{1,64}$/', $db)) return null;
        $t = fn($n) => '`' . str_replace('`', '', $db) . '`.`' . $prefix . $n . '`';
        try {
            // Roles and which of them hold admin capabilities
            $st = $pdo->prepare('SELECT option_value FROM ' . $t('options') . ' WHERE option_name = ? LIMIT 1');
            $st->execute([$prefix . 'user_roles']);
            $defs  = @unserialize((string)$st->fetchColumn(), ['allowed_classes' => false]);
            $roles = [];
            foreach (is_array($defs) ? $defs : [] as $role => $def) {
                $caps = array_keys(array_filter((array)($def['capabilities'] ?? []), fn($v) => (bool)$v));
                $d = array_values(array_intersect(self::DANGER, $caps));
                if ($role === 'shop_manager') $d = array_values(array_diff($d, ['edit_users'])); // WooCommerce: may only edit customers
                if ($d || $role === 'administrator') { sort($d); $roles[(string)$role] = $d; }
            }
            // Every account with a role other than only subscriber or customer
            $st = $pdo->prepare('SELECT u.ID, u.user_login, u.user_email, u.user_registered, m.meta_value FROM ' . $t('users') . ' u JOIN ' . $t('usermeta')
                . ' m ON m.user_id = u.ID AND m.meta_key = ? WHERE m.meta_value NOT IN (?, ?, ?) LIMIT 5000');
            $st->execute([$prefix . 'capabilities', 'a:1:{s:10:"subscriber";b:1;}', 'a:1:{s:8:"customer";b:1;}', 'a:0:{}']);
            $rows = $st->fetchAll(\PDO::FETCH_NUM);
            // Multisite super admins (only when the network table exists)
            $supers = [];
            try {
                $v = $pdo->query('SELECT meta_value FROM ' . $t('sitemeta') . " WHERE meta_key = 'site_admins' LIMIT 1")->fetchColumn();
                $supers = array_map('strval', (array)@unserialize((string)$v, ['allowed_classes' => false]));
            } catch (\PDOException $e) {}
        } catch (\PDOException $e) {
            return null;
        }
        $users = []; $lesser = [];
        foreach ($rows as [$id, $login, $email, $reg, $raw]) {
            $c = @unserialize((string)$raw, ['allowed_classes' => false]);
            if (!is_array($c)) continue;
            $on    = array_keys(array_filter($c, fn($v) => (bool)$v));
            $rs    = array_values(array_filter($on, fn($k) => isset($defs[$k]) || $k === 'administrator'));
            $caps  = array_values(array_intersect(self::DANGER, array_diff($on, $rs)));
            $admin = (bool)array_filter($rs, fn($r) => isset($roles[$r])) || $caps || in_array((string)$login, $supers, true);
            if (!$admin) { if ($rs) $lesser[(int)$id] = implode(',', $rs); continue; }
            sort($caps);
            $users[(int)$id] = ['login' => (string)$login, 'email' => strtolower(trim((string)$email)),
                                'registered' => $reg && $reg !== '0000-00-00 00:00:00' ? (int)strtotime($reg . ' UTC') : 0,
                                'roles' => $rs, 'caps' => $caps, 'super' => in_array((string)$login, $supers, true), 'app' => []];
        }
        foreach ($supers as $login) { // a super admin can be listed without a role on the main site
            if (!array_filter($users, fn($u) => $u['login'] === $login)) {
                try {
                    $st = $pdo->prepare('SELECT ID, user_email, user_registered FROM ' . $t('users') . ' WHERE user_login = ? LIMIT 1');
                    $st->execute([$login]);
                    if ($r = $st->fetch(\PDO::FETCH_NUM)) $users[(int)$r[0]] = ['login' => $login, 'email' => strtolower(trim((string)$r[1])),
                        'registered' => (int)strtotime($r[2] . ' UTC'), 'roles' => [], 'caps' => [], 'super' => true, 'app' => []];
                } catch (\PDOException $e) {}
            }
        }
        // Application passwords of the admins (uuid => name)
        if ($users) {
            try {
                $ids = implode(',', array_map('intval', array_keys($users)));
                foreach ($pdo->query('SELECT user_id, meta_value FROM ' . $t('usermeta') . " WHERE meta_key = '_application_passwords' AND user_id IN ($ids)")->fetchAll(\PDO::FETCH_NUM) as [$uid, $v]) {
                    foreach ((array)@unserialize((string)$v, ['allowed_classes' => false]) as $p) {
                        if (is_array($p) && !empty($p['uuid'])) $users[(int)$uid]['app'][(string)$p['uuid']] = ['name' => (string)($p['name'] ?? ''), 'created' => (int)($p['created'] ?? 0)];
                    }
                }
            } catch (\PDOException $e) {}
        }
        if (count($lesser) > 500) $lesser = array_slice($lesser, 0, 500, true);
        return ['users' => $users, 'lesser' => $lesser, 'roles' => $roles];
    }

    // ── Scan all installs ───────────────────────────────────────

    /** Scan when the last scan is older than EVERY seconds (or $force). Returns the new events. */
    public static function scan(bool $force = false): array
    {
        $state = self::load();
        if (!$force && time() - (int)($state['t'] ?? 0) < self::EVERY) return [];
        $lock = @fopen(VtDataDir::path('vt_admin_watch.lock'), 'c');
        if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) return [];
        require_once __DIR__ . '/VtPwned.php';
        $pdo = PleskDomains::pdo();
        if (!$pdo) return [];
        $now = time(); $new = [];
        $state = self::load(); // again, inside the lock
        $seen  = [];
        foreach (VtPwned::wpInstalls() as $host => $list) {
            foreach ($list as $s) {
                $key  = $s['db'] . '|' . $s['prefix'];
                if (isset($seen[$key])) continue; // one database used by two host names
                $seen[$key] = true;
                $snap = self::snapshot($pdo, $s['db'], $s['prefix']);
                if ($snap === null) continue;
                $old  = $state['installs'][$key] ?? null;
                $base = ['key' => $key, 'host' => $host, 'cms' => 'WordPress', 'from' => (int)($old['t'] ?? 0), 'to' => $now];
                if ($old) foreach (self::diff($old, $snap) as $ev) $new[] = $ev + $base;
                // When each account got its admin rights (or the first scan that saw it)
                foreach ($snap['users'] as $id => &$u) {
                    $was = $old['users'][$id] ?? null;
                    $u['since'] = $was['since'] ?? ($old ? $now : 0); // 0 = already admin at the first scan (baseline)
                }
                unset($u);
                $state['installs'][$key] = $snap + ['host' => $host, 'path' => (string)($s['path'] ?? ''), 't' => $now, 'first' => (int)($old['first'] ?? $now)];
            }
        }
        // Joomla, Drupal, Wotan, Nextcloud, WHMCS and Laravel: their administrators (read for Pwned Admins too)
        $other = [];
        foreach (VtPwned::accounts(true) as $host => $list) {
            foreach ($list as $a) {
                if (($a['type'] ?? 'wordpress') === 'wordpress') continue;
                $key = 'cms:' . ($a['cms'] ?? '') . '|' . $host . rtrim((string)($a['base'] ?? ''), '/');
                $other[$key]['host'] = $host;
                $other[$key]['cms']  = (string)($a['cms'] ?? '');
                $other[$key]['users'][(int)($a['id'] ?? 0) ?: crc32($a['login'])] = ['login' => (string)$a['login'], 'email' => (string)$a['email'],
                    'registered' => (int)($a['registered'] ?? 0), 'roles' => [strtolower((string)($a['cms'] ?? '')) . ' administrator'], 'caps' => [], 'super' => false, 'app' => []];
            }
        }
        foreach ($other as $key => $o) {
            $seen[$key] = true;
            $snap = ['users' => $o['users'], 'lesser' => [], 'roles' => []];
            $old  = $state['installs'][$key] ?? null;
            $base = ['key' => $key, 'host' => $o['host'], 'cms' => $o['cms'], 'from' => (int)($old['t'] ?? 0), 'to' => $now];
            if ($old) foreach (self::diff($old, $snap) as $ev) $new[] = $ev + $base;
            foreach ($snap['users'] as $id => &$u) $u['since'] = $old['users'][$id]['since'] ?? ($old ? $now : 0);
            unset($u);
            $state['installs'][$key] = $snap + ['host' => $o['host'], 'cms' => $o['cms'], 't' => $now, 'first' => (int)($old['first'] ?? $now)];
        }
        // Installs that are gone (site deleted) are forgotten
        foreach (array_keys($state['installs'] ?? []) as $k) if (!isset($seen[$k])) unset($state['installs'][$k]);
        // Trusted addresses approve their own events
        $trusted = self::trusted();
        foreach ($new as &$ev) {
            $ev['id'] = substr(sha1($ev['key'] . '|' . $ev['type'] . '|' . ($ev['uid'] ?? '') . '|' . ($ev['detail'] ?? '') . '|' . $now), 0, 12);
            $ev['t']  = $now;
            if (in_array($ev['type'], self::REVIEW, true) && self::isTrusted($ev['email'] ?? '', $trusted)) $ev['approved'] = ['by' => 'trusted list', 'at' => $now];
        }
        unset($ev);
        $state['events'] = array_slice(array_merge($new, $state['events'] ?? []), 0, 500);
        $state['t'] = $now;
        self::save($state);
        flock($lock, LOCK_UN);
        $mail = array_values(array_filter($new, fn($e) => in_array($e['type'], self::REVIEW, true) && empty($e['approved'])));
        if ($mail) self::mail($mail);
        if ($mail) {
            try { require_once __DIR__ . '/VtPanelNotify.php'; VtPanelNotify::adminChanges($mail); } catch (\Throwable $e) {}
        }
        return $new;
    }

    /** What changed between two snapshots of one install */
    private static function diff(array $old, array $new): array
    {
        $out = [];
        $ou = $old['users'] ?? []; $nu = $new['users'];
        foreach ($nu as $id => $u) {
            $who = ['uid' => $id, 'login' => $u['login'], 'email' => $u['email']];
            $via = self::via($u);
            if (!isset($ou[$id])) {
                $isNew = $u['registered'] >= (int)($old['t'] ?? 0) - 120;
                $type  = $u['super'] && !$u['roles'] && !$u['caps'] ? 'super_admin' : (!$u['roles'] && $u['caps'] ? 'caps' : ($isNew ? 'new_admin' : 'promoted'));
                $prev  = $isNew ? '' : (string)($old['lesser'][$id] ?? 'subscriber or customer (or no role)');
                $out[] = $who + ['type' => $type, 'detail' => $via, 'prev' => $prev, 'registered' => $u['registered']];
                continue;
            }
            $o = $ou[$id];
            if ($o['email'] !== $u['email']) $out[] = $who + ['type' => 'email_changed', 'detail' => $o['email'] . ' → ' . $u['email'], 'prev' => $o['email']];
            if ($u['super'] && empty($o['super'])) $out[] = $who + ['type' => 'super_admin', 'detail' => 'super admin of the network', 'prev' => ''];
            $addCaps = array_diff($u['caps'], $o['caps'] ?? []);
            if ($addCaps && !in_array('administrator', $u['roles'], true)) $out[] = $who + ['type' => 'caps', 'detail' => 'got ' . implode(', ', $addCaps), 'prev' => self::via($o)];
            foreach (array_diff_key($u['app'] ?? [], $o['app'] ?? []) as $uuid => $p) {
                $out[] = $who + ['type' => 'app_password', 'detail' => '"' . ($p['name'] ?? '') . '"' . (!empty($p['created']) ? ' created ' . gmdate('Y-m-d H:i', (int)$p['created']) . ' UTC' : ''), 'prev' => ''];
            }
        }
        foreach ($ou as $id => $o) {
            if (!isset($nu[$id])) $out[] = ['uid' => $id, 'login' => $o['login'], 'email' => $o['email'], 'type' => 'removed',
                                            'detail' => isset($new['lesser'][$id]) ? 'now ' . $new['lesser'][$id] : 'account deleted or no role left', 'prev' => self::via($o)];
        }
        foreach ($new['roles'] as $role => $caps) {
            if ($role === 'administrator') continue;
            $add = array_diff($caps, $old['roles'][$role] ?? []);
            if ($add) $out[] = ['uid' => 0, 'login' => '', 'email' => '', 'type' => 'role_changed', 'detail' => 'role "' . $role . '" got ' . implode(', ', $add), 'prev' => ''];
        }
        return $out;
    }

    /** How an account has its admin rights, in words */
    public static function via(array $u): string
    {
        $p = [];
        if ($u['roles'] ?? []) $p[] = 'role ' . implode(', ', $u['roles']);
        if ($u['caps'] ?? []) $p[] = 'capabilities ' . implode(', ', $u['caps']);
        if (!empty($u['super'])) $p[] = 'super admin';
        return implode(' + ', $p);
    }

    // ── Reading ─────────────────────────────────────────────────

    /** Events, newest first; $open = only the ones still to review */
    public static function events(bool $open = false): array
    {
        $ev = self::load()['events'] ?? [];
        if ($open) $ev = array_values(array_filter($ev, fn($e) => in_array($e['type'], self::REVIEW, true) && empty($e['approved'])));
        foreach ($ev as &$e) $e['label'] = self::LABELS[$e['type']] ?? $e['type'];
        return $ev;
    }

    /** One install by database and prefix (the details panel of a site) */
    public static function install(string $db, string $prefix): ?array
    {
        return self::load()['installs'][$db . '|' . $prefix] ?? null;
    }

    public static function lastScan(): int { return (int)(self::load()['t'] ?? 0); }

    /**
     * Addresses with admin rights on sites of more than one customer, that are not trusted:
     * [email => [{host, owner}]]. A maintainer works across sites too: trust those addresses in Settings.
     */
    public static function crossSite(): array
    {
        $by = [];
        foreach (self::load()['installs'] ?? [] as $i) foreach ($i['users'] ?? [] as $u) if ($u['email'] !== '') $by[$u['email']][$i['host']] = true;
        $by = array_filter($by, fn($h) => count($h) > 1);
        if (!$by) return [];
        $owners = PleskDomains::owners(array_keys(array_merge(...array_values($by))));
        $trusted = self::trusted(); $out = [];
        foreach ($by as $email => $hosts) {
            if (self::isTrusted($email, $trusted)) continue;
            $who = [];
            foreach (array_keys($hosts) as $h) $who[$h] = ($owners[$h]['ct'] ?? '') === 'admin' ? 'admin' : (($owners[$h]['cl'] ?? '') ?: $h);
            if (count(array_unique($who)) < 2) continue;
            foreach ($who as $h => $o) $out[$email][] = ['host' => $h, 'owner' => $owners[$h]['c'] ?? ''];
        }
        return $out;
    }

    // ── Approve and trust ───────────────────────────────────────

    /** Approve one event (and so the account it is about) */
    public static function approve(string $id, string $by): ?array
    {
        $found = null;
        self::locked(function (array $s) use ($id, $by, &$found) {
            foreach ($s['events'] ?? [] as $i => $e) {
                if (($e['id'] ?? '') === $id) { $s['events'][$i]['approved'] = ['by' => $by, 'at' => time()]; $found = $s['events'][$i]; }
            }
            return $s;
        });
        return $found;
    }

    /** Trusted addresses and domains (Settings): "name@example.com" or "@example.com" */
    public static function trusted(): array
    {
        $v = (new VtSettings('admin'))->get('admin_trusted', []);
        return array_values(array_filter(array_map(fn($x) => strtolower(trim((string)$x)), is_array($v) ? $v : preg_split('/[\s,;]+/', (string)$v))));
    }

    public static function isTrusted(string $email, ?array $list = null): bool
    {
        $email = strtolower(trim($email));
        if ($email === '') return false;
        foreach ($list ?? self::trusted() as $t) {
            if ($t === $email || ($t[0] === '@' && str_ends_with($email, $t))) return true;
        }
        return false;
    }

    // ── E-mail ──────────────────────────────────────────────────

    private static function mail(array $events): void
    {
        $adm = new VtSettings('admin');
        if (!(bool)$adm->get('admin_watch_mail', true)) return;
        require_once __DIR__ . '/VtNotifier.php';
        $to = trim((string)$adm->get('notify_email', '')) ?: (VtNotifier::emailOfLogin('admin') ?? '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) return;
        $n = count($events);
        $L = ['Admin rights changed in ' . $n . ' place' . ($n === 1 ? '' : 's') . ' since the last scan.', ''];
        foreach ($events as $e) {
            $L[] = '* ' . $e['host'] . ' (' . ($e['cms'] ?? 'WordPress') . '): ' . (self::LABELS[$e['type']] ?? $e['type']);
            if ($e['login'] !== '') $L[] = '  account: ' . $e['login'] . ' <' . $e['email'] . '>';
            if ($e['detail'] !== '') $L[] = '  ' . $e['detail'];
            if (($e['prev'] ?? '') !== '') $L[] = '  before: ' . $e['prev'];
            $L[] = '';
        }
        $L[] = 'If you or the site owner did this, approve it in Stingy Scanner (Dashboard, Admin changes).';
        $L[] = 'If nobody did: the site is probably hacked. Remove the account, reset all admin passwords,';
        $L[] = 'and scan the site\'s files. "Explain" shows the requests to the WordPress admin around that time.';
        $sites = count(array_unique(array_column($events, 'host')));
        VtNotifier::sendRaw($to, 'Admin rights changed on ' . $sites . ' site' . ($sites === 1 ? '' : 's'), implode("\n", $L) . "\n");
    }

    // ── Storage ─────────────────────────────────────────────────

    private static function load(): array
    {
        $d = json_decode((string)@file_get_contents(VtDataDir::path(self::FILE)), true);
        return is_array($d) ? $d : [];
    }

    private static function save(array $s): void
    {
        $f = VtDataDir::path(self::FILE);
        @file_put_contents($f . '.tmp', json_encode($s));
        @rename($f . '.tmp', $f);
    }

    private static function locked(callable $fn): void
    {
        $lock = @fopen(VtDataDir::path('vt_admin_watch.lock'), 'c');
        if ($lock) flock($lock, LOCK_EX);
        self::save($fn(self::load()));
        if ($lock) flock($lock, LOCK_UN);
    }
}
