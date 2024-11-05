<?php
$inputData = './inputs/day2.txt';
$lines = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$maxCubes = [
    "red" => 12,
    "green" => 13,
    "blue" => 14
];

$possibleGameIds = [];

foreach ($lines as $line) {
    if (preg_match('/^Game (\d+): (.+)$/', $line, $matches)) {
        $gameId = (int)$matches[1];
        $sets = explode(";", $matches[2]);

        $isPossible = true;

        foreach ($sets as $set) {
            $colorCounts = ["red" => 0, "green" => 0, "blue" => 0];

            preg_match_all('/(\d+) (\w+)/', $set, $setMatches, PREG_SET_ORDER);

            foreach ($setMatches as $match) {
                $count = (int)$match[1];
                $color = $match[2];
                $colorCounts[$color] += $count;
            }

            foreach ($colorCounts as $color => $count) {
                if ($count > $maxCubes[$color]) {
                    $isPossible = false;
                    break 2;
                }
            }
        }

        if ($isPossible) {
            $possibleGameIds[] = $gameId;
        }
    }
}

$sumOfPossibleGameIds = array_sum($possibleGameIds);

echo "Total sum: " . $sumOfPossibleGameIds . PHP_EOL;

// Right answer: 2685

?>