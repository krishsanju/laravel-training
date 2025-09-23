<?php 
    require_once 'db_conn.php';
    // $conn = new mysqli("localhost", "root", "", "student_db");
    // ($conn->connect_error)  ? die("Connection failed: " . $conn->connect_error) : null ;

// DELETE
    if (isset($_GET['roll_no'])) {
        $roll_no = mysqli_real_escape_string($conn, $_GET['roll_no']);
        $conn->begin_transaction();

        try {

            function delete($table_name, $roll_no){

                global $conn;
                $sql1 = "DELETE FROM $table_name WHERE roll_no = '$roll_no'";
                (!$conn->query($sql1)) ? throw new Exception("Error deleting " . $conn->error) : null;

                $csvFile = 'uploads/csvDetails/educationDetails.csv';
                $rows = array_map('str_getcsv', file($csvFile));
                // $header = array_shift($rows);
                $rows = array_filter($rows, fn($row) => $row[2] !== $roll_no);
                // array_unshift($rows, $header);
                $fp = fopen($csvFile, 'w');
                foreach ($rows as $row) fputcsv($fp, $row);
                fclose($fp);


            }

            delete('education_details', $roll_no);
            delete('students_info', $roll_no);

            
            $conn->commit();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            echo "<p style='color:red;'>Deletion failed: " . $e->getMessage() . "</p>";
        }
    }


    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p style='color:green;'>Record deleted successfully.</p>";
    }

    $result = $conn->query("SELECT name, roll_no FROM students_info");
    if (!$result) {
        die("Error fetching student records: " . $conn->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Records</title>
</head>
<body>
    <h2>Student List</h2>
    <table border="1" >
        <tr>
            <th>Name</th>
            <th>Roll No</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['roll_no']) ?></td>
                <td>
                    <a href="/educationDetails.php?roll_no=<?= urlencode($row['roll_no']) ?>">Update</a> |
                    <a href="?roll_no=<?= urlencode($row['roll_no']) ?>" onclick="return confirm('Are you sure you want to delete this student and their education details?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
