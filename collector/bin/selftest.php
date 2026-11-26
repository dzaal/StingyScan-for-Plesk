<?php
declare(strict_types=1);
// After deploying: php bin/selftest.php — checks the config and the real MariaDB statements inside a
// transaction that is rolled back, so nothing stays in the database.
require dirname(__DIR__) . '/src/app.php';
$cfg = stats_config();
if ($bad = Collector::checkConfig($cfg)) { echo "FAIL config: " . implode('; ', $bad) . "\n"; exit(1); }
echo "ok: config\n";
$store = stats_store($cfg);
$pdo   = $store->pdo();
$id    = bin2hex(random_bytes(16));
$p     = ['fields' => ['n' => ['type' => 'int', 'sum' => true]]];
$rec   = ['project' => 'selftest', 'installation_id' => $id, 'hostname' => 'selftest.example', 'version' => '1.0', 'data' => ['n' => 0]];
$ok    = false;
$pdo->beginTransaction();
try {
    $store->upsert($rec, time() - 60);
    $store->upsert(['version' => '1.1', 'data' => ['n' => 5]] + $rec, time());
    $rows = $store->rows('selftest');
    $ok = count($rows) === 1 && $rows[0]['version'] === '1.1' && $rows[0]['data'] === ['n' => 5] && (int)$rows[0]['checkins'] === 2;
    echo $ok ? "ok: two check-ins of one installation are one row (latest values, 2 check-ins)\n" : "FAIL: upsert\n";
    $store->snapshot('selftest', $p, time(), 30);
    $t = $store->trend('selftest', time(), 1);
    $ok = $ok && count($t) === 1 && $t[0]['active'] === 1 && ($t[0]['data']['sums']['n'] ?? null) === 5;
    echo $ok ? "ok: daily figures\n" : "FAIL: daily figures\n";
} finally {
    $pdo->rollBack();
}
exit($ok ? 0 : 1);
