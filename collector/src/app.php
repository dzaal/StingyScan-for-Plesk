<?php
declare(strict_types=1);
require_once __DIR__ . '/Collector.php';
require_once __DIR__ . '/Dashboard.php';

/**
 * Front controller of stats.digizaal.nl:
 *   POST /check-in            check-in of the default project (StingyScan)
 *   POST /check-in/<project>  check-in of another configured project
 *   GET|POST /dashboard       private dashboard (login)
 * Everything else: 404. Nothing here logs request bodies or source addresses.
 */
function stats_config(): array
{
    $file = getenv('STATS_CONFIG') ?: dirname(__DIR__, 2) . '/private/stats-config.php';
    if (!is_file($file)) { http_response_code(500); exit; }
    return require $file;
}

function stats_json(int $status, array $body, array $headers = []): void
{
    http_response_code($status);
    header('Content-Type: application/json');
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    foreach ($headers as $h) header($h);
    echo json_encode($body), "\n";
}

function stats_run(): void
{
    ini_set('display_errors', '0');
    $path   = (string)parse_url((string)($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
    $method = (string)($_SERVER['REQUEST_METHOD'] ?? 'GET');
    $cfg    = stats_config();
    $now    = time();
    $ip     = (string)($_SERVER['REMOTE_ADDR'] ?? '');
    $rate   = new RateLimiter((string)$cfg['rate_dir'], (string)$cfg['secret']);

    if ($path === '/dashboard' || str_starts_with($path, '/dashboard/')) {
        (new Dashboard($cfg, fn() => stats_store($cfg), $rate))->run($method, $ip, $now);
        return;
    }
    if (!str_starts_with($path, '/check-in')) { stats_json(404, ['error' => 'not found']); return; }

    $project = Collector::projectFor($cfg, $path);
    if ($project === null) { stats_json(404, ['error' => 'unknown project']); return; }
    if ($method !== 'POST') { stats_json(405, ['error' => 'POST only'], ['Allow: POST']); return; }

    $r = $cfg['rate'] ?? [];
    if (!$rate->hit('global', (int)($r['global_per_minute'] ?? 300), 60, $now)
        || !$rate->hit('ip:' . $ip, (int)($r['checkin_per_hour'] ?? 20), 3600, $now)) {
        stats_json(429, ['error' => 'too many requests'], ['Retry-After: 3600']); return;
    }
    if (stripos((string)($_SERVER['CONTENT_TYPE'] ?? ''), 'application/json') !== 0) { stats_json(415, ['error' => 'Content-Type must be application/json']); return; }
    if ((int)($_SERVER['CONTENT_LENGTH'] ?? 0) > Collector::MAX_BODY) { stats_json(413, ['error' => 'body size']); return; }
    $raw = (string)file_get_contents('php://input', false, null, 0, Collector::MAX_BODY + 1);

    try {
        [$status, $body] = (new Collector($cfg, stats_store($cfg)))->handle($project, $raw, $now);
    } catch (\Throwable $e) {
        error_log('stats collector: storage error (' . get_class($e) . ')'); // no request data in the log
        [$status, $body] = [503, ['error' => 'temporarily unavailable']];
    }
    stats_json($status, $body);
}

function stats_store(array $cfg): Store
{
    static $s = null;
    if ($s === null) {
        $pdo = new \PDO($cfg['db']['dsn'], $cfg['db']['user'] ?? null, $cfg['db']['password'] ?? null, [\PDO::ATTR_TIMEOUT => 5]);
        if ($pdo->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'mysql') $pdo->exec("SET time_zone = '+00:00'");
        $s = new Store($pdo);
    }
    return $s;
}
