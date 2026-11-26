<?php
declare(strict_types=1);

/**
 * Installation statistics collector for several open-source programs (stats.digizaal.nl).
 *
 * Every project is defined in the config with the fields it may send. All projects send installation_id
 * and version; hostname only when the project asks for it (server software), never for desktop or
 * browser software. On top of that each project has its own fields:
 *   int    whole number between min and max; 'sum' => true adds it up on the dashboard (e.g. hosted_sites)
 *   enum   one of a fixed list of values (e.g. platform: windows, macos, linux)
 *   bool   true or false
 *   string short text matching a pattern (at most 64 characters)
 * A check-in must contain exactly the project's fields (optional ones may be left out). Check-ins are
 * self-reported statistics: nothing is verified beyond its format.
 */
final class Collector
{
    const MAX_BODY   = 2048;
    const MAX_FIELDS = 12;

    public function __construct(private array $cfg, private Store $store) {}

    /** The project key for a request path, or null (unknown path or project) */
    public static function projectFor(array $cfg, string $path): ?string
    {
        $path = rtrim($path, '/');
        if ($path === '/check-in') return (string)$cfg['default_project'];
        if (preg_match('#^/check-in/([a-z0-9][a-z0-9\-]{0,31})$#', $path, $m) && isset($cfg['projects'][$m[1]])) return $m[1];
        return null;
    }

    /** The public description of what each project may send (GET /api); no data */
    public static function describe(array $cfg, string $base): array
    {
        $out = [];
        foreach ($cfg['projects'] as $key => $p) {
            $f = ['installation_id' => ['type' => 'string', 'rule' => '32 lowercase hex characters, random, kept by the installation'],
                  'version' => ['type' => 'string', 'rule' => '1-32 characters: letters, digits, . - +']];
            $hm = self::hostnameMode($p);
            if ($hm !== 'none') $f['hostname'] = ['type' => 'string', 'rule' => 'host name, at most 253 characters', 'optional' => $hm === 'optional'];
            foreach ($p['fields'] ?? [] as $name => $spec) {
                $d = ['type' => $spec['type']];
                foreach (['min', 'max', 'values', 'pattern', 'optional', 'label'] as $k) if (isset($spec[$k])) $d[$k] = $spec[$k];
                $f[$name] = $d;
            }
            $out[$key] = ['name' => $p['name'], 'endpoint' => $base . '/check-in/' . $key, 'fields' => $f];
        }
        return ['projects' => $out, 'method' => 'POST', 'content_type' => 'application/json', 'max_body' => self::MAX_BODY];
    }

    public static function hostnameMode(array $p): string
    {
        $m = $p['hostname'] ?? 'none';
        return in_array($m, ['required', 'optional', 'none'], true) ? $m : 'none';
    }

