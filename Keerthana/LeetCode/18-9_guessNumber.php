<?php
// 18-9_toss_coin.php
function continueGame(){
    echo "\n";
    $continue = (string)strtolower(readline("do you want to try againg? y/n:")); echo "\n";
    return ($continue == 'y') ? true : false;
}

// $play = true;
$randomValue = rand(1,100);
echo "I thought of a number from 1 to 100\n";
// echo $randomValue;
$maxLimit = 3;


do{
    echo "\nyou have $maxLimit chances\n";
    $userGuess = (int)readline("Try to guess it "); echo "\n";

    switch(true){
        case ($userGuess == $randomValue):
            echo "you won! brooooo \n";break;
            // $play = false;
            $maxLimit = 0;break;
        case($randomValue-10 <= $userGuess && $userGuess < $randomValue):
            echo "your number $userGuess is little low! tryyy again \n";break;
            // $play = continueGame();break; break;
        case($randomValue < $userGuess && $userGuess <= $randomValue+10):
            echo "your number $userGuess is little high! try again \n";break;
            // $play = continueGame();break; break;
        case($userGuess < $randomValue-10):
            echo "you are too loww :( \n";break;
            // $play = continueGame();break; break;
        case($userGuess > $randomValue+10):
            echo "you are too highh :( \n";break;
            // $play = continueGame();break; break;
        default:
        echo "somthing went wrong\n";break;
        // $play = continueGame();break break;
    }
    $maxLimit -= 1;
}while($maxLimit > 0);
echo "\nThe number is $randomValue";
?>