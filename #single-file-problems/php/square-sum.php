<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => [1, 2],
        'output' => 5,
    ],
    [
        'name' => 'Test 2',
        'input' => [0, 3, 4, 5],
        'output' => 50,
    ],
    [
        'name' => 'Test 3',
        'input' => [],
        'output' => 0,
    ],
    [
        'name' => 'Test 4',
        'input' => [-1, -2],
        'output' => 5,
    ],
    [
        'name' => 'Test 5',
        'input' => [-1, 0, 1],
        'output' => 2,
    ],
];

foreach ($testCases as $testCase) {
    $result = square_sum($testCase['input']);
    if ($result === $testCase['output']) {
        echo $testCase['name'] . ": PASSED\n";
    } else {
        echo $testCase['name'] . ": FAILED (Expected " . $testCase['output'] . ", got " . $result . ")\n";
    }
}

function square_sum(array $numbers): int
{
    return array_reduce(
        $numbers,
        fn($result, $number) => $result + $number * $number,
        0
    );
}