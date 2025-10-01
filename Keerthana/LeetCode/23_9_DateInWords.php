<?php

    function numberInWords($orginialNumber){
        
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
        $number = $orginialNumber;
        $inWords = '';
        $i = 1;
        
        
        echo ($number == 0) ?  "Zero" : null;
        
        
        while($orginialNumber > 0){
            if($count == 1 ){
                
                // echo "\nif". $i++; echo "\n";
                $lastDigit = $orginialNumber % 10;
                $orginialNumber = floor($orginialNumber / 10);
                if($lastDigit <= 0){
                    $count++;
                    continue;
                }else{
                    $inWords = $words[$lastDigit] . ' ' . $places[$count];
                }
            }
            else{
                // echo "\nelse". $i++; echo "\n";
                $last2Digits = $orginialNumber % 100;
                $orginialNumber = floor($orginialNumber / 100);
                
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
        
        return implode(' ', $result) ;
    }

    function dateToWords($date) {
        $months = array(
            '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May',
            '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October',
            '11' => 'November', '12' => 'December'
        );
        
        // Read date input
        $dateInList = explode('-', $date);
        
        // Validate the date and month
        if ($dateInList[0] > 31 || $dateInList[0] < 1) {
            exit("Invalid day");
        }
        if ($dateInList[1] > 12 || $dateInList[1] < 1) {
            exit("Invalid month");
        }
        
        $day = $dateInList[0];
        $month = $months[$dateInList[1]];
        $year = $dateInList[2];
        
        echo numberInWords($day) . ' ' . $month . ' ' . numberInWords($year) . "\n";
    }
    $date = readline("Enter a date in format DD-MM-YYYY: ");
    dateToWords($date);

?>