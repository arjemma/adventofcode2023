<?php
$inputData = './inputs/day1.txt';
$lines = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$totalSum = 0;

$numberMappings = [
    'one' => 'one1one',
    'two' => 'two2two',
    'three' => 'three3three',
    'four' => 'four4four',
    'five' => 'five5five',
    'six' => 'six6six',
    'seven' => 'seven7seven',
    'eight' => 'eight8eight',
    'nine' => 'nine9nine'
];

foreach ($lines as $line) {
    foreach ($numberMappings as $word => $replacement) {
        $line = str_ireplace($word, $replacement, $line);
    }

    $numbersArr = str_split($line);

    $numbersArr = array_filter($numbersArr, fn($el) => is_numeric($el));

    $numbers = implode('', $numbersArr);

    $firstAndLast = $numbers[0] . $numbers[strlen($numbers) - 1];
    $totalSum += (int)$firstAndLast;
}

echo "Total sum: " . $totalSum . PHP_EOL;

?>