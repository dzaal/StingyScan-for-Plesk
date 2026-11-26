<?php
declare(strict_types=1);

/**
 * Private dashboard (/dashboard): login with the user and password hash from the config, a hardened session
 * cookie, CSRF tokens on every form, and a rate limit on login attempts. Per project:
 *   active installations (seen in the last active_days), active installations by version,
 *   the total of the count field across active installations, and one row per installation.
 * Totals use the latest check-in per installation only (the table keeps nothing else).
 */
final class Dashboard
{
    /** @param callable():Store $store */
    public function __construct(private array $cfg, private $store, private RateLimiter $rate) {}

    public function run(string $method, string $ip, int $now): void
    {
        header('Cache-Control: no-store');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Referrer-Policy: no-referrer');
        header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; form-action 'self'; frame-ancestors 'none'; base-uri 'none'");
        session_name('stats_sid');
        session_set_cookie_params(['lifetime' => 0, 'path' => '/dashboard', 'secure' => (bool)($this->cfg['cookie_secure'] ?? true), 'httponly' => true, 'samesite' => 'Strict']);
        ini_set('session.use_strict_mode', '1');
        session_start();
        $_SESSION['csrf'] ??= bin2hex(random_bytes(16));
        $csrf = $_SESSION['csrf'];
        $error = '';

        if ($method === 'POST') {
            if (!hash_equals($csrf, (string)($_POST['csrf'] ?? ''))) { http_response_code(400); $this->page('<p>Form expired. Reload the page.</p>'); return; }
            $act = (string)($_POST['act'] ?? '');
            if ($act === 'logout') { $_SESSION = []; session_regenerate_id(true); header('Location: /dashboard', true, 303); return; }
            if ($act === 'login') {
                if (!$this->rate->hit('login:' . $ip, (int)($this->cfg['rate']['login_per_15min'] ?? 10), 900, $now)) {
                    $error = 'Too many attempts. Try again in 15 minutes.';
                } elseif ($this->checkLogin((string)($_POST['user'] ?? ''), (string)($_POST['password'] ?? ''))) {
                    session_regenerate_id(true);
                    $_SESSION['auth'] = true; $_SESSION['csrf'] = bin2hex(random_bytes(16));
                    header('Location: /dashboard', true, 303); return;
                } else {
                    $error = 'Wrong user name or password.';
                }
            }
        }
        if (empty($_SESSION['auth'])) { $this->loginForm($csrf, $error); return; }
        $this->overview((string)($_GET['project'] ?? ''), $csrf, $now);
    }

    private function checkLogin(string $user, string $pass): bool
    {
        $d = $this->cfg['dashboard'] ?? [];
        $okUser = hash_equals((string)($d['user'] ?? ''), $user);
        $okPass = password_verify($pass, (string)($d['password_hash'] ?? '')); // always run: same time for a wrong user
        return $okUser && $okPass && (string)($d['user'] ?? '') !== '';
    }

    private function loginForm(string $csrf, string $error): void
    {
        $this->page('<h1>Statistics</h1>' . ($error !== '' ? '<p class="err">' . self::e($error) . '</p>' : '')
            . '<form method="post" class="login"><input type="hidden" name="csrf" value="' . self::e($csrf) . '"><input type="hidden" name="act" value="login">'
            . '<label>User <input name="user" autocomplete="username" required></label>'
            . '<label>Password <input type="password" name="password" autocomplete="current-password" required></label>'
            . '<button>Log in</button></form>');
    }

    private function overview(string $project, string $csrf, int $now): void
    {
        $projects = $this->cfg['projects'];
        $days = (int)($this->cfg['active_days'] ?? 30);
        try {
            $store = ($this->store)();
            $h = '<form method="post" class="logout"><input type="hidden" name="csrf" value="' . self::e($csrf) . '"><input type="hidden" name="act" value="logout"><button>Log out</button></form>';
            $h .= isset($projects[$project]) ? $this->projectPage($store, $project, $projects[$project], $now, $days)
                                             : $this->allProjects($store, $projects, $now, $days);
        } catch (\Throwable $e) {
            error_log('stats dashboard: storage error (' . get_class($e) . ')');
            $this->page('<p class="err">The database is not available.</p>'); return;
        }
        $this->page($h);
    }

