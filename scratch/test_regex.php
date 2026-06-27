<?php

function getNextSkuNum($prefix, $skus) {
    $maxNum = 0;
    foreach ($skus as $sku) {
        if (preg_match('/^' . preg_quote($prefix, '/') . '-?([0-9]+)$/i', $sku, $matches)) {
            $num = (int)$matches[1];
            if ($num > $maxNum) {
                $maxNum = $num;
            }
        }
    }
    return $maxNum + 1;
}

$testCases = [
    ['A', ['A-001', 'A-002', 'A003', 'A-025-XYZ'], 4],
    ['D', ['D001', 'D-002'], 3],
    ['BRG', ['BRG-001', 'BRG002', 'BRG-003'], 4],
    ['E', ['E-001', 'E-002'], 3],
];

foreach ($testCases as $case) {
    $prefix = $case[0];
    $skus = $case[1];
    $expected = $case[2];
    $next = getNextSkuNum($prefix, $skus);
    echo "Prefix: $prefix | Expected: $expected | Actual: $next | " . ($next === $expected ? "PASS" : "FAIL") . "\n";
}
