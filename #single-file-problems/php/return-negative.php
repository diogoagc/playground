<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => 1,
        'output' => -1,
    ],
    [
        'name' => 'Test 2',
        'input' => -5,
        'output' => -5,
    ],
    [
        'name' => 'Test 3',
        'input' => 0,
        'output' => 0,
    ],
    [
        'name' => 'Test 4',
        'input' => 42,
        'output' => -42,
    ],
];

foreach ($testCases as $testCase) {
    $result = return_negative($testCase['input']);
    if ($result === $testCase['output']) {
        echo $testCase['name'] . ": PASSED\n";
    } else {
        echo $testCase['name'] . ": FAILED (Expected " . $testCase['output'] . ", got " . $result . ")\n";
    }
}

function return_negative(int $number): int
{
    return $number > 0 ? -$number : $number;
}