<?php
    if ($_SERVER["REQUEST_METHOD"] == 'GET'){
        $str = $_GET['query'];
        if(!empty($str)){
            echo 'you have searched about  => '.$str.'<br>';
        }
        else{
            echo "Please search something";
        }
    }
?>