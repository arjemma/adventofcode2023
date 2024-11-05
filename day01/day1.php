<?php
$inputData = './inputs/day1.txt';
$lines = file($inputData, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$totalSum = 0;

foreach ($lines as $line) {
    preg_match('/\d/', $line, $firstDigit);
    preg_match('/\d(?!.*\d)/', $line, $lastDigit);

    if (!empty($firstDigit) && !empty($lastDigit)) {
        $calibrationValue = (int)($firstDigit[0] . $lastDigit[0]);
        $totalSum += $calibrationValue;
    }
}

echo "Total sum: " . $totalSum . PHP_EOL;

?>