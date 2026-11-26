# Installation statistics collector (stats.digizaal.nl)

A small PHP + MariaDB service that receives the weekly check-ins of Stingy Scanner installations (off by default: only installations whose administrator switched sharing on in Settings) and
shows them on a private dashboard. It is built for several open-source programs: each program is a *project*
in the config with its own fields, so another program can be added later without changing the code.
Today only StingyScan is configured. It is **not** part of the Stingy
Scanner extension package: `build.sh` only packages `htdocs/`, `plib/`, `sbin/` and `_meta/`.

```
collector/
├── public/            the web root: only index.php and .htaccess
├── src/               the code (outside the web root)
│   ├── app.php        routing: POST /check-in, POST /check-in/<project>, /dashboard
│   ├── Collector.php  validation, storage (upsert), rate limits
│   └── Dashboard.php  the private dashboard
├── bin/daily.php      daily: trend figures, retention, old rate counters
├── bin/selftest.php   after deploying: checks the config and the MariaDB statements (rolled back)
├── schema.sql         the tables
├── config.example.php the settings (the real file lives outside the web root)
└── tests/             php tests/CollectorTest.php (SQLite and PHP's built-in server)
```

## The endpoint

`POST https://stats.digizaal.nl/check-in` with `Content-Type: application/json` and exactly these fields:

| Field | Rule |
|---|---|
| `installation_id` | 32 lowercase hex characters |
| `hostname` | a host name, at most 253 characters (stored in lower case) |
| `version` | 1–32 characters: letters, digits, `.`, `-`, `+` |
| `hosted_sites` | a JSON integer from 0 to 1,000,000 (not a string, not a decimal) |

Anything else is refused: a missing or extra field, a wrong type, a body over 2 KB (`413`), another
content type (`415`), another method (`405`), an unknown path or project (`404`). A valid check-in
answers `200 {"ok":true}`. Too many requests from one address (20 an hour) or from everyone together
(300 a minute) answer `429` with `Retry-After`.

`POST /check-in` is StingyScan (the `default_project`); `POST /check-in/stingyscan` works too.

### Projects

Each program is defined under `projects` in the config (see `config.example.php`). Every project sends
`installation_id` and `version`. `hostname` only when the project says so (`'hostname' => 'required'` or
`'optional'`; leave it at `'none'` for desktop or browser software, so no personal computer names arrive).
Then its own fields, at most 12:

