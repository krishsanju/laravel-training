<?php
    class StringUtility{
        // public $string;

        // public function __construct($string)
        // {
        //     $this->string = $string;   
        // }

        public static function shout($string){
            return strtoupper($string).'!';
        }

        public static function whisper($string){
            return strtolower($string).'.';
        }

        public static function repeat($string, $times = 2){
            return str_repeat($string, $times);
        }
    }

    $string1 = new StringUtility();
    echo '<br>'. $string1->shout("hello , just a sample text");
    echo '<br>'. $string1->whisper("hello , just a sample text");
    echo '<br>'. $string1->repeat("hello , just a sample text ", 5);