<?php
$orginial_number = (int) readline("Enter a number below 999999999: ");
    
    $words = array(
        0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
        6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
        11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
        15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
        50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty',
        90 => 'ninety'
    );

    $places = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

    $result = [];
    $count = 0;
    $number = $orginial_number;
    $inWords = '';
    $i = 1;


    echo ($number == 0) ?  "Zero" : null;


    while($orginial_number > 0){
        if($count == 1 ){
            
            // echo "\nif". $i++; echo "\n";
            $lastDigit = $orginial_number % 10;
            $orginial_number = floor($orginial_number / 10);
            if($lastDigit <= 0){
                $count++;
                continue;
            }else{
                $inWords = $words[$lastDigit] . ' ' . $places[$count];
            }
        }
        else{
            // echo "\nelse". $i++; echo "\n";
            $last2Digits = $orginial_number % 100;
            $orginial_number = floor($orginial_number / 100);
    
            // echo "\n ----> $last2Digits\n";
    
            if ($last2Digits < 21) { $inWords = $words[$last2Digits]; }
            else{$inWords = $words[floor($last2Digits / 10) * 10] . ' '. $words[$last2Digits % 10] ;}

            if ($count > 1 && $last2Digits > 0){
                $inWords .= ' '. $places[$count];
            }
    
        }
        array_unshift($result, $inWords);
        $count++;


    }

    echo implode(' ', $result) ;
    // echo $inWords;
