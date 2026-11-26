<?php
declare(strict_types=1);
// php collector/tests/CollectorTest.php — validation, upsert, totals, trend, retention, rate limits, the HTTP
// endpoint and the dashboard, against SQLite and PHP's built-in web server (MariaDB: bin/selftest.php).
require dirname(__DIR__) . '/src/Collector.php';

$fail = 0;
function check(bool $ok, string $what): void { global $fail; echo ($ok ? 'ok   ' : 'FAIL ') . $what . "\n"; if (!$ok) $fail++; }

$sting = ['name' => 'StingyScan for Plesk', 'hostname' => 'required',
          'fields' => ['hosted_sites' => ['type' => 'int', 'min' => 0, 'max' => 1000000, 'sum' => true, 'label' => 'Hosted websites']]];
$cfg = [
    'default_project' => 'stingyscan',
    'projects' => [
        'stingyscan' => $sting,
        // a second, made-up project, only to test that the definitions are generic
        'demo' => ['name' => 'Demo', 'hostname' => 'none', 'fields' => ['platform' => ['type' => 'enum', 'values' => ['windows', 'linux']], 'beta' => ['type' => 'bool', 'optional' => true]]],
    ],
    'retention_days' => 90, 'active_days' => 30,
];
// The same two tables as schema.sql, in SQLite's dialect
$schema = "CREATE TABLE installations (project TEXT NOT NULL, installation_id TEXT NOT NULL, hostname TEXT NULL, version TEXT NOT NULL, data TEXT NOT NULL,
             first_seen TEXT NOT NULL, last_seen TEXT NOT NULL, checkins INTEGER NOT NULL DEFAULT 1, PRIMARY KEY (project, installation_id));
           CREATE TABLE daily (project TEXT NOT NULL, day TEXT NOT NULL, active INTEGER NOT NULL, data TEXT NOT NULL, PRIMARY KEY (project, day))";
$newDb = function () use ($schema) { $pdo = new PDO('sqlite::memory:'); foreach (array_filter(array_map('trim', explode(';', $schema))) as $q) $pdo->exec($q); return $pdo; };

check(Collector::checkConfig($cfg) === [], 'config is valid');
check(Collector::checkConfig(['default_project' => 'x', 'projects' => ['A B' => ['fields' => ['version' => ['type' => 'int']]]]]) !== [], 'bad config is reported');

$pdo = $newDb(); $store = new Store($pdo); $c = new Collector($cfg, $store);
$id = str_repeat('ab', 16);
$good = ['installation_id' => $id, 'hostname' => 'server22.example.com', 'version' => '2.17.0', 'hosted_sites' => 12];
$j = fn(array $a) => json_encode($a);

// Routing
check(Collector::projectFor($cfg, '/check-in') === 'stingyscan', 'POST /check-in is StingyScan');
check(Collector::projectFor($cfg, '/check-in/stingyscan') === 'stingyscan', '/check-in/stingyscan works too');
check(Collector::projectFor($cfg, '/check-in/unknown') === null, 'unknown project refused');

