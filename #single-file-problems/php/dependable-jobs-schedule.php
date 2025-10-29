<?php

declare(strict_types=1);

$testCases = [
    [
        'name' => 'Test 1',
        'input' => [2, [[1, 0]]],
        'output' => true
    ],
    [
        'name' => 'Test 2',
        'input' => [2, [[1, 0], [0, 1]]],
        'output' => false
    ],
    [
        'name' => 'Test 3',
        'input' => [3, [[1, 0], [2, 1]]],
        'output' => true
    ],
    [
        'name' => 'Test 4',
        'input' => [1, []],
        'output' => true
    ],
    [
        'name' => 'Test 5',
        'input' => [11, [[6, 10], [4, 3], [9, 2], [2, 3], [6, 1], [2, 8], [10, 1], [10, 2], [5, 3], [0, 10], [7, 4], [6, 1]]],
        'output' => true
    ],
];

foreach ($testCases as $testCase) {
    // Toggle debug per test here:
    $result = canFinishAll(...$testCase['input'], debug: $testCase['name'] === 'Test 2' || $testCase['name'] === 'Test 5');
    $status = $result === $testCase['output'] ? 'PASSED' : 'FAILED';
    echo "{$testCase['name']}: {$status}\n\n";
}

/**
 * Each dependency [A,B] means B -> A (A depends on B).
 * If $debug = true, prints step-by-step state.
 */
function canFinishAll(int $jobsCount, array $dependencies, bool $debug = false): bool
{
    if ($jobsCount <= 1) {
        if ($debug) echo "[Init] jobsCount <= 1, trivially true\n";
        return true;
    }

    // Build graph & indegrees
    $graph = array_fill(0, $jobsCount, []);
    $indegree = array_fill(0, $jobsCount, 0);

    foreach ($dependencies as $dep) {
        [$a, $b] = $dep; // A depends on B  => edge B -> A
        if ($a < 0 || $a >= $jobsCount || $b < 0 || $b >= $jobsCount) {
            throw new InvalidArgumentException('Dependency contains an invalid job id.');
        }
        $graph[$b][] = $a;
        $indegree[$a]++;
    }

    if ($debug) {
        echo "=== Build Phase ===\n";
        echo "[Dependencies] " . json_encode($dependencies) . "\n";
        echo "[Graph B->A]   " . json_encode($graph) . "\n";
        echo "[Indegree]     " . json_encode($indegree) . "\n\n";
    }

    // Initialize queue with all nodes having indegree 0
    $q = new SplQueue();
    for ($i = 0; $i < $jobsCount; $i++) {
        if ($indegree[$i] === 0) {
            $q->enqueue($i);
        }
    }

    if ($debug) {
        echo "=== Init Queue ===\n";
        echo "[Queue] " . json_encode(queueToArray($q)) . "\n\n";
    }

    $visited = 0;

    // Kahn's algorithm
    while (!$q->isEmpty()) {
        $u = $q->dequeue();
        $visited++;

        if ($debug) {
            echo "=== Visit $u ===\n";
            echo "Visited count: $visited / $jobsCount\n";
            echo "Neighbors: " . json_encode($graph[$u]) . "\n";
        }

        foreach ($graph[$u] as $v) {
            $indegree[$v]--;
            if ($debug) {
                echo "  Decrement indegree[$v] -> {$indegree[$v]}\n";
            }
            if ($indegree[$v] === 0) {
                $q->enqueue($v);
                if ($debug) {
                    echo "  Enqueue $v (now indegree 0)\n";
                }
            }
        }

        if ($debug) {
            echo "[Queue after $u] " . json_encode(queueToArray($q)) . "\n";
            echo "[Indegree]       " . json_encode($indegree) . "\n\n";
        }
    }

    $ok = ($visited === $jobsCount);

    if ($debug) {
        echo "=== Result ===\n";
        echo "Visited: $visited of $jobsCount -> " . ($ok ? "true" : "false") . "\n\n";
    }

    return $ok;
}

/** Helper: snapshot queue to array without consuming it */
function queueToArray(SplQueue $q): array
{
    $copy = clone $q;
    $copy->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
    $out = [];
    foreach ($copy as $x) {
        $out[] = $x;
    }
    return $out;
}
