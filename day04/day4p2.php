<?php
$inputData = './inputs/day4.txt';
$input = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function calculateTotalScratchcards(array $input): int {
    // Initialize each card with 1 instance to represent the original card
    $scratchcardCopies = array_fill(0, count($input), 1);

    foreach ($input as $cardIndex => $line) {
        // Remove the "Card X:" prefix
        $line = preg_replace('/^Card\s+\d+:\s*/', '', $line);

        // Split the line into winning numbers and your numbers
        [$winningPart, $yourPart] = explode('|', $line);

        // Convert both parts to arrays of integers
        $winningNumbers = array_map('intval', preg_split('/\s+/', trim($winningPart)));
        $yourNumbers = array_map('intval', preg_split('/\s+/', trim($yourPart)));

        // Calculate the number of matching numbers
        $numberOfMatchingNumbers = count(array_intersect($winningNumbers, $yourNumbers));

        // For each matching number, increment the following cards
        for ($i = 0; $i < $numberOfMatchingNumbers; $i++) {
            if (isset($scratchcardCopies[$cardIndex + $i + 1])) {
                $scratchcardCopies[$cardIndex + $i + 1] += $scratchcardCopies[$cardIndex];
            }
        }
    }

    // Sum up all values in the cards array
    return array_sum($scratchcardCopies);
}

$totalCards = calculateTotalScratchcards($input);
echo "Total number of scratchcards: " . $totalCards . PHP_EOL;

?>