// Validation (StingyScan: exactly installation_id, hostname, version, hosted_sites)
check($c->validate('stingyscan', $j($good))[1] === null, 'valid payload accepted');
check($c->validate('stingyscan', $j(['hosted_sites' => 0] + $good))[1] === null, 'zero hosted sites is valid');
foreach ([
    'missing field'          => array_diff_key($good, ['version' => 1]),
    'missing hostname'       => array_diff_key($good, ['hostname' => 1]),
    'extra field'            => $good + ['domains' => ['a.com']],
    'site count as string'   => ['hosted_sites' => '12'] + $good,
    'site count as float'    => ['hosted_sites' => 12.5] + $good,
    'negative site count'    => ['hosted_sites' => -1] + $good,
    'too many sites'         => ['hosted_sites' => 1000001] + $good,
    'site count as bool'     => ['hosted_sites' => true] + $good,
    'ID too short'           => ['installation_id' => 'abc'] + $good,
    'ID uppercase'           => ['installation_id' => strtoupper($id)] + $good,
    'hostname with path'     => ['hostname' => 'example.com/x'] + $good,
    'hostname too long'      => ['hostname' => str_repeat('a.', 130) . 'com'] + $good,
    'hostname as number'     => ['hostname' => 5] + $good,
    'version with spaces'    => ['version' => '2.0 beta'] + $good,
    'version too long'       => ['version' => str_repeat('1', 33)] + $good,
] as $what => $payload) check($c->validate('stingyscan', $j($payload))[1] !== null, "rejected: $what");
check($c->validate('stingyscan', '[1,2]')[1] !== null, 'rejected: JSON list');
check($c->validate('stingyscan', '{"installation_id":')[1] !== null, 'rejected: broken JSON');
check($c->validate('stingyscan', str_repeat(' ', 2049))[1] === 'body size', 'rejected: body over 2 KB');
// generic definitions: a project without hostname, with an enum and an optional bool
check($c->validate('demo', $j(['installation_id' => $id, 'version' => '1.0', 'platform' => 'linux']))[1] === null, 'other project: its own fields, optional left out');
check($c->validate('demo', $j(['installation_id' => $id, 'version' => '1.0', 'platform' => 'linux', 'hostname' => 'a.example']))[1] !== null, 'other project: hostname refused when it does not ask for it');
check($c->validate('demo', $j(['installation_id' => $id, 'version' => '1.0', 'platform' => 'amiga']))[1] !== null, 'other project: value outside the list refused');

// Upsert: repeated check-ins of one installation are one row, latest values, collector's clock
$t0 = 1_800_000_000;
$c->handle('stingyscan', $j($good), $t0);
$c->handle('stingyscan', $j(['version' => '2.18.0', 'hosted_sites' => 0, 'hostname' => 'renamed.example.com'] + $good), $t0 + 86400 * 7);
$rows = $store->rows('stingyscan');
check(count($rows) === 1, 'two check-ins of one installation count once');
check($rows[0]['version'] === '2.18.0' && $rows[0]['data'] === ['hosted_sites' => 0] && $rows[0]['hostname'] === 'renamed.example.com', 'latest check-in wins (also a new host name, same ID)');
check((int)$rows[0]['checkins'] === 2 && $rows[0]['first_seen'] === gmdate('Y-m-d H:i:s', $t0) && $rows[0]['last_seen'] === gmdate('Y-m-d H:i:s', $t0 + 86400 * 7), 'first_seen kept, last_seen from the collector clock');
[$st] = $c->handle('stingyscan', $j(['hosted_sites' => 'x'] + $good), $t0);
check($st === 400 && (int)$store->rows('stingyscan')[0]['checkins'] === 2, 'invalid check-in: 400 and nothing stored');

// Totals: active = seen in the last 30 days, latest values only
$id2 = str_repeat('cd', 16); $id3 = str_repeat('ef', 16);
$c->handle('stingyscan', $j(['installation_id' => $id2, 'hosted_sites' => 30] + $good), $t0 + 86400 * 7);
$c->handle('stingyscan', $j(['installation_id' => $id3, 'hosted_sites' => 500] + $good), $t0 - 86400 * 40); // stale
$c->handle('demo', $j(['installation_id' => $id3, 'version' => '1.0', 'platform' => 'linux']), $t0);
$s = $store->summary('stingyscan', $sting, $t0 + 86400 * 8, 30);
check($s['active'] === 2 && $s['fields']['hosted_sites']['sum'] === 30, 'active installations and total hosted websites (stale one left out)');
check($s['versions'] === ['2.18.0' => 1, '2.17.0' => 1] && $s['stored'] === 3, 'by version (newest first), every stored installation listed');
check($s['new'] === 2, 'new installations: first seen in the last 30 days');

