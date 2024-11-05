<?php
$inputData = './inputs/day2.txt';
$lines = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$totalSum = 0;

foreach ($lines as $line) {
    if (preg_match('/^Game (\d+): (.+)$/', $line, $matches)) {
        $gameId = (int)$matches[1];
        $sets = explode(";", $matches[2]);

        $minRequired = ["red" => 0, "green" => 0, "blue" => 0];

        foreach ($sets as $set) {
            $colorCounts = ["red" => 0, "green" => 0, "blue" => 0];

            preg_match_all('/(\d+) (\w+)/', $set, $setMatches, PREG_SET_ORDER);
            foreach ($setMatches as $match) {
                $count = (int)$match[1];
                $color = $match[2];
                $colorCounts[$color] += $count;
            }

            foreach ($colorCounts as $color => $count) {
                if ($count > $minRequired[$color]) {
                    $minRequired[$color] = $count;
                }
            }
        }

        $power = $minRequired["red"] * $minRequired["green"] * $minRequired["blue"];
        $totalSum += $power;
    }
}

echo "Total sum: " . $totalSum . PHP_EOL;

?>