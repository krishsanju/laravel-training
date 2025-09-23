<?php
    // $randomIndex = array_rand(['heads, tails']);
    // $randomValue = ['heads', 'tails'][$randomIndex];

    // echo $randomValue;


    $array = ['heads', 'tails'];

    $randomValue = $array[array_rand($array)];

    $userGuess = strtolower(readline("guess coin  heads or tails:"));
    ($userGuess !='heads' && $userGuess != 'tails') ? exit("invalid input") : null;
    // ($userGuess == 'h') ? $userGuess = 'heads' : $userGuess = 'tails';


    echo ($userGuess === $randomValue) ? "you win! \n the coin was $randomValue" : "you lose! \n the coin was $randomValue";

?>