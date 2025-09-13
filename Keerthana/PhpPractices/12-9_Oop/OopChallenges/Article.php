<?php
    class Article{
        public $title;
        public $content;
        private $published = false;

        public function __construct($title, $content)
        {
            $this->title = $title;
            $this->content = $content;
        }

        public function publish(){
            $this->published = true;
        }

        public function isPublished(){
            return $this->published;
        }
    }

    $article1  = new Article("Topper of batch", "no one is the topper of the batch actually . all are equal");
    $article2 = new Article("Next CM?", "its unpredictable. so, idk");

    $article1->publish();
    $article2->publish();

    echo '<br>'. var_dump($article1->isPublished());