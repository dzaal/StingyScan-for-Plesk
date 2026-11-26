<?php
declare(strict_types=1);
// Daily (Plesk → Scheduled Tasks): save today's figures per project for the trend chart, delete installations
// not seen for the retention period (default 90 days), delete installations of projects no longer configured,
// and remove old rate-limit counters. Prints one summary line; no installation data is printed.
require dirname(__DIR__) . '/src/app.php';
$cfg   = stats_config();
if ($bad = Collector::checkConfig($cfg)) { fwrite(STDERR, "config: " . implode('; ', $bad) . "\n"); exit(1); }
$store = stats_store($cfg);
$now   = time();
$out   = [];
foreach ($cfg['projects'] as $key => $p) {
    $days = max(1, (int)($p['retention_days'] ?? $cfg['retention_days'] ?? 90));
    $n = $store->purge($key, $now, $days);
    $store->snapshot($key, $p, $now, (int)($cfg['active_days'] ?? 30));
    $out[] = "$key: $n deleted (older than $days days)";
}
$gone = $store->purgeUnknown(array_keys($cfg['projects']));
$c    = (new RateLimiter((string)$cfg['rate_dir'], (string)$cfg['secret']))->cleanup($now);
echo date('c') . ' daily: ' . implode(', ', $out) . ", $gone of removed projects, $c rate counter(s) removed\n";
