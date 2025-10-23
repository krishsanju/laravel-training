<?php

// use App\PhpUnitTesting\Functions;

require dirname(__DIR__) . '/app/PhpUnitTesting/Functions.php';

use App\PhpUnitTesting\Person;

spl_autoload_register(function ($class){
    $file = dirname(__DIR__) .'/app/PhpUnitTesting/'. $class .'.php';
    if(file_exists($file)){
        require $file;
    }
});
