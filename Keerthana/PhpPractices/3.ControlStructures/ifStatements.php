<?php
    $age = 30;
// If statement
    if ($age >= 21) {
    echo 'You are old enough<br>';
    }

// If-Else
    if ($age >= 21) {
    echo 'old enough to drink<br>';
    } else {
    echo 'NOT old enough to drink<br>';
    }


// Nested if statement
    if ($age >= 21) {
    echo 'old enough to drinka and vote<br>';
    } else {
    if ($age >= 18) {
        echo 'old enough to vote<br>';
    } else {
        echo 'NOT old enough to drink or vote<br>';
    }
    }

// If-Else-If
    if ($age >= 21) {
    echo 'old enough to drink and vote<br>';
    } else if ($age >= 18) {
    echo 'old enough to vote<br>';
    } else {
    echo 'NOT old enough to drink or vote<br>';
    }

//Switch
    $day = 'Friday';

    switch ($day) {
    case 'Monday':
        echo 'Monday blues!';
        break;
    case 'Tuesday':
        echo 'At least it\'s not Monday!';
        break;
    case 'Wednesday':
        echo 'Hump day!';
        break;
    case 'Thursday':
        echo 'One more day until Friday!';
        break;
    case 'Friday':
        echo 'TGIF!';
          break;
    case 'Saturday':
        echo 'Have a nice weekend!';
        break;
    case 'Sunday':
        echo 'Have a nice weekend!';
        break;
    default:
        echo 'Not a valid day.';
    }

    // $fcolor = 'black';
// Ternary operator
    $color = isset($fcolor) ? $fcolor : 'blue';

// Null coalescing operator
    $color = $fcolor ?? 'blue';


    $isLoggedIn = true;
    $name = null;
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
      <?php if ($isLoggedIn && $name) : ?>
        <p>Welcome <?= $name ?></p>
      <?php elseif ($isLoggedIn) : ?>
        <p>Welcome to the app!</p>
      <?php else : ?>
        <p>Please log in</p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>


