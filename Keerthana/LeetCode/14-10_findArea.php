<?php
function triangleArea($base, $height) {
    return 0.5 * $base * $height;
}

function squareArea($side) {
    return pow($side,2);
}

function rectangleArea($length, $breath) {
    return $length * $breath;
}

function circlesArea($radius) {
    return pow($radius,2) * 3.14;
}

function parallelogramArea($base, $height) {
    return $base * $height;
}


echo "Select the shape to calculate area:\n";
echo "1. Triangle\n";
echo "2. Square\n";
echo "3. Rectangle\n";
echo "4. Circle\n";
echo "5. Parallelogram\n";

$choice = (int) readline("Enter your choice (1-5): ");
switch ($choice) {
    case 1:
        $base = (float) readline("Enter the base of the triangle: ");
        $height = (float) readline("Enter the height of the triangle: ");
        echo "Area of Triangle: " . triangleArea($base, $height) . "\n";
        break;
    case 2:
        $side = (float) readline("Enter the side of the square: ");
        echo "Area of Square: " . squareArea($side) . "\n";
        break;
    case 3:
        $length = (float) readline("Enter the length of the rectangle: ");
        $breath = (float) readline("Enter the breath of the rectangle: ");
        echo "Area of Rectangle: " . rectangleArea($length, $breath) . "\n";
        break;
    case 4:
        $radius = (float) readline("Enter the radius of the circle: ");
        echo "Area of Circle: " . circlesArea($radius) . "\n";
        break;
    case 5:
        $base = (float) readline("Enter the base of the parallelogram: ");
        $height = (float) readline("Enter the height of the parallelogram: ");
        echo "Area of Parallelogram: " . parallelogramArea($base, $height) . "\n";
        break;
    default:
        echo "Invalid choice";
    }