    /** One card per project: active installations, change over 30 days, trend, newest version, totals */
    private function allProjects(Store $store, array $projects, int $now, int $days): string
    {
        $h = '<h1>Installation statistics</h1><p><small>Active = checked in during the last ' . $days . ' days. Self-reported by installations whose administrator switched sharing on.</small></p><div class="cards">';
        foreach ($projects as $key => $p) {
            $s = $store->summary($key, $p, $now, $days);
            $t = $store->trend($key, $now, 90);
            $then = $t ? $t[0]['active'] : null;
            $delta = $then === null ? '' : (($d = $s['active'] - $then) === 0 ? 'no change' : ($d > 0 ? '+' : '') . $d) . ' since ' . self::e($t[0]['day']);
            $h .= '<a class="card" href="/dashboard?project=' . rawurlencode($key) . '"><span class="name">' . self::e((string)$p['name']) . '</span>'
                . '<b>' . $s['active'] . '</b><span>active installation' . ($s['active'] === 1 ? '' : 's') . ($delta ? ' · ' . $delta : '') . '</span>'
                . self::spark(array_column($t, 'active'), 260, 46)
                . '<span>' . ($s['versions'] ? 'newest version ' . self::e((string)array_key_first($s['versions'])) . ' · ' : '') . $s['new'] . ' new in ' . $days . ' days</span>';
            foreach ($s['fields'] as $name => $f) if (isset($f['sum'])) $h .= '<span>' . number_format($f['sum']) . ' ' . self::e(strtolower((string)($p['fields'][$name]['label'] ?? $name))) . '</span>';
            $h .= '</a>';
        }
        return $h . '</div>';
    }

    private function projectPage(Store $store, string $key, array $p, int $now, int $days): string
    {
        $s = $store->summary($key, $p, $now, $days);
        $t = $store->trend($key, $now, 365);
        $h = '<p><a href="/dashboard">← All projects</a></p><h1>' . self::e((string)$p['name']) . '</h1>';
        if (!empty($p['url'])) $h .= '<p><small>' . self::e((string)$p['url']) . '</small></p>';
        $h .= '<div class="tiles"><div><b>' . $s['active'] . '</b>active installations<br><small>seen in the last ' . $days . ' days</small></div>'
            . '<div><b>' . $s['new'] . '</b>new<br><small>first seen in the last ' . $days . ' days</small></div>';
        foreach ($s['fields'] as $name => $f) if (isset($f['sum'])) $h .= '<div><b>' . number_format($f['sum']) . '</b>' . self::e((string)($p['fields'][$name]['label'] ?? $name)) . '<br><small>total of the active installations</small></div>';
        $h .= '<div><b>' . $s['stored'] . '</b>stored<br><small>deleted ' . (int)($p['retention_days'] ?? $this->cfg['retention_days'] ?? 90) . ' days after the last check-in</small></div></div>';

        $h .= '<h2>Active installations per day</h2>' . ($t ? self::chart($t) : '<p><small>The chart fills in from the first run of bin/daily.php.</small></p>');

        $h .= '<h2>Active installations by version</h2><table>';
        $max = max([1] + array_values($s['versions']));
        foreach ($s['versions'] as $v => $n) $h .= '<tr><td style="width:140px">' . self::e((string)$v) . '</td><td style="width:60px">' . $n . '</td><td><span class="bar" style="width:' . round($n / $max * 100) . '%"></span></td></tr>';
        if (!$s['versions']) $h .= '<tr><td><small>none</small></td></tr>';
        $h .= '</table>';
        foreach ($p['fields'] ?? [] as $name => $spec) {
            $f = $s['fields'][$name] ?? null;
            if (!$f || !isset($f['values'])) continue;
            $h .= '<h2>' . self::e((string)($spec['label'] ?? $name)) . '</h2><table>';
            $mx = max([1] + array_values($f['values']));
            foreach (array_slice($f['values'], 0, 20, true) as $v => $n) $h .= '<tr><td style="width:200px">' . self::e((string)$v) . '</td><td style="width:60px">' . $n . '</td><td><span class="bar" style="width:' . round($n / $mx * 100) . '%"></span></td></tr>';
            $h .= '</table>';
        }

        $sumFields = array_keys(array_filter($p['fields'] ?? [], fn($x) => $x['type'] === 'int'));
        $showHost = Collector::hostnameMode($p) !== 'none';
        $h .= '<h2>Installations</h2><p><small>Latest check-in of each installation. Times in UTC. Grey: not seen in the last ' . $days . ' days.</small></p><table><tr>'
            . ($showHost ? '<th>Hostname</th>' : '<th>Installation</th>') . '<th>Version</th>';
        foreach ($sumFields as $n) $h .= '<th>' . self::e((string)($p['fields'][$n]['label'] ?? $n)) . '</th>';
        $h .= '<th>Last seen</th><th>First seen</th><th>Check-ins</th></tr>';
        foreach ($s['rows'] as $r) {
            $h .= '<tr' . ($r['last_seen'] < $s['cutoff'] ? ' class="old"' : '') . '><td title="' . self::e($r['installation_id']) . '">'
                . self::e($showHost ? (string)$r['hostname'] : substr($r['installation_id'], 0, 8) . '…') . '</td><td>' . self::e($r['version']) . '</td>';
            foreach ($sumFields as $n) $h .= '<td>' . (isset($r['data'][$n]) ? number_format((int)$r['data'][$n]) : '') . '</td>';
            $h .= '<td>' . self::e($r['last_seen']) . '</td><td>' . self::e($r['first_seen']) . '</td><td>' . (int)$r['checkins'] . '</td></tr>';
        }
        return $h . '</table>';
    }

