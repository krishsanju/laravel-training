<?php
// $angle_degrees = (int) readline("Enter the angle in degrees: ");

// $angle_radians = deg2rad($angle_degrees);

// $cosine_value = round(cos($angle_radians),3 );
// $sinine_value = round(sin($angle_radians), 3);


// echo "sin({$angle_degrees}°) = {$sinine_value}\n";
// echo "cos({$angle_degrees}°) = {$cosine_value}";


function factorial($number){
    return ($number <= 1) ? 1 : $number * factorial($number - 1);
}

function sineTaylor($number){
    $sine = 0;
    foreach (range(0, 10) as $n) {
        $sine += (pow(-1, $n) * pow($number, (2 * $n) + 1)) / factorial((2 * $n) + 1);
    }
    return round($sine, 3);
}


function cosineTaylor ($number){
    $cosine = 0;
    foreach (range(0, 10) as $n) {
        $cosine += (pow(-1, $n) * pow($number, 2 * $n)) / factorial(2 * $n);
    }
    return round($cosine, 3);
}

$angleDegree = (int) readline("Enter the angle in degrees: ");
$angleRadians = deg2rad($angleDegree);

echo 'sin('.$angleDegree .') = '. sineTaylor ($angleRadians) . "\n";
echo 'cos('.$angleDegree .') = '. cosineTaylor ($angleRadians);