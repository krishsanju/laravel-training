<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo 'Found<br>';
        $name = htmlspecialchars($_POST['username']);  //htmlspecialchars will remove if we use any html kind of input like <h1> sai </h1> 
                                                            // while we are submitting the form
        $pwd = htmlspecialchars($_POST['password']);
        echo $name.'<br>'. $pwd.'<br>';
    }
    
?>