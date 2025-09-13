<?php 
    class User{
        public string $name;
        public  $email;
        protected $status = 'active';

        public function __construct($name, $email)
        {
            echo '<br>'. "constructer is running....";
            $this->name = $name;
            $this->email = $email;
        }

        public function login(){
            echo '<br>'. $this->name."is loggged in";
        }
    }

    class Admin extends User{
        public $level;

        public function __construct($name, $email, $level)
        {
            $this->level = $level;
            parent::__construct($name, $email);
        }

        public function login() //override
        {
            echo '<br>Admin ' . $this->name . ' logged in <br>';
        }

        public function getStatus()
        {
            echo '<br>'. $this->status;
        }
    }

    $user1 = new User("keerthana", "abc@gmail.com");

    // $user1->name = "keerthana";
    // $user1->email = "abc@gmail.com";

    $user1->login();
    // echo '<br>------->'.$user1->status;  //shows error cox status is protected
    echo '<br>------->'.$user1->name;

    $admin1 = new Admin("keerthana", "abc@gmail.com", 5);
    // $admin1->getStatus();
    $admin1->login();



// STATIC METHODS

    class MathUtility{
        public static $pi = 3.14;

        public static function length(...$nums){
            return count($nums);
        }
    }


    $math = new MathUtility();
    // echo $math->pi; //---> this line will error coz pi is static
    echo '<br>'.MathUtility::$pi;       // static methods are called using cls name but not obj names
    echo '<br>'.MathUtility::length(1,2,3,4,5,6);


// ABSTRACT CLASS

    abstract class Shape
    {
        protected $name;
        abstract public function calculateArea(); //Abstract method

        public function __construct($name)
        {
            $this->name = $name;
        }

        public function getName() // Concrete method
        {
            return $this->name;
        }
    }

    class Circle extends Shape //concrete classes
    {
        private $radius;

        public function __construct($name, $radius)
        {
            parent::__construct($name);
            $this->radius = $radius;
        }

        public function calculateArea()  // Implement the abstract method
        {
            return pi() * pow($this->radius, 2);
        }
    }

    class Rectangle extends Shape  //concrete classes
    {
        private $width;
        private $height;

        public function __construct($name, $width, $height)
        {
            parent::__construct($name);
            $this->width = $width;
            $this->height = $height;
        }

    
        public function calculateArea()
        {
            return $this->width * $this->height;
        }
    }

    $circle = new Circle('Circle', 5);
    $rectangle = new Rectangle('Rectangle', 4, 6);

 
    echo  '<br>' . $circle->getName() . ' area --> ' . $circle->calculateArea();
    echo  '<br>' . $rectangle->getName() . ' area --> ' . $rectangle->calculateArea();


// Define in the 