<?php 
  interface ContentInterface{
    public function display();
    public function edit();
  }

  class Article implements ContentInterface{
    private $title;
    private $content;
    public function __construct($title, $content)
    {
      $this->title = $title;
      $this->content = $content;
    }

    public function display()
    {
      echo "<h1 class='text-3xl font-semibold'> {$this->title} </h1>";
      echo "<p> {$this->content} </p>";
    }

    public function edit()
    {
      echo "Editing the article '{$this->title}'"; 
    }
  }

  $article1  = new Article("Topper of batch", "no one is the topper of the batch actually . all are equal");
  // $article2 = new Article("Next CM?", "its unpredictable. so, idk");
  





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
       <?php $article1->display() ?>
    </div>
  </div>
</body>

</html>