<?php 
    function addAll(...$numbers)
    {
        $total = 0;
        foreach ($numbers as $number) {
        $total += $number;
        }
        return $total;
    }

    echo '<br>';
    echo addAll(1, 2, 3, 4, 5);
    echo '<br>';

    // Define Constants
    echo 'CONSTANTS<br>';
    define('APP_NAME', 'My App');  //Global
    echo APP_NAME, '<br>';

    const APP_VERSION = '1.0.0';   //Local (can be class or global)
    echo APP_VERSION, '<br>';


// DECLARE TYPE of returna nd parameters
    function getSum(int $a, int $b) : int {
        return $a + $b;
    }
    echo getSum(5, 10), '<br>';

?>