<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => "1234",
        'output' => 1234,
    ],
    [
        'name' => 'Test 2',
        'input' => "605",
        'output' => 605,
    ],
    [
        'name' => 'Test 3',
        'input' => "1405",
        'output' => 1405,
    ],
    [
        'name' => 'Test 4',
        'input' => "-7",
        'output' => -7,
    ],
];

foreach ($testCases as $testCase) {
    $result = string_to_number($testCase['input']);
    if ($result === $testCase['output']) {
        echo $testCase['name'] . ": PASSED\n";
    } else {
        echo $testCase['name'] . ": FAILED (Expected " . $testCase['output'] . ", got " . $result . ")\n";
    }
}

function string_to_number(string $str): int
{
    return intval($str);
}