<?php
/**
 * One-shot import: stamps confirmed_at on vt_reviews.json for every vendor
 * confirmation in the list below.
 *
 * Run on the server:
 *   php /tmp/import_confirmations.php
 *
 * Safe to run more than once — existing confirmed_at values are kept.
 */

$dataFile = '/usr/local/psa/var/modules/stingyscan/data/vt_reviews.json';

// ── Vendor name aliases ───────────────────────────────────────
// Left  = what you wrote in your CSV (lowercase for matching)
// Right = exact name as VirusTotal shows it in flagged_by
// Verify these against your vt_reviews.json if any show SKIPPED below.
$aliases = [
    'alphamountain'          => 'alphaMountain.ai',
    'bitdefender'            => 'BitDefender',
    'brightcloud / opentext' => 'Webroot',
    'fortiguard / fortinet'  => 'Fortinet',
    'g data'                 => 'G-Data',
    'gridinsoft'             => 'Gridinsoft',
    'malwarebytes'           => 'Malwarebytes',
    'symantec / broadcom'    => 'Symantec',
];

// ── Confirmations (provider, domain, date YYYY-MM-DD) ────────
$rows = [
    ['alphaMountain',         'art-in-energy.nl',              '2026-11-26'],
    ['alphaMountain',         'camilledolibeau.com',           '2026-11-23'],
    ['alphaMountain',         'culturelestelling.amsterdam',   '2026-11-18'],
    ['alphaMountain',         'fcydesign.nl',                  '2026-11-21'],
    ['alphaMountain',         'flyingstreet.art',              '2026-11-19'],
    ['alphaMountain',         'fransschellekens.nl',           '2026-11-25'],
    ['alphaMountain',         'kajvenhuizen.com',              '2026-11-24'],
    ['alphaMountain',         'lauria-art.com',                '2026-11-19'],
    ['alphaMountain',         'microscience.nl',               '2026-11-23'],
    ['alphaMountain',         'olifanttakeover.com',           '2026-11-25'],
    ['alphaMountain',         'psychotropica.nl',              '2026-11-20'],
    ['alphaMountain',         'wadoesters.nl',                 '2026-11-22'],
    ['Bitdefender',           'fcydesign.nl',                  '2026-11-22'],
    ['Bitdefender',           'flyingstreet.art',              '2026-11-26'],
    ['BrightCloud / OpenText','flyingstreet.art',              '2026-11-19'],
    ['FortiGuard / Fortinet', 'art-in-energy.nl',              '2026-11-25'],
    ['FortiGuard / Fortinet', 'bmsprocesfinanciering.nl',      '2026-11-18'],
    ['FortiGuard / Fortinet', 'camilledolibeau.com',           '2026-11-23'],
    ['FortiGuard / Fortinet', 'culturelestelling.amsterdam',   '2026-11-19'],
    ['FortiGuard / Fortinet', 'fcydesign.nl',                  '2026-11-22'],
    ['FortiGuard / Fortinet', 'flyingstreet.art',              '2026-11-18'],
    ['FortiGuard / Fortinet', 'inekevanstraeten.nl',           '2026-11-23'],
    ['FortiGuard / Fortinet', 'kajvenhuizen.com',              '2026-11-24'],
    ['FortiGuard / Fortinet', 'lauria-art.com',                '2026-11-23'],
    ['FortiGuard / Fortinet', 'microscience.nl',               '2026-11-24'],
    ['FortiGuard / Fortinet', 'olifanttakeover.com',           '2026-11-23'],
    ['FortiGuard / Fortinet', 'slordig.net',                   '2026-11-19'],
    ['FortiGuard / Fortinet', 'speedlounger.com',              '2026-11-24'],
    ['FortiGuard / Fortinet', 'staging.wadoesters.nl',         '2026-11-20'],
    ['FortiGuard / Fortinet', 'wadoesters.nl',                 '2026-11-20'],
    ['FortiGuard / Fortinet', 'zwaansails.nl',                 '2026-11-26'],
    ['G DATA',                'fcydesign.nl',                  '2026-11-23'],
    ['G DATA',                'flyingstreet.art',              '2026-11-27'],
    ['Gridinsoft',            'bmsprocesfinanciering.nl',      '2026-11-19'],
    ['Gridinsoft',            'fransschellekens.nl',           '2026-11-22'],
    ['Malwarebytes',          'art-in-energy.nl',              '2026-11-17'],
    ['Symantec / Broadcom',   'alufleet.nl',                   '2020-04-09'],
];

// ── Load existing data ────────────────────────────────────────
$lock = @fopen($dataFile . '.lock', 'c');
if ($lock) flock($lock, LOCK_EX);

$all = [];
if (is_file($dataFile)) {
    $raw = json_decode(file_get_contents($dataFile), true);
    if (is_array($raw)) $all = $raw;
}

// ── Import ────────────────────────────────────────────────────
$imported = 0; $skipped = 0; $already = 0;

foreach ($rows as [$csvVendor, $domain, $dateStr]) {
    $vtVendor = $aliases[strtolower($csvVendor)] ?? null;
    if (!$vtVendor) {
        echo "SKIPPED  [$csvVendor] $domain — no alias mapping, add it to \$aliases\n";
        $skipped++;
        continue;
    }

    // Parse date as noon UTC
    $ts = strtotime($dateStr . ' 12:00:00 UTC');
    if (!$ts) {
        echo "SKIPPED  [$vtVendor] $domain — could not parse date $dateStr\n";
        $skipped++;
        continue;
    }

    // Keep any existing ts/by; create a stub entry if none exists yet
    if (!isset($all[$domain][$vtVendor])) {
        $all[$domain][$vtVendor] = ['ts' => $ts - 86400, 'by' => 'admin']; // request day before
    }

    // Don't overwrite a newer confirmed_at
    if (!empty($all[$domain][$vtVendor]['confirmed_at']) && $all[$domain][$vtVendor]['confirmed_at'] >= $ts) {
        echo "ALREADY  [$vtVendor] $domain\n";
        $already++;
        continue;
    }

    $all[$domain][$vtVendor]['confirmed_at'] = $ts;
    echo "IMPORTED [$vtVendor] $domain ($dateStr)\n";
    $imported++;
}

// ── Save ──────────────────────────────────────────────────────
$tmp = $dataFile . '.tmp';
if (file_put_contents($tmp, json_encode($all, JSON_PRETTY_PRINT)) !== false) {
    rename($tmp, $dataFile);
    echo "\nDone. $imported imported, $already already set, $skipped skipped.\n";
    echo "Data file: $dataFile\n";
} else {
    echo "\nERROR: could not write $dataFile — check permissions.\n";
}

if ($lock) { flock($lock, LOCK_UN); fclose($lock); }
