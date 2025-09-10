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


// DECLARE TYPE of return nd parameters
    function getSum(int $a, int $b) : int {
        return $a + $b;
    }
    echo getSum(5, 10), '<br>';

// ARROW FUNCTION
    $add = fn ($x, $y) => $x + $y;
    echo "Arrow fun {$add(2,4)} <br>";

    $numbers = [1, 2, 3, 4, 5];
    
    $sqr = array_map(
        fn($num) => $num * $num,
        $numbers
    );

    print_r($sqr);
    echo '<br>'; 

?>