    /**
     * Validate a raw body for a project: [record, null] or [null, error message].
     * record: {project, installation_id, hostname|null, version, data: {field: value}}
     */
    public function validate(string $project, string $raw): array
    {
        $p = $this->cfg['projects'][$project] ?? null;
        if (!$p) return [null, 'unknown project'];
        if ($raw === '' || strlen($raw) > self::MAX_BODY) return [null, 'body size'];
        try {
            $j = json_decode($raw, true, 4, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return [null, 'invalid JSON'];
        }
        if (!is_array($j) || array_is_list($j)) return [null, 'expected a JSON object'];

        $fields = $p['fields'] ?? [];
        $hm = self::hostnameMode($p);
        $allowed  = array_merge(['installation_id', 'version'], $hm !== 'none' ? ['hostname'] : [], array_keys($fields));
        $required = array_merge(['installation_id', 'version'], $hm === 'required' ? ['hostname'] : [],
                                array_keys(array_filter($fields, fn($s) => empty($s['optional']))));
        if ($extra = array_diff(array_keys($j), $allowed)) return [null, 'unknown field: ' . implode(', ', $extra)];
        if ($miss = array_diff($required, array_keys($j))) return [null, 'missing field: ' . implode(', ', $miss)];

        $id = $j['installation_id'];
        if (!is_string($id) || !preg_match('/^[a-f0-9]{32}$/', $id)) return [null, 'installation_id: 32 lowercase hex characters'];
        $ver = $j['version'];
        if (!is_string($ver) || !preg_match('/^[0-9A-Za-z.\-+]{1,32}$/', $ver)) return [null, 'version: at most 32 characters (letters, digits, . - +)'];
        $host = null;
        if (array_key_exists('hostname', $j)) {
            $host = $j['hostname'];
            if (!is_string($host) || !self::validHostname($host)) return [null, 'hostname: a host name of at most 253 characters'];
            $host = strtolower($host);
        }
        $data = [];
        foreach ($fields as $name => $s) {
            if (!array_key_exists($name, $j)) continue;
            $v = $j[$name];
            $err = match ($s['type']) {
                'int'    => !is_int($v) || $v < (int)($s['min'] ?? 0) || $v > (int)($s['max'] ?? 1000000)
                            ? 'a whole number from ' . (int)($s['min'] ?? 0) . ' to ' . (int)($s['max'] ?? 1000000) : null,
                'enum'   => !is_string($v) || !in_array($v, (array)$s['values'], true) ? 'one of: ' . implode(', ', (array)$s['values']) : null,
                'bool'   => !is_bool($v) ? 'true or false' : null,
                'string' => !is_string($v) || strlen($v) > 64 || !preg_match($s['pattern'] ?? '/^[A-Za-z0-9 ._\-+\/()]{0,64}$/', $v) ? 'text in the allowed format' : null,
                default  => 'not accepted',
            };
            if ($err !== null) return [null, "$name: $err"];
            $data[$name] = $v;
        }
        return [['project' => $project, 'installation_id' => $id, 'hostname' => $host, 'version' => $ver, 'data' => $data], null];
    }

    public static function validHostname(string $h): bool
    {
        return strlen($h) <= 253 && (bool)preg_match('/^(?=.{1,253}$)([A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?)(\.[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?)*$/', $h);
    }

    /** Check the project definitions in the config; returns a list of problems (empty = fine) */
    public static function checkConfig(array $cfg): array
    {
        $bad = [];
        if (!isset($cfg['projects'][$cfg['default_project'] ?? ''])) $bad[] = 'default_project is not a project';
        foreach ($cfg['projects'] ?? [] as $key => $p) {
            if (!preg_match('/^[a-z0-9][a-z0-9\-]{0,31}$/', (string)$key)) $bad[] = "$key: key must be 1-32 of a-z 0-9 -";
            if (count($p['fields'] ?? []) > self::MAX_FIELDS) $bad[] = "$key: at most " . self::MAX_FIELDS . ' fields';
            foreach ($p['fields'] ?? [] as $name => $s) {
                if (!preg_match('/^[a-z][a-z0-9_]{0,31}$/', (string)$name) || in_array($name, ['installation_id', 'version', 'hostname'], true)) $bad[] = "$key.$name: invalid field name";
                if (!in_array($s['type'] ?? '', ['int', 'enum', 'bool', 'string'], true)) $bad[] = "$key.$name: type must be int, enum, bool or string";
                if (($s['type'] ?? '') === 'enum' && empty($s['values'])) $bad[] = "$key.$name: enum needs values";
            }
        }
        return $bad;
    }

    /** Validate and store: [http status, response array] */
    public function handle(string $project, string $raw, int $now): array
    {
        [$rec, $err] = $this->validate($project, $raw);
        if ($err !== null) return [$err === 'body size' ? 413 : 400, ['error' => $err]];
        $this->store->upsert($rec, $now);
        return [200, ['ok' => true]];
    }
}

/** Storage: MariaDB/MySQL in production, SQLite in the tests. Times are UTC, from the collector's clock. */
final class Store
{
    private string $driver;

    public function __construct(private \PDO $pdo)
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->driver = (string)$this->pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
    }

    public function pdo(): \PDO { return $this->pdo; }

