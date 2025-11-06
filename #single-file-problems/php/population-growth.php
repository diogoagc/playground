<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => [1500, 5, 100, 5000],
        'output' => 15
    ],
    [
        'name' => 'Test 2',
        'input' => [1500000, 2.5, 10000, 2000000],
        'output' => 10
    ]
];

foreach ($testCases as $testCase) {
    $result = population_growth(...$testCase['input']);
    if ($result === $testCase['output']) {
        echo $testCase['name'] . ": PASSED\n";
    } else {
        echo $testCase['name'] . ": FAILED (Expected \n" . $testCase['output'] . ", got \n" . $result . ")\n";
    }
}

function population_growth($p0, $percent, $aug, $p): int
{
    $numberOfYears = 0;
    $decimal = $percent / 100;

    while ($p0 < $p) {
        $p0 += $p0 * $decimal + $aug;
        $numberOfYears++;
    }

    return $numberOfYears;
}