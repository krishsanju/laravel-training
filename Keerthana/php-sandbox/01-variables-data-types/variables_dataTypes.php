<?php 
// VARIABLES
    $title = 'PHP From Scratch';
    $heading = 'Welcome to the course';
    $body = 'In this course, you will learn the fundamentals of the PHP language';

// DATATYPES
    // string,integer,float,boolean,array,object,null,resource.

    // Object
    $person = new stdClass();
    var_dump($person);

    // Null
    $car = null;
    var_dump($car);
    echo '<br>';

    // Resource
    // $file = fopen('sample.txt', 'r');
    // echo gettype($file); 


// CONCAT
    $fname = "Keerthana";
    $lname = "Sai";
    $fullname = $fname .' '. $lname;


// TYPE CASTING
    $n1 = 5;
    $n2 = 10;
    $n3 = '25';
    $n4 = 'apple';
    $n5 = true;


    //implicit

    echo $n1 + $n2;
    echo '<br/>';
    echo $n1 + $n3;
    echo '<br/>';
    echo $n3 + $n3;  //returns integer
    echo '<br/>';
    // echo $n4 + $n4; //ERROR
    echo $n1 + $n5;  //true changes to 1
    echo '<br/>';


    //explicit
    $res = (string) $n1;
    $res = (int)$n3;
    $res = (bool)$n1;

    var_dump($res);

// DATES

    $output = date('Y' , strtotime('1999-09-01'));
    $output = date('y' , strtotime('1999-09-01'));

    $output = date("M");
    $output = date("Y-M-d");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?= $title ?></title>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold"><?= $title ?></h1>
        </div>
    </header>
    <div class="container mx-auto p-4 mt-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-4"><?= $heading ?></h2>
            <p><?= $body ?></p>


            <!-- CONCAT --> 
             <p>STRING CONCATINATION</p>
            <p> <?= "my name is $fullname <br/>" ?></p>   <!-- use double quotes -->
            <p> <?= "my name is ". $fullname .'<br/>' ?></p>
            <p> <?= " my name is \" sai \" " ?></p>

        </div>
    </div>
</body>

</html>