// Daily figures for the trend chart
$store->snapshot('stingyscan', $sting, $t0 + 86400 * 8, 30);
$store->snapshot('stingyscan', $sting, $t0 + 86400 * 8 + 60, 30); // twice on one day: one row
$tr = $store->trend('stingyscan', $t0 + 86400 * 9, 30);
check(count($tr) === 1 && $tr[0]['active'] === 2 && $tr[0]['data']['sums']['hosted_sites'] === 30, 'daily figures: one row per day with active and totals');

// Retention
check($store->purge('stingyscan', $t0 + 86400 * 8, 90) === 0, 'nothing older than 90 days yet');
check($store->purge('stingyscan', $t0 + 86400 * 40, 35) === 1 && count($store->rows('stingyscan')) === 2, 'purge deletes only installations not seen for the retention period');
check($store->purgeUnknown(['stingyscan']) === 1 && $store->rows('demo') === [], 'installations of a removed project are deleted');

// Rate limiter: counts per window, keys are HMACs (no addresses on disk)
$dir = sys_get_temp_dir() . '/stats-rl-' . bin2hex(random_bytes(4));
$rl = new RateLimiter($dir, 'secret');
$hits = 0; for ($i = 0; $i < 5; $i++) $hits += $rl->hit('ip:203.0.113.9', 3, 3600, $t0) ? 1 : 0;
check($hits === 3, 'rate limit: 3 of 5 allowed in one window');
check($rl->hit('ip:203.0.113.9', 3, 3600, $t0 + 3600), 'rate limit: next window allowed again');
$names = implode(' ', array_map('basename', glob("$dir/*")));
check(!str_contains($names, '203.0.113.9') && preg_match('/^([a-f0-9]{64}\.cnt ?)+$/', $names) === 1, 'counter files do not contain the address');

// HTTP: PHP's built-in server with an SQLite database file
$tmp = sys_get_temp_dir() . '/stats-http-' . bin2hex(random_bytes(4)); mkdir($tmp);
$db = "$tmp/db.sqlite"; $f = new PDO("sqlite:$db"); foreach (array_filter(array_map('trim', explode(';', $schema))) as $q) $f->exec($q); $f = null;
file_put_contents("$tmp/config.php", '<?php return ' . var_export($cfg + ['db' => ['dsn' => "sqlite:$db"], 'rate' => ['checkin_per_hour' => 8, 'global_per_minute' => 300, 'login_per_15min' => 3],
    'rate_dir' => "$tmp/rl", 'secret' => 'x', 'cookie_secure' => false, 'dashboard' => ['user' => 'u', 'password_hash' => password_hash('p', PASSWORD_DEFAULT)]], true) . ';');
