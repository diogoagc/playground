<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => [5, 3, 7],
        'output' => [15]
    ],
    [
        'name' => 'Test 2',
        'input' => [5, 3, 9],
        'output' => [8, 9]
    ],
    [
        'name' => 'Test 3',
        'input' => [1, 2, 3],
        'output' => [1, 2, 3]
    ],
    [
        'name' => 'Test 4',
        'input' => [2, 1, 3],
        'output' => [3, 3]
    ],
    [
        'name' => 'Test 5',
        'input' => [8, 5, 9],
        'output' => [22]
    ],
    [
        'name' => 'Test 6',
        'input' => [6, 5, 6, 100],
        'output' => [17, 100]
    ],
];

foreach ($testCases as $testCase) {
    $result = nom_nom_numbers($testCase['input']);
    $status = $result === $testCase['output'] ? 'PASSED' : 'FAILED';
    echo "{$testCase['name']}: {$status}\n\n";
}

function nom_nom_numbers(array $input): array
{
    while(
        count($input) > 1
        && $input[0] > $input[1]
    ) {
        $input[1] += $input[0];
        array_shift($input);
    }

    return $input;
}
