<?php
$inputData = './inputs/day4.txt';
$input = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function calculatePoints(array $input): int {
    $totalPoints = 0;

    foreach ($input as $line) {
        // Remove the "Card X:" prefix
        $line = preg_replace('/^Card\s+\d+:\s*/', '', $line);

        // Split the line into winning numbers and your numbers
        [$winningPart, $yourPart] = explode('|', $line);
        
        // Convert both parts to arrays of integers
        $winningNumbers = array_map('intval', preg_split('/\s+/', trim($winningPart)));
        $yourNumbers = array_map('intval', preg_split('/\s+/', trim($yourPart)));
        
        // Create a set of winning numbers for quick lookup
        $winningSet = array_flip($winningNumbers);

        // Initialize points for this card
        $cardPoints = 0;
        $matchCount = 0;

        // Calculate points for each match
        foreach ($yourNumbers as $num) {
            if (isset($winningSet[$num])) {
                $matchCount++;
                // First match gives 1 point, each subsequent match doubles the points
                $cardPoints = $cardPoints === 0 ? 1 : $cardPoints * 2;
            }
        }

        $totalPoints += $cardPoints;
    }

    return $totalPoints;
}

$totalPoints = calculatePoints($input);
echo "Total points: " . $totalPoints . PHP_EOL;

?>
