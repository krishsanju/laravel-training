<?php
echo "Select the operation:\n";
echo "1. Addition(+)\n";
echo "2. Subtraction(-)\n";
echo "3. Multiplication(*)\n";
echo "4. Division(/)\n";

$operation = (int) readline("Enter your choice (1-4): ");
$number1 = (int) readline("Enter number 1: ");
$number2 = (int) readline("Enter number 2: ");

$result = match($operation){
    1 => $number1 + $number2,
    2 => $number1 - $number2,
    3 => $number1 * $number2,
    4 => $number1 / $number2,
};

echo "The result is: " . $result;