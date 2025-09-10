<?php
/*
  Challenge 1: Fahrenheit to Celsius
  Create a function called `fahrenheitToCelsius` that takes a Fahrenheit temperature as an argument. Return the temperature converted to Celsius.

  The formula to convert Fahrenheit to Celsius is: Celsius = (Fahrenheit - 32) * 5/9
*/

$base_temp = 32;
$f = 68;
$c = function ($f) use ($base_temp) { 
  return (($f - $base_temp) * (5/9));
};
echo $f . '&degF = ' . $c($f) . '&degC';


echo '<br>';

/*
  Challenge 2: Print names in uppercase
  Create a function called `printNamesToUpperCase` that takes an array of names as an argument. The function should loop through the array and print each name to the screen in uppercase letters.
*/
$str = 'ijdkcjd';
function printNamesToUpperCase($str){
  return strtoupper($str);
}
echo printNamesToUpperCase($str);


echo '<br>';

/*
  Challenge 3: Find the longest word
  1. Create a function called `findLongestWord` that takes a sentence as an argument.
  2. The function should return the longest word in the sentence.
  3. The output should look like this:
*/
function findLongestWord($str){
  $arr = explode(' ',$str);
  // $max = 0;
  $word ='';
  foreach($arr as $i){
    $i = trim($i);
    if(strlen($word) < strlen($i)){
      $word = $i;
    }
  }
  return $word;
}

$sentence = 'The quick brown fox jumped over the lazy dog';
echo findLongestWord($sentence);