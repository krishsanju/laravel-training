<?php 
    session_start();
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];

    function validatePassword($password) {
        switch (true) {
            case empty($password):
                return "Please set a password.";
            case strlen($password) < 8:
                return "your pwd is less than 8 characters";
            case strlen($password) > 16:
                return "your pwd is more than 16 characters";
            case !preg_match('/[A-Z]/', $password):
                return "give atleat one uppercase";
            case !preg_match('/[a-z]/', $password):
                return "give atleat one lowercase";
            case !preg_match('/\d/', $password):
                return "give atleat one number";
            case !preg_match('/[\W_]/', $password):
                return "give atleat one special character (!, @, #, $, etc.)";
            default:
                return true;
        }
    }


    
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $Studentname = htmlspecialchars($_POST['name']);
        if (empty($Studentname)) $errors['name'] = "Please enter your name.";


        $rollno = htmlspecialchars($_POST['rollno']);
        if (empty($rollno)) $errors['rollno'] = "Please enter your Roll No.";


        $password = $_POST['password'] ?? '';
        $pwdValidationMsg = validatePassword($password);
        if ($pwdValidationMsg !== true) {
            $errors['password'] = $pwdValidationMsg;
        }


        $birthday = $_POST['birthday'];
        $age = $_POST['age'];


        $email = htmlspecialchars($_POST['email']);
        if (empty($email)){
            $errors['email'] = "Please enter your email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address.";  
        }


        $phone = $_POST['phone'];
        switch (true){
            case empty($phone):
                $errors['phone'] = "Please enter your phone number.";
                break;
            // case !preg_match('/^+\d{2}/', $phone):
            //     $errors['phone'] = "Please enter country code.";
            //     break;
            case !preg_match('/^\d{10}$/', $phone):
                $errors['phone'] = "Please enter a valid 10-digit phone number.";
                break;
        }


        $gender = htmlspecialchars($_POST['gender']);
        $groups = isset($_POST['group']) ? $_POST['group'] : [];
        $street = htmlspecialchars($_POST['street']);
        $city = htmlspecialchars($_POST['city']);
        $state = htmlspecialchars($_POST['state']);
        $zip = htmlspecialchars($_POST['zip']);
        $country = htmlspecialchars($_POST['country']);
        $color = $_POST['color'];

// PHOTO
// $_FILES will create a nested array with 'name`, 'type', 'tmp_name', 'error', 'size' as keys
        $photoFile = $_FILES['photo'] ?? null;

        if ($photoFile['error'] === UPLOAD_ERR_OK) {
            $typesAllowed = ['image/jpg', 'image/jpeg', 'image/png']; //MIME types
            if(!in_array($photoFile['type'], $typesAllowed)){
                $errors['photo'] = "Only .jpg, .jpeg, .png files are allowed.";
            }
            // elseif(!is_array($photoFile)){
            //     $errors['photo'] = "Please upload only one photo.";
            // }
            elseif($photoFile['size'] > 2097152) {
            $errors['photo'] = "Please upload your photo less than 2mb.";
            }
            else{
                $uploadDir = 'uploads/photos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($photoFile['name']);
                $targetPhotoFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($photoFile['tmp_name'], $targetPhotoFilePath)) {
                    // File uploaded successfully
                } else {
                    $errors['photo'] = "Error moving the uploaded photo.";
                }

            }
        }
        else {
            $errors['photo'] = "Error uploading file. Please try again.";
        }

