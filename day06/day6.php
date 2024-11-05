<?php
$inputFile = './inputs/day6.txt';
$inputContent = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function parseRaces($inputContent) {
    // Ensure that each line has content after the colon before trying to split and parse
    $timesLine = explode(':', $inputContent[0]);
    $distancesLine = explode(':', $inputContent[1]);

    // Use the second part only if it exists, otherwise use an empty string
    $times = isset($timesLine[1]) ? array_map('intval', preg_split('/\s+/', trim($timesLine[1]))) : [];
    $distances = isset($distancesLine[1]) ? array_map('intval', preg_split('/\s+/', trim($distancesLine[1]))) : [];

    // Combine times and distances into pairs for each race
    $races = [];
    foreach ($times as $index => $time) {
        $races[] = [$time, $distances[$index] ?? 0]; // Use 0 if distance is missing
    }

    return $races;
}

function calculateWaysToWin($races) {
    $totalWays = 1;

    foreach ($races as [$time, $record]) {
        $waysToWin = 0;

        // Try each possible button-hold time (t) from 1 up to the race time - 1
        for ($t = 1; $t < $time; $t++) {
            // Calculate distance covered with the current button-hold time (t)
            $distance = $t * ($time - $t);

            // Check if this distance beats the record
            if ($distance > $record) {
                $waysToWin++;
            }
        }

        // Multiply the total ways by the ways to win for this race
        $totalWays *= $waysToWin;
    }

    return $totalWays;
}

// Parse the input from the file
$races = parseRaces($inputContent);

echo "Ways to win: " . calculateWaysToWin($races) . PHP_EOL;

?>