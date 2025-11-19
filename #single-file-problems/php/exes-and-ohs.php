<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => 'xo',
        'output' => true,
    ],
    [
        'name' => 'Test 2',
        'input' => 'XO',
        'output' => true,
    ],
    [
        'name' => 'Test 3',
        'input' => 'xo0',
        'output' => true,
    ],
    [
        'name' => 'Test 4',
        'input' => 'xxxoo',
        'output' => false,
    ],
    [
        'name' => 'Test 5',
        'input' => 'xxOo',
        'output' => true,
    ],
];

foreach ($testCases as $testCase) {
    $result = exes_and_ohs($testCase['input']);
    $status = $result === $testCase['output'] ? 'PASSED' : 'FAILED';
    echo "{$testCase['name']}: {$status}\n\n";
}

function exes_and_ohs(string $str): bool
{
    $str = strtolower($str);
    return substr_count($str, 'x') === substr_count($str, 'o');
}