    /** Small line, no axes (overview cards) */
    private static function spark(array $vals, int $w, int $h): string
    {
        if (count($vals) < 2) return '<svg width="' . $w . '" height="' . $h . '"></svg>';
        $max = max(1, max($vals)); $n = count($vals) - 1; $pts = [];
        foreach ($vals as $i => $v) $pts[] = round($i / $n * ($w - 2) + 1, 1) . ',' . round($h - 2 - $v / $max * ($h - 4), 1);
        return '<svg width="' . $w . '" height="' . $h . '" role="img" aria-label="trend"><polyline fill="none" stroke="#2563eb" stroke-width="2" points="' . implode(' ', $pts) . '"/></svg>';
    }

    /** Line chart of active installations per day, with the highest value and the first and last day */
    private static function chart(array $t): string
    {
        $w = 1000; $h = 220; $l = 44; $b = 24; $vals = array_column($t, 'active');
        $max = max(1, max($vals)); $n = max(1, count($vals) - 1); $pts = [];
        foreach ($vals as $i => $v) $pts[] = round($l + $i / $n * ($w - $l - 8), 1) . ',' . round(8 + ($h - $b - 8) * (1 - $v / $max), 1);
        $svg = '<svg viewBox="0 0 ' . $w . ' ' . $h . '" class="chart" role="img" aria-label="Active installations per day">'
             . '<line x1="' . $l . '" y1="8" x2="' . $w . '" y2="8" stroke="#e5e7eb"/><line x1="' . $l . '" y1="' . ($h - $b) . '" x2="' . $w . '" y2="' . ($h - $b) . '" stroke="#9ca3af"/>'
             . '<text x="' . ($l - 6) . '" y="12" text-anchor="end">' . $max . '</text><text x="' . ($l - 6) . '" y="' . ($h - $b) . '" text-anchor="end">0</text>'
             . '<text x="' . $l . '" y="' . ($h - 6) . '">' . self::e($t[0]['day']) . '</text><text x="' . $w . '" y="' . ($h - 6) . '" text-anchor="end">' . self::e($t[count($t) - 1]['day']) . '</text>';
        $svg .= count($vals) > 1 ? '<polyline fill="none" stroke="#2563eb" stroke-width="2.5" points="' . implode(' ', $pts) . '"/>'
                                 : '<circle cx="' . $l . '" cy="' . explode(',', $pts[0])[1] . '" r="4" fill="#2563eb"/>';
        return $svg . '</svg>';
    }

    private function page(string $body): void
    {
        header('Content-Type: text/html; charset=utf-8');
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex">'
            . '<title>Statistics</title><style>body{font:14px/1.45 system-ui,sans-serif;margin:24px auto;max-width:1100px;padding:0 16px;color:#111}'
            . 'h1{font-size:22px}h2{font-size:16px;margin-top:28px}table{border-collapse:collapse;width:100%}th,td{text-align:left;padding:6px 8px;border-bottom:1px solid #e5e7eb}'
            . 'th{background:#f9fafb;font-size:12px}tr.old td{color:#9ca3af}.tiles{display:flex;gap:12px;flex-wrap:wrap}.tiles div{border:1px solid #e5e7eb;border-radius:8px;padding:12px 16px;min-width:180px}'
            . '.tiles b{display:block;font-size:26px}.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:14px}.card{display:flex;flex-direction:column;gap:4px;border:1px solid #e5e7eb;border-radius:10px;padding:14px 16px;color:#111;text-decoration:none}.card:hover{border-color:#2563eb}.card .name{font-weight:700;font-size:15px}.card b{font-size:30px}.card span{color:#6b7280;font-size:13px}.bar{display:inline-block;height:10px;background:#2563eb;border-radius:3px;min-width:2px}svg.chart{width:100%;height:auto;max-height:240px}svg text{font-size:12px;fill:#6b7280}a{color:#2563eb}small{color:#6b7280}.err{color:#b91c1c}form.login{display:flex;flex-direction:column;gap:10px;max-width:280px}'
            . 'form.login input{display:block;width:100%;padding:6px}form.logout{float:right}nav{margin-bottom:12px}</style></head><body>' . $body . '</body></html>';
    }

    private static function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
}
