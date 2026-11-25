<?php
// php tests/ExternalTest.php: typed or pasted addresses of external sites become a bare domain name
require __DIR__ . '/../plib/library/VtExternal.php';

$fail = 0;
foreach ([
    'example.com' => 'example.com', 'https://www.Example.com/path?x=1' => 'example.com', 'http://shop.example.co.uk:8080/' => 'shop.example.co.uk',
    'example.com.' => 'example.com', 'not a domain' => '', 'localhost' => '', 'exa_mple.com' => '', '' => '',
] as $in => $want) {
    $ok = VtExternal::normalize($in) === $want;
    echo ($ok ? 'ok   ' : 'FAIL ') . "normalize '$in'\n";
    if (!$ok) $fail++;
}
echo $fail ? "$fail failed\n" : "all passed\n";
exit($fail ? 1 : 0);
