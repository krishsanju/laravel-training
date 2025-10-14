<?php
$angle_degrees = (int) readline("Enter the angle in degrees: ");

$angle_radians = deg2rad($angle_degrees);

$cosine_value = round(cos($angle_radians),3 );
$sinine_value = round(sin($angle_radians), 3);


echo "sin({$angle_degrees}°) = {$sinine_value}\n";
echo "cos({$angle_degrees}°) = {$cosine_value}";