$port = 18000 + random_int(0, 999);
$router = "$tmp/router.php";
file_put_contents($router, '<?php putenv("STATS_CONFIG=' . addslashes("$tmp/config.php") . '"); require ' . var_export(dirname(__DIR__) . '/public/index.php', true) . ';');
$srv = proc_open([PHP_BINARY, '-S', "127.0.0.1:$port", $router], [1 => ['file', "$tmp/srv.log", 'a'], 2 => ['file', "$tmp/srv.log", 'a']], $pipes);
usleep(700000);
$jar = "$tmp/cookies.txt";
$req = function (string $method, string $path, ?string $body = null, string $ct = 'application/json') use ($port, $jar): array {
    $ch = curl_init("http://127.0.0.1:$port$path");
    curl_setopt_array($ch, [CURLOPT_CUSTOMREQUEST => $method, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 5, CURLOPT_COOKIEJAR => $jar, CURLOPT_COOKIEFILE => $jar]);
    if ($body !== null) curl_setopt_array($ch, [CURLOPT_POSTFIELDS => $body, CURLOPT_HTTPHEADER => ["Content-Type: $ct"]]);
    $out = (string)curl_exec($ch); $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE); curl_close($ch);
    return [$code, $out];
};
check($req('POST', '/check-in', $j($good))[0] === 200, 'HTTP: valid check-in 200');
check($req('POST', '/check-in', $j(['extra' => 1] + $good))[0] === 400, 'HTTP: extra field 400');
check($req('POST', '/check-in', $j($good), 'text/plain')[0] === 415, 'HTTP: wrong content type 415');
check($req('POST', '/check-in', str_repeat('x', 3000))[0] === 413, 'HTTP: big body 413');
check($req('GET', '/check-in')[0] === 405, 'HTTP: GET 405');
check($req('POST', '/check-in/nope', $j($good))[0] === 404, 'HTTP: unknown project 404');
check($req('GET', '/')[0] === 404, 'HTTP: anything else 404');
// 4 POSTs above counted (GET and the unknown project are refused before counting): 4 more are allowed, the 9th is not
$codes = []; for ($i = 0; $i < 5; $i++) $codes[] = $req('POST', '/check-in', $j($good))[0];
check($codes[3] === 200 && $codes[4] === 429, 'HTTP: rate limit 429 after 8 requests an hour');
[$code, $html] = $req('GET', '/dashboard');
check($code === 200 && str_contains($html, 'name="password"') && !str_contains($html, 'server22'), 'HTTP: dashboard asks for a login and shows no data');
preg_match('/name="csrf" value="([a-f0-9]+)"/', $html, $m); $csrf = $m[1] ?? '';
$form = fn(array $a) => http_build_query($a);
check(str_contains($req('POST', '/dashboard', $form(['csrf' => $csrf, 'act' => 'login', 'user' => 'u', 'password' => 'wrong']), 'application/x-www-form-urlencoded')[1], 'Wrong user name'), 'HTTP: wrong password refused');
check(str_contains($req('POST', '/dashboard', $form(['csrf' => 'bad', 'act' => 'login', 'user' => 'u', 'password' => 'p']), 'application/x-www-form-urlencoded')[1], 'Form expired'), 'HTTP: login without the CSRF token refused');
$req('POST', '/dashboard', $form(['csrf' => $csrf, 'act' => 'login', 'user' => 'u', 'password' => 'p']), 'application/x-www-form-urlencoded');
[$code, $html] = $req('GET', '/dashboard');
check($code === 200 && str_contains($html, 'StingyScan for Plesk') && str_contains($html, '<b>1</b>') && str_contains($html, '12 hosted websites'), 'HTTP: logged in, overview shows 1 active installation and 12 hosted websites');
[$code, $html] = $req('GET', '/dashboard?project=stingyscan');
check(str_contains($html, 'server22.example.com') && str_contains($html, '2.17.0') && str_contains($html, 'Active installations by version'), 'HTTP: project page lists the installation and versions');
check(str_contains($html, 'Content-Security') === false, 'HTTP: page body has no script');
check((int)(new PDO("sqlite:$db"))->query('SELECT COUNT(*) FROM installations')->fetchColumn() === 1, 'HTTP: one installation stored');
$log = (string)@file_get_contents("$tmp/srv.log");
check(!str_contains($log, 'server22.example.com') && !str_contains($log, $id), 'HTTP: the collector logs no payload');
preg_match('/name="csrf" value="([a-f0-9]+)"/', $html, $m); $req('POST', '/dashboard', $form(['csrf' => $m[1], 'act' => 'logout']), 'application/x-www-form-urlencoded');
check(str_contains($req('GET', '/dashboard')[1], 'name="password"'), 'HTTP: logged out');
preg_match('/name="csrf" value="([a-f0-9]+)"/', $req('GET', '/dashboard')[1], $m); $csrf = $m[1];
for ($i = 0; $i < 3; $i++) $last = $req('POST', '/dashboard', $form(['csrf' => $csrf, 'act' => 'login', 'user' => 'u', 'password' => 'x']), 'application/x-www-form-urlencoded')[1];
check(str_contains($last, 'Too many attempts'), 'HTTP: login attempts are rate limited');
proc_terminate($srv);

echo $fail ? "$fail failed\n" : "all passed\n";
exit($fail ? 1 : 0);