// MEMOS
        $memosFile = $_FILES['marks'] ?? null;
        foreach($memosFile['name'] as $index => $name){
            // $tempName = $memofile['tmp_name'];
            $memoError = $memosFile['error'][$index];
            $memoType = $memosFile['type'][$index];
            $memoSize = $memosFile['size'][$index];

            if($memoError === UPLOAD_ERR_OK) {
                $typesAllowed = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document`'];
                if(!in_array($memoType, $typesAllowed)){
                    $errors['memos'] = "Only .pdf, .doc, .docx files are allowed.";
                }
                elseif($memoSize > 5 * 1024 * 1024) {  //5mb
                    $errors['memos'] = "Please upload your memos less than 5mb.";
                }
                else{
                    $uploadDir = "uploads/memos/{$rollno}/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = basename($name);
                    $targetFilePath = $uploadDir . $fileName;
                    if (move_uploaded_file(($memosFile['tmp_name'][$index]), $targetFilePath)) {
                        // File uploaded successfully
                    } else {
                        $errors['memos'] = "Error moving the uploaded memos.";
                    }
                }
            }
            
            else {
                $errors['memos'] = "Error uploading file. Please try again.";
            }
        }
        
// | File Type       | intrestedGropus          |
// | --------------- | ------------------ |
// | `.jpg`, `.jpeg` | `image/jpeg`       |
// | `.png`          | `image/png`        |
// | `.pdf`          | `application/pdf`  |
// | `.mp4`          | `video/mp4`        |
// | `.html`         | `text/html`        |
// | `.json`         | `application/json` |
// | `.zip`          | `application/zip`  |
// | `.doc`          | `application/msword`
// | `.docx`         | `application/vnd.openxmlformats-officedocument.wordprocessingml.document` |







// UPLOAD THE FILES DATA

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            header("Location: index.php");
            exit();
        }
        // no errors --- clear session data
        unset($_SESSION['errors'], $_SESSION['old']); 
    }
        echo "<span  style='color: $color;'> ";

        echo "<h2>Received Student Information:</h2>";
        echo "Name: $name<br>";
        echo "Roll No: $rollno<br>";
        echo "Birthday: $birthday<br>";
        echo "Age: $age<br>";
        echo "Email: $email<br>";
        echo "Phone: $phone<br>";
        // echo "Gender: $gender<br>";
        echo "Address: $street, $city, $state - $zip, $country<br>";
        echo "Preferred Color: <span style='color:$color;'>$color</span><br>";


        echo "</span>";




// SQL CONNNECTION

    // CREATE TABLE studentsInfo (
    //     id INT(11) AUTO_INCREMENT PRIMARY KEY,
    //     name VARCHAR(100) NOT NULL,
    //     rollno VARCHAR(50) NOT NULL UNIQUE,
    //     password VARCHAR(255) NOT NULL,
    //     birthday DATE,
    //     age INT,
    //     email VARCHAR(100) NOT NULL UNIQUE,
    //     phone VARCHAR (15) NOT NULL,
    //     gender VARCHAR(7),
    //     gropus TEXT,
    //     street VARCHAR(255),
    //     city VARCHAR(100),
    //     state VARCHAR(100),
    //     zip VARCHAR(20),
    //     country VARCHAR(100),
    //     color VARCHAR(20),
    //     photo VARCHAR(255),
    //     memos TEXT,
    //     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    // );

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $groupsStr = !empty($groups) ? implode(',', $groups) : null;

    

    $memosPaths = [];
    if (isset($uploadDir) && is_dir($uploadDir)) {
        $memosPaths = array_map(function($file) use ($uploadDir) {
            return $uploadDir . basename($file);
        }, $_FILES['marks']['name']);
    }
    $memosStr = !empty($memosPaths) ? implode(',', $memosPaths) : null;




    $stmt = $conn->prepare("INSERT INTO studentsInfo (
        name, rollno, password, birthday, age, email, phone, gender, intrestedGropus, 
        street, city, state, zip, country, photo, memos, color
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ssssisissssssssss",
        $Studentname, $rollno, $hashedPassword, $birthday, $age, $email, $phone, $gender, 
        $groupsStr,
        $street, $city, $state, $zip, $country, 
        $targetPhotoFilePath,
        $memosStr,
        $color
    );

    if ($stmt->execute()) {
        echo "<h2>Student data inserted successfully!</h2>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();



?>