<?php
    require_once 'db_conn.php';
    session_start();

    $errors = [];
    $old = $_POST ?? [];

    // $conn = new mysqli('localhost', 'root', '', 'student_db');
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $rollno = strtolower(htmlspecialchars(trim($_POST['rollno'] ?? '')));

        if (empty($rollno)) {
            $errors['rollno'] = "Roll number is required.";
        } else {
            $rollno_escaped = $conn->real_escape_string($rollno);
            $checkSql = "SELECT COUNT(*) AS cnt FROM students_info WHERE roll_no = '$rollno_escaped'";
            $result = $conn->query($checkSql);

            if ($result) {
                $row = $result->fetch_assoc();
                if ($row['cnt'] != 1) {
                    $errors['rollno'] = "Roll number not found in registration records.";
                }
            } else {
                $errors['rollno'] = "Error checking roll number: " . $conn->error;
            }
        }

        $education = $_POST['education'] ?? [];

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location: educationDetails.php");
            exit();
        }

        // Prepare data for insertion/update, escaping values
        $rollno_sql = $conn->real_escape_string($rollno);

        $school_name = $conn->real_escape_string($education['school']['name'] ?? '');
        $school_board = $conn->real_escape_string($education['school']['board'] ?? '');
        $school_year = (int)($education['school']['year'] ?? 0);
        $school_cgpa = (float)($education['school']['cgpa'] ?? 0);

        $other_name = $conn->real_escape_string($education['other']['name'] ?? '');
        $other_board = $conn->real_escape_string($education['other']['board'] ?? '');
        $other_year = (int)($education['other']['year'] ?? 0);
        $other_cgpa = (float)($education['other']['cgpa'] ?? 0);

        $current_group = $conn->real_escape_string($education['current']['group'] ?? '');
        $current_year = (int)($education['current']['year'] ?? 0);
        $current_cgpa = (float)($education['current']['cgpa'] ?? 0);

        // Check if entry exists in education_details for this roll_no
        $checkEduSql = "SELECT COUNT(*) AS cnt FROM education_details WHERE roll_no = '$rollno_sql'";
        $resultEdu = $conn->query($checkEduSql);
        $exists = false;
        if ($resultEdu) {
            $rowEdu = $resultEdu->fetch_assoc();
            $exists = ($rowEdu['cnt'] > 0);
        } else {
            echo "Error checking education details: " . $conn->error;
            exit();
        }

        if ($exists) {
            $updateSql = "
                UPDATE education_details SET
                    school_name = '$school_name',
                    school_board = '$school_board',
                    school_year = $school_year,
                    school_cgpa = $school_cgpa,
                    other_name = '$other_name',
                    other_board = '$other_board',
                    other_year = $other_year,
                    other_cgpa = $other_cgpa,
                    current_group = '$current_group',
                    current_year = $current_year,
                    current_cgpa = $current_cgpa
                WHERE roll_no = '$rollno_sql'
            ";
            if ($conn->query($updateSql)) {
                // success
            } else {
                echo "Error updating education details: " . $conn->error;
                exit();
            }

            header("Location: updateDelete.php");

        } else {
            // Insert new row
            $insertSql = "
                INSERT INTO education_details 
                (roll_no, school_name, school_board, school_year, school_cgpa, other_name, other_board, other_year, other_cgpa, current_group, current_year, current_cgpa) VALUES
                ('$rollno_sql', '$school_name', '$school_board', $school_year, $school_cgpa, '$other_name', '$other_board', $other_year, $other_cgpa, '$current_group', $current_year, $current_cgpa)
            ";
            if ($conn->query($insertSql)) {
                // success
            } else {
                echo "Error inserting education details: " . $conn->error;
                exit();
            }
        }

        
    // CSV FILE 

        $uploadDir = 'uploads/csvDetails/';
        $csvFile = $uploadDir. 'educationDetails.csv';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileopen = fopen($csvFile, 'a');
        if(filesize($csvFile) == 0){
            $header = ['Sl no.', 'Name','Roll No', 'Birthday', 'Age', 'Email', 'Phone','Gender', 'Intrested Gropus', 'School Name', 'School Board', 'School Year', 'School CGPA', 'Other Name', 'Other Board', 'Other Year', 'Other CGPA', 'Current Group', 'Current Year', 'Current CGPA','created_at'];
            fputcsv($fileopen, $header);
        }
        // fclose($fileopen);


        // $fileopen = fopen($csvFile, 'a');
        $statement3 = $conn->prepare("select si.id, si.name, si.roll_no, si.birthday, si.age,
                    si.email, si.phone, si.gender, si.intrested_groups, ed.school_name, ed.school_board, ed.school_year, ed.school_cgpa, ed.other_name, ed.other_board, ed.other_year, ed.other_cgpa, ed.current_group, ed.current_year,ed.current_cgpa,si.created_at

                    from students_info si
                    inner join education_details ed
                    on si.roll_no = ?");
        $statement3->bind_param("s", $rollno);
        $statement3->execute();
        $result = $statement3->get_result();


        $dataToInsertInCsv = $result->fetch_row();
        // var_dump($dataToInsertInCsv);
        echo json_encode($dataToInsertInCsv)."<br>";

        fputcsv($fileopen, $dataToInsertInCsv);
        fclose($fileopen);

        echo "CSV file updated<br>";

        // Optionally update CSV file here if needed (same logic as before)...

        $conn->close();

        exit();
    }
?>