    /** One atomic statement: a new installation is inserted, a known one updated (latest check-in wins) */
    public function upsert(array $r, int $now): void
    {
        $t = gmdate('Y-m-d H:i:s', $now);
        $sql = 'INSERT INTO installations (project, installation_id, hostname, version, data, first_seen, last_seen, checkins) VALUES (?, ?, ?, ?, ?, ?, ?, 1) '
             . ($this->driver === 'sqlite'
                ? 'ON CONFLICT(project, installation_id) DO UPDATE SET hostname = excluded.hostname, version = excluded.version, data = excluded.data, last_seen = excluded.last_seen, checkins = checkins + 1'
                : 'ON DUPLICATE KEY UPDATE hostname = VALUES(hostname), version = VALUES(version), data = VALUES(data), last_seen = VALUES(last_seen), checkins = checkins + 1');
        $this->pdo->prepare($sql)->execute([$r['project'], $r['installation_id'], $r['hostname'], $r['version'],
            json_encode((object)$r['data'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $t, $t]);
    }

    /** Every stored installation of a project (latest check-in each), newest first */
    public function rows(string $project, int $limit = 5000): array
    {
        $st = $this->pdo->prepare('SELECT installation_id, hostname, version, data, first_seen, last_seen, checkins FROM installations WHERE project = ? ORDER BY last_seen DESC LIMIT ' . (int)$limit);
        $st->execute([$project]);
        $rows = $st->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as &$r) $r['data'] = json_decode((string)$r['data'], true) ?: [];
        return $rows;
    }

    /**
     * Figures of one project from the latest check-in per installation:
     * active (seen in the last $activeDays), new (first seen in that period), by version, and per field
     * a total (int with sum) or a breakdown of values (enum, bool, string, int without sum).
     */
    public function summary(string $project, array $p, int $now, int $activeDays): array
    {
        $cut  = gmdate('Y-m-d H:i:s', $now - $activeDays * 86400);
        $rows = $this->rows($project);
        $act  = array_values(array_filter($rows, fn($r) => $r['last_seen'] >= $cut));
        $ver = []; $fields = [];
        foreach ($act as $r) {
            $ver[$r['version']] = ($ver[$r['version']] ?? 0) + 1;
            foreach ($p['fields'] ?? [] as $name => $s) {
                if (!array_key_exists($name, $r['data'])) continue;
                $v = $r['data'][$name];
                if ($s['type'] === 'int' && !empty($s['sum'])) { $fields[$name]['sum'] = ($fields[$name]['sum'] ?? 0) + (int)$v; $fields[$name]['n'] = ($fields[$name]['n'] ?? 0) + 1; }
                else { $k = is_bool($v) ? ($v ? 'yes' : 'no') : (string)$v; $fields[$name]['values'][$k] = ($fields[$name]['values'][$k] ?? 0) + 1; }
            }
        }
        uksort($ver, fn($a, $b) => version_compare($b, $a));
        foreach ($fields as &$f) if (isset($f['values'])) arsort($f['values']);
        unset($f);
        return ['active' => count($act), 'new' => count(array_filter($act, fn($r) => $r['first_seen'] >= $cut)), 'stored' => count($rows),
                'versions' => $ver, 'fields' => $fields, 'rows' => $rows, 'cutoff' => $cut];
    }

    /** Save today's figures of a project for the trend chart (one row per project and day) */
    public function snapshot(string $project, array $p, int $now, int $activeDays): void
    {
        $s = $this->summary($project, $p, $now, $activeDays);
        $sums = [];
        foreach ($s['fields'] as $name => $f) if (isset($f['sum'])) $sums[$name] = $f['sum'];
        $day = gmdate('Y-m-d', $now);
        $sql = 'INSERT INTO daily (project, day, active, data) VALUES (?, ?, ?, ?) '
             . ($this->driver === 'sqlite' ? 'ON CONFLICT(project, day) DO UPDATE SET active = excluded.active, data = excluded.data'
                                           : 'ON DUPLICATE KEY UPDATE active = VALUES(active), data = VALUES(data)');
        $this->pdo->prepare($sql)->execute([$project, $day, $s['active'], json_encode(['sums' => (object)$sums, 'versions' => (object)$s['versions'], 'new' => $s['new']])]);
    }

    /** Daily figures of a project for the last $days days: [{day, active, data}] oldest first */
    public function trend(string $project, int $now, int $days): array
    {
        $st = $this->pdo->prepare('SELECT day, active, data FROM daily WHERE project = ? AND day >= ? ORDER BY day');
        $st->execute([$project, gmdate('Y-m-d', $now - $days * 86400)]);
        $rows = $st->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as &$r) { $r['active'] = (int)$r['active']; $r['data'] = json_decode((string)$r['data'], true) ?: []; }
        return $rows;
    }

    /** Delete installations of a project not seen for $days days; returns how many */
    public function purge(string $project, int $now, int $days): int
    {
        $st = $this->pdo->prepare('DELETE FROM installations WHERE project = ? AND last_seen < ?');
        $st->execute([$project, gmdate('Y-m-d H:i:s', $now - $days * 86400)]);
        return $st->rowCount();
    }

    /** Delete installations of projects that are no longer in the config; returns how many */
    public function purgeUnknown(array $projects): int
    {
        if (!$projects) return 0;
        $in = implode(',', array_fill(0, count($projects), '?'));
        $st = $this->pdo->prepare("DELETE FROM installations WHERE project NOT IN ($in)");
        $st->execute(array_values($projects));
        return $st->rowCount();
    }
}

/**
 * Fixed-window rate limits in small files outside the web root. The file name is an HMAC of the bucket
 * (for example the source address) and the window, so addresses are never written down.
 */
final class RateLimiter
{
    public function __construct(private string $dir, private string $secret) {}

    /** Count one hit; false when $limit hits in this $window seconds were already counted */
    public function hit(string $bucket, int $limit, int $window, int $now): bool
    {
        if ($limit <= 0) return true;
        if (!is_dir($this->dir)) @mkdir($this->dir, 0700, true);
        $slot = intdiv($now, $window);
        $file = $this->dir . '/' . hash_hmac('sha256', $bucket . '|' . $window . '|' . $slot, $this->secret) . '.cnt';
        $fh = @fopen($file, 'c+');
        if (!$fh) return true; // never block check-ins because the counter folder is unwritable
        flock($fh, LOCK_EX);
        $n = (int)stream_get_contents($fh) + 1;
        ftruncate($fh, 0); rewind($fh); fwrite($fh, (string)$n);
        flock($fh, LOCK_UN); fclose($fh);
        return $n <= $limit;
    }

    /** Remove counters older than $age seconds */
    public function cleanup(int $now, int $age = 7200): int
    {
        $n = 0;
        foreach (glob($this->dir . '/*.cnt') ?: [] as $f) if ($now - (int)@filemtime($f) > $age && @unlink($f)) $n++;
        return $n;
    }
}
