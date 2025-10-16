<?php

function printAPSeries($first_number, $numberOfTerms): int {
    $commonDifference = (int) readline("Enter the common difference: ");
    echo 'AP Series: ';
    $number = $first_number;
    foreach (range(1, $numberOfTerms) as $loop) {
        echo $number . ' ';
        $number += $commonDifference;
    }
    echo "\n";
    return ($numberOfTerms / 2) * ((2 * $first_number) + ($numberOfTerms - 1) * $commonDifference);
}

function printGPSeries($first_number, $numberOfTerms): int {
    $commonRatio = (int) readline("Enter the common ratio: ");
    echo "GP Series: ";
    $number = $first_number;
    foreach (range(1, $numberOfTerms) as $loop) {
        echo $number . ' ';
        $number *= $commonRatio;
    }
    echo "\n";
    return ($first_number * (pow($commonRatio, $numberOfTerms) - 1)) / ($commonRatio - 1);
}



$progressiontype = (string) strtoupper(readline("Which progression do you want to calculate? (Enter 'AP' or 'GP'): "));
$first_number = (int) readline("Enter the first number: ");
$numberOfTerms = (int) readline("Enter the number of terms: ");


$result = match($progressiontype) {
    'AP' => printAPSeries($first_number , $numberOfTerms),
    'GP' => printGPSeries($first_number, $numberOfTerms),
    default => null
};

echo ($result != null) ? $progressiontype .' Sum is :'. $result : 'Invalid Progression Type Entered';



