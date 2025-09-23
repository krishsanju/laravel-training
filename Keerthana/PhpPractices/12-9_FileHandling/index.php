<?php
// READ
    // $file = fopen("data.txt", 'r');

    // // var_dump($file)
    // if($file){
    //     $content = fread($file, filesize("data.txt"));
    //     echo nl2br($content);  //---> new line to <br>
    //     fclose(($file));
    // }
    // else{
    //     echo "unable to open tab";
    // }


    $content = file_get_contents("data.txt");
    echo nl2br($content);

// OVER WRITE OR APPEND

    // $file = fopen("data.txt", 'w');
    $file = fopen("data.txt", 'a');

    // var_dump($file)
    if($file){
        fwrite($file, "\nThis is a new line with meaning full content\n");
        fclose(($file));
        echo "<br> file written successfully";
    }
    else{
        echo "unable to write to file";
    }

// METADATA
    $file_name = "data.txt";

    if(file_exists($file_name)){
        echo "<br>File size is: " . filetype($file_name);
        echo "<br>last modified: " . date("F d Y H:i:s.", filemtime($file_name));
        echo "<br>last accessed: " . date("F d Y H:i:s.", fileatime($file_name));
    }
    else{
        echo "File does not exist";
    }

    if(is_readable($file_name)){
        echo "<br>File is readable";
    }
    if(is_writable($file_name)){
        echo "<br>File is writable";
    }

// //RENAME
//     $old_name = "data.txt";
//     $new_name = "newFileName.txt";

//     if(file_exists($old_name)){
//         rename($old_name, $new_name);
//         unlink($new_name); // to delete existing file
//         echo "<br>File renamed successfully";
//     }
//     else{
//         echo "File does not exist";
//     }

// CREATING AND LISTING DIRECTORIES
    $dir_name = "newDir";

    if(!is_dir($dir_name)){
        mkdir($dir_name);
        echo "<br>Directory created successfully";
    }
    else{
        rmdir($dir_name);
        echo "<br>Directory removed successfully";
    }

    $files = scandir(".");
    echo "<br>Files in current directory: <br>";
    foreach($files as $file){
        echo $file . "<br>";
    }
    




// // file handling modes
// r --> read
// w --> write (over write)
// a --> append
// x --> create
// + --> to add more content
// b --> binary
// t --> text
// r+ --> read and write
// w+ --> write and read (over write)
// a+ --> append and read
// x+ --> create and read
// b+ --> binary and read
// t+ --> text and read
// rb --> read binary
// rt --> read text
// wb --> write binary (over write)
// wt --> write text (over write)
// ab --> append binary
// at --> append text
// xb --> create binary
// xt --> create text
// r+b --> read and write binary
// r+t --> read and write text
// w+b --> write and read binary (over write)
// w+t --> write and read text (over write)
// a+b --> append and read binary
// a+t --> append and read text
// x+b --> create and read binary
// x+t --> create and read text


// | Function               | Description

// | `file_get_contents()`  | Read full file into string         
// | `file_put_contents()`  | Write string to file               
// | `fopen()`              | Open a file                        
// | `fread()`              | Read from a file                   
// | `fwrite()` / `fputs()` | Write to a file                    
// | `fclose()`             | Close file handle                  
// | `feof()`               | Check if end of file reached      
// | `fgets()` / `fgetss()` | Read line (fgetss strips HTML tags)
// | `fgetc()`              | Read single character             
// | `file()`               | Read file into array              
// | `unlink()`             | Delete a file      



// | Function        | Description

// | `file_exists()` | Check if file exists        
// | `is_file()`     | Check if path is a file     
// | `is_dir()`      | Check if path is a directory
// | `is_readable()` | Check if file is readable   
// | `is_writable()` | Check if file is writable  
// | `filesize()`    | Get file size              
// | `filetype()`    | Get file type             
// | `fileatime()`   | Get last access time     
// | `filemtime()`   | Get last modified time   
// | `rename()`      | Rename a file            
// | `mkdir()`       | Create a directory        
// | `rmdir()`       | Remove a directory        
// | `scandir()`     | List files in a directory 
