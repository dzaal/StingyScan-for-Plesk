<?php
// php tests/ScanEngineTest.php: the engine choice for every combination of installed engines (mocked detection)
require __DIR__ . '/../plib/library/VtScanEngine.php';
$yes = ['installed' => true]; $no = ['installed' => false];
$cases = [
    // [name, clamav, maldet, maldet_enabled, expected id, expected label, expected message]
    ['ClamAV only',                $yes, $no,  false, 'clamav', 'ClamAV scan',        ''],
    ['ClamAV only (setting on)',   $yes, $no,  true,  'clamav', 'ClamAV scan',        ''],
    ['ClamAV + Maldet',            $yes, $yes, false, 'clamav', 'ClamAV/Maldet scan', ''],
    ['ClamAV + Maldet, setting on',$yes, $yes, true,  'clamav', 'ClamAV/Maldet scan', ''],
    ['Maldet only, setting on',    $no,  $yes, true,  'maldet', 'Maldet scan',        ''],
    ['Maldet only, setting off',   $no,  $yes, false, null,     'Maldet scan',        'Maldet is installed but disabled in settings'],
    ['Neither',                    $no,  $no,  true,  null,     'ClamAV scan',        'No scanner found (install ClamAV)'],
];
$fail = 0;
foreach ($cases as [$name, $c, $m, $on, $id, $label, $msg]) {
    $eng = ['clamav' => $c, 'maldet' => $m];
    $s = VtScanEngine::select($eng, $on);
    $b = VtScanEngine::buttons($eng, $on, false);
    $ok = $s['id'] === $id && $s['label'] === $label && $s['message'] === $msg
        && count($b) === 1 && $b[0]['label'] === $label && (empty($b[0]['disabled']) === ($id !== null))
        && VtScanEngine::mayRun('maldet', $eng, $on) === ($id === 'maldet')   // Maldet never runs next to ClamAV
        && VtScanEngine::mayRun('clamav', $eng, $on) === ($id === 'clamav');
    printf("%-30s %s  engine=%s label=\"%s\"%s\n", $name, $ok ? 'OK  ' : 'FAIL', $s['id'] ?? 'none', $s['label'], $s['message'] ? ' message="' . $s['message'] . '"' : '');
    $fail += $ok ? 0 : 1;
}
$b = VtScanEngine::buttons(['clamav' => $yes, 'maldet' => $yes], false, true);
$ok = count($b) === 2 && $b[1]['id'] === 'imunify';
printf("%-30s %s\n", 'Imunify results next to it', $ok ? 'OK' : 'FAIL'); $fail += $ok ? 0 : 1;
echo $fail ? "$fail FAILED\n" : "all passed\n";
exit($fail ? 1 : 0);
