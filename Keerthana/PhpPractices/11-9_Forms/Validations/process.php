<?php

    function validatePassword($password) {
        if (strlen($password) < 8) {
            return "your pwd is less than 8 characters";
        }
        if (strlen($password) > 16) {
            return "your pwd is more than 16 characters";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return "give atleat one uppercase";
        }
        if (!preg_match('/[a-z]/', $password)) {
            return "give atleat one lowercase";
        }
        if (!preg_match('/\d/', $password)) {
            return "give atleat one number";
        }
        if (!preg_match('/[\W_]/', $password)) {
            return "give atleat one special character (!, @, #, $, etc.)";
        }
        return "<br>Password is valid!<br>";
    }

    function validatemail($mail){
        if(empty($mail)){
            return 'Where is mail id ??';
        }
        else{
             if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                return "Wrong mail formate";
             }
        }
        return "<br>Mail is valid!<br>";
    }

    function validatePhoneNo($num){
        if(!preg_match("/^\+91/", $num)){
            return "no country code";
        }
        if(!preg_match("/^\+91\d{10}$/", $num)){
            return "invalid no (num != 10)";
        }
        return "<br>Phone Number is valid!<br>";
    }

    function validatedate($date){
        $d = DateTime::createFromFormat('d-m-Y', $date);
        if(!$d){
            return "Invalid date format ('d-m-Y')";
        }
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        if (checkdate($month, $day, $year)){
            return "Invalid date";
        }

        return "valid date";
    
    }

    if($_SERVER["REQUEST_METHOD"] == 'POST'){

        if(empty($_POST['username'])){
            $nameMsg = 'Where is name ??';
        }
        else{
             $nameMsg = "<br>Name is valid!<br>"; 
        }

        $mailMsg = validatemail($_POST['email']); 
        $pwdMsg = validatePassword($_POST['pwd']);
        $phoneNumber = validatePhoneNo($_POST['mobile_no']);
        $date = validatedate($_POST['date']);

        echo $nameMsg.'<br>'. $mailMsg .'<br>'. $pwdMsg .'<br>'. $phoneNumber .'<br>'. $date;

    }




    // PATTERNS _____ PREG_MATCH 

// Basic Metacharacters:
// .: Any character except a newline.
// ^: Start of the string.
// $: End of the string.
// []: Character class.
// () : Grouping.
// |: OR (alternation).

// Character Classes:
// \d: Digit (0-9).
// \w: Word character (a-zA-Z0-9_).
// \s: Whitespace character.
// \D: Non-digit.
// \W: Non-word character.
// \S: Non-whitespace character.

// Quantifiers:
// +: One or more.
// *: Zero or more.
// ?: Zero or one.
// {n}: Exactly n times.
// {n,}: At least n times.
// {n,m}: Between n and m times.

// Anchors:
// ^: Beginning of the string.
// $: End of the string.