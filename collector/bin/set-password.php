<?php
declare(strict_types=1);
// Set the dashboard password: php bin/set-password.php [user]
// Asks for the password twice without showing it, and stores only its hash in the config file.
require dirname(__DIR__) . '/src/app.php';
$file = getenv('STATS_CONFIG') ?: dirname(__DIR__, 2) . '/private/stats-config.php';
if (!is_file($file) || !is_writable($file)) { fwrite(STDERR, "Config not found or not writable: $file\n"); exit(1); }
$tty = stream_isatty(STDIN); // check once, before anything is read
$ask = function (string $q) use ($tty): string {
    fwrite(STDOUT, $q);
    if ($tty) shell_exec('stty -echo');
    $v = rtrim((string)fgets(STDIN), "\r\n");
    if ($tty) { shell_exec('stty echo'); fwrite(STDOUT, "\n"); }
    return $v;
};
$p1 = $ask('New dashboard password: ');
$p2 = $ask('Again: ');
if ($p1 !== $p2) { fwrite(STDERR, "The passwords differ. Nothing changed.\n"); exit(1); }
if (strlen($p1) < 12) { fwrite(STDERR, "Use at least 12 characters. Nothing changed.\n"); exit(1); }
$hash = password_hash($p1, PASSWORD_DEFAULT);
$src  = (string)file_get_contents($file);
// Only inside the 'dashboard' block: the 'db' block has a 'user' of its own
$at = strpos($src, "'dashboard'");
if ($at === false) { fwrite(STDERR, "Could not find 'dashboard' in the config. Nothing changed.\n"); exit(1); }
$head = substr($src, 0, $at); $block = substr($src, $at);
// Callbacks, not replacement strings: the hash contains "$2y$10$", which would be read as group references
$block = preg_replace_callback("/'password_hash'\\s*=>\\s*'[^']*'/", fn() => "'password_hash' => " . var_export($hash, true), $block, 1, $n);
if ($n !== 1) { fwrite(STDERR, "Could not find 'password_hash' in the dashboard block. Nothing changed.\n"); exit(1); }
if (isset($argv[1]) && preg_match('/^[A-Za-z0-9._@\-]{1,64}$/', $argv[1])) $block = preg_replace_callback("/'user'\\s*=>\\s*'[^']*'/", fn() => "'user' => " . var_export($argv[1], true), $block, 1);
$new = $head . $block;
file_put_contents($file . '.tmp', $new);
chmod($file . '.tmp', 0600);
rename($file . '.tmp', $file);
echo "Dashboard password set" . (isset($argv[1]) ? " for user {$argv[1]}" : '') . ". Log in at https://stats.digizaal.nl/dashboard\n";
