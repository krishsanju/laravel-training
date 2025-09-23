<?php 
    require_once 'db_conn.php';
    session_start();
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];

    function validatePassword($password, $fieldName, &$errors) {
        switch (true) {
            case empty($password):
                $errors[$fieldName] = "Please set a password."; break;
            case strlen($password) < 8:
                $errors[$fieldName] = "your password is less than 8 characters"; break;
            case strlen($password) > 16:
                $errors[$fieldName] = "your password is more than 16 characters"; break;
            case !preg_match('/[A-Z]/', $password):
                $errors[$fieldName] = "give atleat one uppercase"; break;
            case !preg_match('/[a-z]/', $password):
                $errors[$fieldName] = "give atleat one lowercase"; break;
            case !preg_match('/\d/', $password):
                $errors[$fieldName] = "give atleat one number"; break;
            case !preg_match('/[\W_]/', $password):
                $errors[$fieldName] = "give atleat one special character (!, @, #, $, etc.)"; break;
            default:
                 true;
        }
    }

    function emptyInput($input, $fieldName, &$errors) {
        if (empty($input)) {
            $errors[$fieldName] = "Please enter your {$fieldName}.";
        }
    }


    
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        $Studentname = htmlspecialchars($_POST['name']);
        emptyInput($Studentname, 'name', $errors);


        $rollno = strtolower(htmlspecialchars($_POST['rollno']));
        emptyInput($rollno, 'rollno', $errors);


        $password = $_POST['password'] ?? '';
        validatePassword($password, 'password', $errors);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $email = htmlspecialchars($_POST['email']);
        emptyInput($email, 'email', $errors);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Please enter a valid email address.";


        $phone = $_POST['phone'];
        emptyInput($phone, 'phone', $errors);
        // include country code if possible
        if(!preg_match('/^\d{10}$/', $phone)) $errors['phone'] = "Please enter a valid 10-digit phone number.";
        

        $birthday = $_POST['birthday']; $age = $_POST['age'];
        $gender = htmlspecialchars($_POST['gender']);
        $groups = isset($_POST['group']) ? $_POST['group'] : [];
        $street = htmlspecialchars($_POST['street']); $city = htmlspecialchars($_POST['city']);
        $state = htmlspecialchars($_POST['state']); $zip = htmlspecialchars($_POST['zip']);  $country = htmlspecialchars($_POST['country']);
        $color = $_POST['color'];

// PHOTO
// $_FILES will create a nested array with 'name`, 'type', 'tmp_name', 'error', 'size' as keys
        try{
            global $errors;
            $photoFile = $_FILES['photo'] ?? null;
            if (!$photoFile || $photoFile['error'] !== UPLOAD_ERR_OK) throw new Exception("Error uploading photo files. Please try again.") ;

            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($photoFile['type'], $allowedTypes)) throw new Exception("Only .jpg, .jpeg, .png files are allowed.");
            if ($photoFile['size'] > $maxSize)  throw new Exception("Please upload your photo less than 2MB.");

            $uploadDir = 'uploads/photos/';
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) throw new Exception("Failed to create upload directory.");

            
            $targetPath = $uploadDir .$rollno.'_'. basename($photoFile['name']);
            if (!move_uploaded_file($photoFile['tmp_name'], $targetPath))  throw new Exception("Error moving the uploaded photo.");
 
        }catch (Exception $e){
            $errors['photo'] = $e->getMessage();
        }


// MEMOS

        try {
            $memosFile = $_FILES['marks'] ?? null;
            if (!$memosFile || empty($memosFile['name'])) {
                throw new Exception("No memo files uploaded.");
            }

            $allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $maxSize = 5 * 1024 * 1024; // 5MB
            $uploadDir = "uploads/memos/{$rollno}/";
            $memosPaths = [];

            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true))throw new Exception("Failed to create memo upload directory."); 

            foreach ($memosFile['name'] as $index => $name) {
                $error = $memosFile['error'][$index];
                $type = $memosFile['type'][$index];
                $size = $memosFile['size'][$index];
                $tmpName = $memosFile['tmp_name'][$index];

                if ($error !== UPLOAD_ERR_OK) throw new Exception("Error uploading memo file: " . $name); 
                if (!in_array($type, $allowedTypes)) throw new Exception("Invalid file type for memo: {$name}. Allowed: PDF, DOC, DOCX");
                if ($size > $maxSize) throw new Exception("Memo file '{$name}' exceeds 5MB size limit.");

                $fileName = basename($name);
                $targetFilePath = $uploadDir . $fileName;

                if (!move_uploaded_file($tmpName, $targetFilePath)) throw new Exception("Failed to move uploaded memo file: {$name}");

                $memosPaths[] = $targetFilePath;
            }

            // Create comma-separated path string for DB insert
            $memosStr = implode(',', $memosPaths);

        } catch (Exception $e) {
            $errors['memos'] = $e->getMessage();
            $memosStr = null; // Ensure this isn't used further if error exists
        }


        
// | File Type       | MIME        |
// | --------------- | ------------------ |
// | `.jpg`, `.jpeg` | `image/jpeg`       |
// | `.png`          | `image/png`        |
// | `.pdf`          | `application/pdf`  |
// | `.mp4`          | `video/mp4`        |
// | `.html`         | `text/html`        |
// | `.json`         | `application/json` |
// | `.zip`          | `application/zip`  |
// | `.doc`          | `application/msword`
// | `.docx`         | `application/vnd.openxmlformats-officedocument.wordprocessingml.document`|



        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            header("Location: registrationForm.php");
            exit();
        }
        // no errors --- clear session data
        unset($_SESSION['errors'], $_SESSION['old']); 
    }
        echo "<span  style='color: $color;'> ";

        echo "<h2>Received Student Information:</h2>";
        echo "Name: $Studentname<br>";
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

    // CREATE TABLE students_info (
    //     id INT(11) AUTO_INCREMENT PRIMARY KEY,
    //     name VARCHAR(100) NOT NULL,
    //     roll_no VARCHAR(50) NOT NULL UNIQUE,
    //     password VARCHAR(255) NOT NULL,
    //     birthday DATE,
    //     age INT,
    //     email VARCHAR(100) NOT NULL UNIQUE,
    //     phone VARCHAR (15) NOT NULL,
    //     gender VARCHAR(7),
    //     intrested_groups TEXT,
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


    $groupsStr = !empty($groups) ? implode(',', $groups) : null;
    $memosPaths = [];

    if (isset($uploadDir) && is_dir($uploadDir)) {
        $memosPaths = array_map(function($file) use ($uploadDir) {
            return $uploadDir . basename($file);
        }, $_FILES['marks']['name']);
    }

    $memosStr = $memosPaths ? implode(',', $memosPaths) : null;




    $sql = "INSERT INTO students_info (
        name, roll_no, password, birthday, age, email, phone, gender, intrested_groups, 
        street, city, state, zip, country, photo, memos, color
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $statement = $conn->prepare($sql);

    if (!$statement) die("Prepare failed: " . $conn->error);
        $statement->bind_param(
        "ssssisissssssssss",   // 17 parameters
        $Studentname, $rollno, $hashedPassword, $birthday, $age, $email, $phone, $gender, 
        $groupsStr,
        $street, $city, $state, $zip, $country, 
        $targetPath,  // for photo
        $memosStr,    // for memos
        $color
    );


    if ($statement->execute()) {
        echo "<h2>Student data inserted successfully!</h2>";
    } else {
        echo "Error: " . $statement->error;
    }

    $statement->close();
    $conn->close();

?>