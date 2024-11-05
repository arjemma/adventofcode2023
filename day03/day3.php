<?php
$inputData = './inputs/day3.txt';
$input = array_map('str_split', file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

// Define adjacent directions for checking symbols
$adjacentCells = [
    [-1, 0], [1, 0], // Up, Down
    [0, -1], [0, 1], // Left, Right
    [-1, -1], [1, 1], [-1, 1], [1, -1] // Diagonals
];

// Check if a symbol is adjacent to a position
function hasAdjacentSymbol($grid, $y, $x) {
    global $adjacentCells;

    foreach ($adjacentCells as [$dy, $dx]) {
        $adjY = $y + $dy;
        $adjX = $x + $dx;
        if (isset($grid[$adjY][$adjX]) && !ctype_digit($grid[$adjY][$adjX]) && $grid[$adjY][$adjX] !== '.') {
            return true;
        }
    }
    return false;
}

// Main function to solve the puzzle
function solvePuzzle($grid) {
    $totalSum = 0;

    for ($y = 0; $y < count($grid); $y++) {
        $currentNumber = '';
        $hasAdjacentSymbol = false;

        for ($x = 0; $x <= count($grid[$y]); $x++) {
            if (!isset($grid[$y][$x]) || !ctype_digit($grid[$y][$x])) {
                if ($hasAdjacentSymbol && $currentNumber !== '') {
                    $totalSum += (int)$currentNumber;
                }
                $currentNumber = '';
                $hasAdjacentSymbol = false;
                continue;
            }

            $currentNumber .= $grid[$y][$x];

            // Check if this cell is adjacent to a symbol
            if (hasAdjacentSymbol($grid, $y, $x)) {
                $hasAdjacentSymbol = true;
            }
        }
    }

    return $totalSum;
}

$sumOfPartNumbers = solvePuzzle($input);
echo "Sum of part numbers: " . $sumOfPartNumbers . PHP_EOL;

?>
