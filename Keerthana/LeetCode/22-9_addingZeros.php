<?php
    $input = (string)readline("enter a number");
    $preSuffix = (int)readline("Enter \n1) Prefix \n2) Suffix");
    $numberOfZeroes = (int)readline("Enter number of zeros");

    echo ($preSuffix == 1) ? str_repeat('0',$numberOfZeroes). $input : $input.str_repeat('0',$numberOfZeroes);

