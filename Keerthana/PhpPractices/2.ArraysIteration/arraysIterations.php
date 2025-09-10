<?php
$output = null;

// ARRAYS

    $names = array("jon", "sai", "sri");
    echo '<pre>';
    var_dump($names);
    echo '<pre/> <br/>';


    print_r($names[0]);

    $numbers[6] = 100;
    $numbers[] = 200;

    var_dump($numbers);

// BUILT FUNCTIONS
    echo("----------------------<br/>");
    $narr = [10, 25,28 ,36,20,67,30];
    $sarr = ['user2', 'user1', 'user3'];

    // sort($narr); rsort($sarr);

    array_push($narr, 115); array_push($sarr, 'user4');

    // $narr = array_slice($narr, 2, 5);

    array_splice($narr, 1, 4, 'new');   // from index 1 to index 4 will be replaced with one value ...arr sixe will decrease
    array_splice($sarr, 0, 1, 'new');

    var_dump($narr);
    var_dump($sarr);


    // explode
    $tags = 'tech,code,programming';
    $tagsArr = explode(',', $tags);
    // var_dump($tagsArr);

    // implode
    $output = implode(', ', $sarr);

// ASSOCIATIVE ARRAY
    $user = [
        'name' => 'John',
        'email' => 'john@gmail.com',
        'password' => 'secret',
        'hobbies' => ['Tennis', 'Video Games']
    ];

    $output  = $user['hobbies'][0];

    $user['address'] = '123 Main Street';  //add
    unset($user['address']);   //remove

    // die(); //---> no html code in output just php

//MULTI DIMENSION
    $fruits = [
    ['Apple', 'Red'],
    ['Orange', 'Orange'],
    ['Banana', 'Yellow']
    ];

    $output = $fruits[1][0];



    // types of arrays Printing
    $names = ['John Doe', 'Matthew Thomas', 'Jose Ramirez', 'Mary Jane'];

    $users = [
    ['name' => 'John', 'email' => 'john@email.com'],
    ['name' => 'Jane', 'email' => 'jane@email.com'],
    ['name' => 'Joe', 'email' => 'joe@email.com'],
    ['name' => 'Mary', 'email' => 'mary@email.com']
    ];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>PHP From Scratch</title>
</head>

<body class="bg-gray-100">
  <header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
      <h1 class="text-3xl font-semibold">PHP From Scratch</h1>
    </div>
  </header>
  <div class="container mx-auto p-4 mt-4">
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
      <!-- Output -->
      <p class="text-xl"><?= $output ?></p>


      <h3 class="text-xl font-semibold mb-4">Using a for loop</h3>
      <ul class="mb-6"></ul>
        <?php foreach ($names as $name) : ?>
          <li><?= $name ?></li>
        <?php endforeach; ?>

      <h3 class="text-xl font-semibold mb-4">Using a foreach loop</h3>
      <ul class="mb-6"></ul>
        <?php foreach ($names as $i): ?>
          <li><?= $i; ?></li>
        <?php endforeach; ?>
      
      <h3 class="text-xl font-semibold mb-4">Using a foreach loop with associative array</h3>
      <ul class="mb-6"></ul>
        <?php foreach ($users as $user): ?>
          <li><?= $user['name'] .' - '. $user['email'] ?></li>
        <?php endforeach; ?>

      <h3 class="text-xl font-semibold mb-4">Getting key names and values from associative array</h3>
      <ul class="mb-6"></ul>
          <?php foreach ($users as $index =>  $user): ?>
            <?= "--------------{$index}" ?>;
            <?php foreach ($user as $key  => $val): ?>
              <li><?= $key . '-->'. $val; ?></li>
            <?php endforeach; ?>
          <?php endforeach; ?>
    </div>
  </div>
</body>

</html>