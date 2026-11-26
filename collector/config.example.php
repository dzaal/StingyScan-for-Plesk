<?php
// Copy to /var/www/vhosts/stats.digizaal.nl/private/stats-config.php (outside the web root), chmod 600,
// owned by the subscription's system user. Never commit the real file.
return [
    // MariaDB: a user with SELECT, INSERT, UPDATE, DELETE on this database only
    'db' => [
        'dsn'      => 'mysql:host=localhost;dbname=stats_collector;charset=utf8mb4',
        'user'     => 'stats_collector',
        'password' => 'CHANGE-ME',
    ],

    // Projects that may check in. POST /check-in uses default_project; POST /check-in/<key> the others.
    // Every project sends installation_id and version; hostname only when 'hostname' is 'required' or
    // 'optional' (server software). Its own fields: int (min, max, 'sum' => true to add up), enum (values),
    // bool, string (pattern). A check-in must contain exactly these fields ('optional' => true may be left out).
    'default_project' => 'stingyscan',
    'projects' => [
        'stingyscan' => [
            'name'     => 'StingyScan for Plesk',
            'url'      => 'https://github.com/dzaal/StingyScan-for-Plesk',
            'hostname' => 'required',
            'fields'   => [
                'hosted_sites' => ['type' => 'int', 'min' => 0, 'max' => 1000000, 'sum' => true, 'label' => 'Hosted websites'],
            ],
        ],
        // Another program later, for example:
        // 'myapp' => ['name' => 'My app', 'hostname' => 'none',
        //             'fields' => ['platform' => ['type' => 'enum', 'values' => ['windows', 'macos', 'linux'], 'label' => 'Platform']]],
    ],

    // Installations not seen for this many days are deleted by bin/daily.php (run it daily);
    // a project can have its own 'retention_days'
    'retention_days' => 90,
    // "Active" on the dashboard: seen in the last N days
    'active_days' => 30,

    // Rate limits of the public endpoint (per source address, and for everyone together)
    'rate' => [
        'checkin_per_hour' => 20,     // one server checks in once a week; retries every 6 hours
        'global_per_minute' => 300,
        'login_per_15min'  => 10,
    ],
    // Folder for rate-limit counters (outside the web root). Keys are HMACs of the address with an hourly
    // window, so the addresses themselves are never written down. bin/daily.php removes old counters.
    'rate_dir' => '/var/www/vhosts/stats.digizaal.nl/private/ratelimit',
    // Random secret for those HMACs: php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
    'secret' => 'CHANGE-ME-64-HEX',

    // Private dashboard: https://stats.digizaal.nl/dashboard
    // Hash: php -r "echo password_hash('your password', PASSWORD_DEFAULT), PHP_EOL;"
    'dashboard' => [
        'user'          => 'dirk',
        'password_hash' => '$2y$10$CHANGE-ME',
    ],
];
