<?php
$inputData = file_get_contents('./inputs/day5.txt');

function parseInput($input) {
    // Split input by lines and extract seeds and maps
    $lines = explode("\n", $input);
    $seeds = array_map('intval', explode(' ', trim(explode(': ', $lines[0])[1])));

    // Parse maps
    $maps = [];
    $currentMap = [];
    foreach (array_slice($lines, 1) as $line) {
        if (strpos($line, 'map:') !== false) {
            // Start of a new map section
            if (!empty($currentMap)) {
                $maps[] = $currentMap;
                $currentMap = [];
            }
        } elseif (!empty(trim($line))) {
            // Parse each line within the map section
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
            // Find if currentValue falls within any range in this map
            foreach ($map as [$destStart, $srcStart, $rangeLength]) {
                if ($currentValue >= $srcStart && $currentValue < $srcStart + $rangeLength) {
                    // Map the currentValue using the destination offset
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

list($seeds, $maps) = parseInput($inputData);

// Find the minimum location value for any of the initial seeds
$minLocation = findMinimumLocation($seeds, $maps);

echo "The lowest location number: " . $minLocation . PHP_EOL;

?>