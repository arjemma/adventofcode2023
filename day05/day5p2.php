<?php
// For a faster solution, see day5p2.js
$inputData = './inputs/day5.txt';
$lines = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function parseInput($lines) {
    // Expand seed ranges from the first line
    $seedPairs = array_map('intval', explode(' ', trim(explode(': ', $lines[0])[1])));
    $seeds = [];
    for ($i = 0; $i < count($seedPairs); $i += 2) {
        $start = $seedPairs[$i];
        $length = $seedPairs[$i + 1];
        for ($j = 0; $j < $length; $j++) {
            $seeds[] = $start + $j;
        }
    }

    // Parse the maps
    $maps = [];
    $currentMap = [];
    foreach (array_slice($lines, 1) as $line) {
        if (strpos($line, 'map:') !== false) {
            if (!empty($currentMap)) {
                $maps[] = $currentMap;
                $currentMap = [];
            }
        } elseif (!empty(trim($line))) {
            $currentMap[] = array_map('intval', explode(' ', trim($line)));
        }
    }
    if (!empty($currentMap)) {
        $maps[] = $currentMap;
    }

    return [$seeds, $maps];
}

function findMinimumLocation($seeds, $maps) {
    $minSeedLocation = PHP_INT_MAX;

    foreach ($seeds as $seed) {
        $currentValue = $seed;

        // Apply each map in sequence to transform the current value
        foreach ($maps as $map) {
            foreach ($map as [$destStart, $srcStart, $rangeLength]) {
                if ($currentValue >= $srcStart && $currentValue < $srcStart + $rangeLength) {
                    $currentValue = $destStart + ($currentValue - $srcStart);
                    break;
                }
            }
        }

        // Track the minimum location value across all transformed seeds
        $minSeedLocation = min($minSeedLocation, $currentValue);
    }

    return $minSeedLocation;
}

// Parse the seeds and maps from the input
list($seeds, $maps) = parseInput($lines);

// Find the minimum location value for any of the initial seeds
$minLocation = findMinimumLocation($seeds, $maps);

echo "The lowest location number: " . $minLocation . PHP_EOL;

?>