| Type | Rule | On the dashboard |
|---|---|---|
| `int` | whole number between `min` and `max` | with `'sum' => true` a total (StingyScan's `hosted_sites`), otherwise a breakdown |
| `enum` | one of `values` | a breakdown |
| `bool` | `true` or `false` | a breakdown (yes / no) |
| `string` | at most 64 characters matching `pattern` | a breakdown (top 20) |

A check-in must contain exactly the project's fields; `'optional' => true` fields may be left out. The program
then checks in at `POST /check-in/<project key>`. `bin/selftest.php` and `bin/daily.php` check the definitions.
Removing a project from the config deletes its installations at the next daily run.

**Storage:** one row per project and installation (`PRIMARY KEY (project, installation_id)`) with the project's
fields as JSON in `data`, written by one atomic `INSERT … ON DUPLICATE KEY UPDATE` with prepared statements.
A repeated check-in updates the row (latest host name, version and fields) and counts once. `first_seen` and `last_seen` use the collector's own
clock (UTC). **Check-ins are self-reported**: nothing is verified beyond its format, so treat the figures
as estimates.

**No IP addresses** are stored in the database, and the collector never logs request bodies or addresses.
The rate limits count in small files outside the web root whose names are HMACs of the address and the
hour, so the addresses themselves are never written down (see *Access logs* for the web server's own logs).

## Dashboard

`https://stats.digizaal.nl/dashboard`: log in with the user and password hash from the config (10 attempts per
15 minutes per address; forms carry a CSRF token; the session cookie is `Secure`, `HttpOnly`, `SameSite=Strict`).

- **Overview:** one card per project: active installations (distinct installations seen in the last 30 days,
  `active_days`), the change over the last 90 days with a small trend line, the newest version, new installations,
  and the totals (StingyScan: hosted websites).
- **Project page:** active, new and stored installations and the totals; a chart of active installations per day
  (up to a year); active installations by version; a breakdown per field; and one row per installation: host name,
  version, hosted websites, last seen, first seen and number of check-ins (grey: not seen in the last 30 days).

Totals use the latest check-in of each installation only; older check-ins are not kept. The trend chart uses
the daily figures that `bin/daily.php` saves (totals only, no installations), so it fills in from its first run.

## When an installation switches sharing off

It simply stops checking in; the collector is not told. Its row stays as it was, stops counting as active
after 30 days, and is **deleted by `bin/daily.php` once it is older than `retention_days` (default 90; a project
can have its own)**.
To delete one sooner (on request), as the database user:
`DELETE FROM installations WHERE project = 'stingyscan' AND hostname = 'server.example.com';`

## Deploying on Plesk

1. **Subscription:** create `stats.digizaal.nl` (Websites & Domains → Add Domain), with a Let's Encrypt
   certificate and *Permanent SEO-safe 301 redirect from HTTP to HTTPS* on. PHP 8.1 or newer, FPM.
2. **Files:** upload the whole `collector/` folder to `/var/www/vhosts/stats.digizaal.nl/collector`
   (not into `httpdocs`). Then *Hosting Settings → Document root*: `collector/public`.
3. **Database:** *Databases → Add Database* `stats_collector` with user `stats_collector` (a strong password),
   then import `schema.sql` (phpMyAdmin → Import, or `mysql stats_collector < schema.sql`). The user needs
   only `SELECT, INSERT, UPDATE, DELETE` on this database.
4. **Config, outside the web root:**
   ```
   mkdir -p /var/www/vhosts/stats.digizaal.nl/private/ratelimit
   cp collector/config.example.php /var/www/vhosts/stats.digizaal.nl/private/stats-config.php
   chown -R <system user>:psacln /var/www/vhosts/stats.digizaal.nl/private
   chmod 600 /var/www/vhosts/stats.digizaal.nl/private/stats-config.php
   ```
   Fill in the database password and a random `secret` (`php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"`).
   Set the dashboard password with `php collector/bin/set-password.php [user]` as the site's system user: it asks
   twice without showing it and stores only the hash.
   The code finds the file at `private/stats-config.php` next to the `collector/` folder, or wherever the
   environment variable `STATS_CONFIG` points.

   *On juno* the collector lives in the digizaal.nl subscription: `/var/www/vhosts/digizaal.nl/stats.digizaal.nl/collector`
   (document root `stats.digizaal.nl/collector/public`), the config in `…/stats.digizaal.nl/private/stats-config.php`,
   database `stats_collector`, and the daily job in `/etc/cron.d/stats-digizaal` (as user `digiadm`, log in `private/daily.log`).
   The files in `public/` must be readable by Apache (644), the rest only by the site user.
5. **Daily job:** *Scheduled Tasks → Add Task*, daily (for example 00:05), run a PHP script:
   `/var/www/vhosts/stats.digizaal.nl/collector/bin/daily.php` (trend figures, retention, old rate counters).
6. **Check:**
   ```
   php /var/www/vhosts/stats.digizaal.nl/collector/bin/selftest.php      # ok: config, upsert, daily figures
   curl -s -X POST https://stats.digizaal.nl/check-in -H 'Content-Type: application/json' \
        -d '{"installation_id":"00000000000000000000000000000000","hostname":"test.example","version":"0.0.0","hosted_sites":0}'
   # {"ok":true}; then delete the test row:
   # DELETE FROM installations WHERE installation_id = '00000000000000000000000000000000';
   curl -s -o /dev/null -w '%{http_code}\n' https://stats.digizaal.nl/check-in                         # 405
   ```
   Then log in at `/dashboard`.

With Apache (Plesk's default *proxy mode*), `public/.htaccess` sends every request to `index.php` and refuses
bodies over 4 KB. With nginx only (proxy mode off), add to *Apache & nginx Settings → Additional nginx
directives*:
```
location / { try_files $uri /index.php$is_args$args; }
client_max_body_size 4k;
```

## Access logs

The collector writes no logs of its own (only `storage error` lines, without request data, to the PHP error
log). Plesk's web server **does** log every request with the visitor's IP address in
`/var/www/vhosts/system/stats.digizaal.nl/logs/`. To keep check-in addresses out of those logs:

- **Simplest:** *Logs → Log Rotation*: rotate daily and keep few files (for example 3), so addresses are kept only
  briefly for troubleshooting and abuse handling.
- **No access log for the endpoint (nginx serves PHP):** turn *Proxy mode* off in *Apache & nginx Settings* (PHP
  then runs through FPM served by nginx) and add to *Additional nginx directives*:
  ```
  location = /check-in {
      access_log off;
      include /etc/nginx/fastcgi.conf;
      fastcgi_param SCRIPT_FILENAME $document_root/index.php;
      fastcgi_pass "unix:/var/www/vhosts/system/stats.digizaal.nl/php-fpm.sock";
  }
  ```
  Repeat it for `location ^~ /check-in/` when another project checks in. Check the socket path on your server
  (`ls /var/www/vhosts/system/stats.digizaal.nl/`). The dashboard stays logged, which is useful to spot
  login attempts.

## Tests

`php collector/tests/CollectorTest.php` (needs `pdo_sqlite` and `curl`, 60 checks): the config check, routing,
every validation rule (also for a project defined differently), the upsert counting repeated check-ins once,
totals of active installations only, daily figures, retention, the rate limiter (no addresses on disk), the
HTTP endpoint through PHP's built-in server, and the dashboard (login, CSRF, wrong password, logout, login rate
limit, overview and project page). `bin/selftest.php` checks the real MariaDB statements after deploying.
