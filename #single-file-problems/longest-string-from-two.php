<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => ["aretheyhere", "yestheyarehere"],
        'output' => "aehrsty",
    ],
    [
        'name' => 'Test 2',
        'input' => ["loopingisfunbutdangerous", "lessdangerousthancoding"],
        'output' => "abcdefghilnoprstu",
    ],
    [
        'name' => 'Test 3',
        'input' => ["inmanylanguages", "theresapairoffunctions"],
        'output' => "acefghilmnoprstuy",
    ],
    [
        'name' => 'Test 4',
        'input' => ["lordsofthefallen", "gamekult"],
        'output' => "adefghklmnorstu",
    ],
];

foreach ($testCases as $testCase) {
    $result = longest_string_from_two($testCase['input'][0], $testCase['input'][1]);
    if ($result === $testCase['output']) {
        echo $testCase['name'] . ": PASSED\n";
    } else {
        echo $testCase['name'] . ": FAILED (Expected " . $testCase['output'] . ", got " . $result . ")\n";
    }
}

function longest_string_from_two(string $str1, string $str2): string
{
    $finalString = str_split(count_chars($str1 . $str2, 3));
    sort( $finalString);
    return implode( $finalString);
}