<?php
$inputData = './inputs/day3.txt';
$input = array_map('str_split', file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

function getAdjacentNumbers(array $input, int $i, int $j): array {
    $adjacentNumbers = [];
    $adjacentCells = [
        [-1, 0], [1, 0], // Up, Down
        [0, -1], [0, 1], // Left, Right
        [-1, -1], [1, 1], [-1, 1], [1, -1] // Diagonals
    ];

    foreach ($adjacentCells as [$x, $y]) {
        $value = $input[$i + $y][$j + $x] ?? null;

        if (is_numeric($value)) {
            $fullNumber = getFullNumber($input, $i + $y, $j + $x);
            $adjacentNumbers[$fullNumber] = true; // Using associative array to avoid duplicates
        }
    }

    return array_keys($adjacentNumbers); // Return unique numbers
}

// Helper function to find the full number at a given position
function getFullNumber(array $input, int $i, int $j): string {
    $number = '';
    $maxX = count($input[0] ?? []);

    // Move left to find the start of the number
    $startX = $j;
    while ($startX > 0 && is_numeric($input[$i][$startX - 1])) {
        $startX--;
    }

    // Build the full number from left to right
    while ($startX < $maxX && is_numeric($input[$i][$startX])) {
        $number .= $input[$i][$startX];
        $startX++;
    }

    return $number;
}

function solvePuzzle(array $input): int {
    $total = 0;

    for ($i = 0; $i < count($input); $i++) {
        for ($j = 0; $j < count($input[$i]); $j++) {
            if ($input[$i][$j] !== '*') {
                continue;
            }

            $adjacentNumbers = getAdjacentNumbers($input, $i, $j);

            if (count($adjacentNumbers) === 2) {
                [$nb1, $nb2] = $adjacentNumbers;
                $product = intval($nb1) * intval($nb2);
                $total += $product;
            }
        }
    }

    return $total;
}

// Calculate and output the solution
$sumOfGearNumbers = solvePuzzle($input);
echo "Sum of gear numbers: " . $sumOfGearNumbers . PHP_EOL;
?>
