<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => 'The sunset sets at twelve o\' clock.',
        'output' => '20 8 5 19 21 14 19 5 20 19 5 20 19 1 20 20 23 5 12 22 5 15 3 12 15 3 11',
    ],
    [
        'name' => 'Test 2',
        'input' => 'The narwhal bacons at midnight.',
        'output' => '20 8 5 14 1 18 23 8 1 12 2 1 3 15 14 19 1 20 13 9 4 14 9 7 8 20',
    ]
];

foreach ($testCases as $testCase) {
    $result = alphabet_position($testCase['input']);
    if ($result === $testCase['output']) {
        echo $testCase['name'] . ": PASSED\n";
    } else {
        echo $testCase['name'] . ": FAILED (Expected \n" . $testCase['output'] . ", got \n" . $result . ")\n";
    }
}

/**
 * Not the most beautiful solution...
 * It serves the purpose. No time for better today.
 */
function alphabet_position(string $text): string
{
    $chars = str_split(strtolower($text), 1);
    $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $result = '';

    foreach ($chars as $char) {
        $key = array_search($char, $alphabet);

        if ($key === false) {
            continue;
        }

        $result .= ($key + 1) . ' ';
    }

    return trim($result);
}