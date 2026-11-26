<?php
// php tests/StatsTest.php — installation statistics (VtStats): off by default, exactly four fields when on,
// once a week, stable ID, opt-out stops at once, failures and inventory errors. No network: send is replaced.
require __DIR__ . '/../plib/library/VtStats.php';

$fail = 0;
function check(bool $ok, string $what): void { global $fail; echo ($ok ? 'ok   ' : 'FAIL ') . $what . "\n"; if (!$ok) $fail++; }

$dir = sys_get_temp_dir() . '/vtstats-' . bin2hex(random_bytes(4));
VtDataDir::useBase($dir);

$sent = [];
$now  = 1_800_000_000;
$host = 'server22.example.com'; $sites = 12; $ver = '2.17.0'; $up = true;
$deps = function () use (&$sent, &$now, &$host, &$sites, &$ver, &$up) {
    return [
        'now'      => fn() => $now,
        'hostname' => fn() => $host,
        'sites'    => fn() => $sites,
        'version'  => fn() => $ver,
        'send'     => function ($url, $json) use (&$sent, &$up) { $sent[] = [$url, $json]; return $up ? [true, 200, ''] : [false, 0, 'Connection timed out']; },
    ];
};

// Off by default: fresh install, and an existing install with settings saved before this version
check(VtStats::checkIn($deps()) === 'off' && !$sent, 'fresh install: off, no request');
check(!is_file(VtDataDir::path(VtStats::ID_FILE)), 'fresh install: no installation ID made');
(new VtSettings('admin'))->setAll(['notify_enabled' => true]); // an older settings file without stats_share
check(VtStats::checkIn($deps()) === 'off' && !$sent, 'existing install without the setting: off, no request');
(new VtSettings('admin'))->set('stats_share', 'true');
check(VtStats::checkIn($deps()) === 'off', 'only a real true switches it on (saved value is a boolean)');

// Opt in: exactly the four fields, to the HTTPS endpoint
(new VtSettings('admin'))->set('stats_share', true);
check(VtStats::checkIn($deps()) === 'sent' && count($sent) === 1, 'opted in: one check-in sent');
[$url, $json] = $sent[0]; $body = json_decode($json, true);
check($url === 'https://stats.digizaal.nl/check-in', 'sent to https://stats.digizaal.nl/check-in');
$k = array_keys($body); sort($k);
check($k === ['hosted_sites', 'hostname', 'installation_id', 'version'], 'exactly installation_id, hostname, version, hosted_sites');
check(preg_match('/^[a-f0-9]{32}$/', $body['installation_id']) === 1 && $body['hostname'] === $host && $body['version'] === $ver && $body['hosted_sites'] === 12, 'field values and types (site count is a number)');
$id = $body['installation_id'];

// At most once a week
$now += 3600;
check(VtStats::checkIn($deps()) === 'not_due' && count($sent) === 1, 'an hour later: nothing sent');
$now += 7 * 86400;
$host = 'renamed.example.com'; $ver = '2.18.0'; // host name changed and upgraded
check(VtStats::checkIn($deps()) === 'sent' && count($sent) === 2, 'a week later: sent again');
$b2 = json_decode($sent[1][1], true);
check($b2['installation_id'] === $id && $b2['hostname'] === 'renamed.example.com' && $b2['version'] === '2.18.0', 'host name change and upgrade keep the installation ID');

// Opt out stops at once, opt in again keeps the ID
(new VtSettings('admin'))->set('stats_share', false);
$now += 30 * 86400;
check(VtStats::checkIn($deps()) === 'off' && count($sent) === 2, 'opted out: no request, even when due');
(new VtSettings('admin'))->set('stats_share', true);
$sites = 0; // a server without websites
check(VtStats::checkIn($deps()) === 'sent' && json_decode($sent[2][1], true)['installation_id'] === $id, 'opted in again: same installation ID');
check(json_decode($sent[2][1], true)['hosted_sites'] === 0, 'zero hosted websites is sent as 0');

// Inventory failure: nothing sent (no false zero), tried again in an hour
$now += 8 * 86400; $sites = null;
check(VtStats::checkIn($deps()) === 'inventory' && count($sent) === 3, 'site count unknown: nothing sent');
$now += 3600 + 1; $sites = 5;
check(VtStats::checkIn($deps()) === 'sent' && count($sent) === 4, 'an hour later with a site count: sent');

// Collector outage: failed, retried after about 6 hours, no exception for the caller
$now += 8 * 86400; $up = false;
check(VtStats::checkIn($deps()) === 'failed' && count($sent) === 5, 'collector down: failed');
$st = VtStats::state();
check($st['next_try'] >= $now + VtStats::RETRY && $st['next_try'] <= $now + VtStats::RETRY + 900 && str_contains($st['last_error'], 'timed out'), 'retry scheduled 6 hours later, error kept for Settings');
$now += 3600;
check(VtStats::checkIn($deps()) === 'not_due' && count($sent) === 5, 'no retry storm: waits for the retry time');
$up = true; $now += VtStats::RETRY;
check(VtStats::checkIn($deps()) === 'sent', 'collector back: sent');

// Two runs at once: only one can send
$now += 8 * 86400;
$lock = fopen(VtDataDir::path('vt_stats.lock'), 'c'); flock($lock, LOCK_EX);
check(VtStats::checkIn($deps()) === 'busy' && count($sent) === 6, 'another run holds the lock: this one does not send');
flock($lock, LOCK_UN); fclose($lock);

// The real sender: an unreachable collector fails fast and does not throw
$t = microtime(true);
[$ok, $code, $err] = VtStats::send('https://127.0.0.1:9/check-in', '{}');
check(!$ok && microtime(true) - $t < 10, 'real HTTPS request to an unreachable collector fails within the timeout (' . round(microtime(true) - $t, 1) . ' s)');

// Payload checks
check(VtStats::payload($id, ['hostname' => fn() => 'bad host/x', 'sites' => fn() => 1, 'version' => fn() => '1']) === null, 'invalid host name: nothing sent');
check(VtStats::payload($id, ['hostname' => fn() => 'a.example', 'sites' => fn() => -1, 'version' => fn() => '1']) === null, 'negative site count: nothing sent');

// Tidy up
foreach (glob("$dir/*") as $f) @unlink($f); @rmdir($dir);
echo $fail ? "$fail failed\n" : "all passed\n";
exit($fail ? 1 : 0);
