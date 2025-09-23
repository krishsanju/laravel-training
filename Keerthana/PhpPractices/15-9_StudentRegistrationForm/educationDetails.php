<?php
require_once 'db_conn.php';
session_start();

// Retrieve errors and old input 
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// Clear them so they don’t persist on refresh
unset($_SESSION['errors'], $_SESSION['old']);

if (isset($_GET['roll_no'])) {
    $roll_no = $conn->real_escape_string($_GET['roll_no']);

    // Fetch education details
    $sql = "SELECT * FROM education_details WHERE roll_no = '$roll_no' LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $eduData = $result->fetch_assoc();

        // Only populate $old if there is no old input from session (to avoid overwriting form inputs on validation errors)
        if (empty($old)) {
            $old['rollno'] = $roll_no;
            $old['education']['school']['name'] = $eduData['school_name'] ?? '';
            $old['education']['school']['board'] = $eduData['school_board'] ?? '';
            $old['education']['school']['year'] = $eduData['school_year'] ?? '';
            $old['education']['school']['cgpa'] = $eduData['school_cgpa'] ?? '';

            $old['education']['other']['name'] = $eduData['other_name'] ?? '';
            $old['education']['other']['board'] = $eduData['other_board'] ?? '';
            $old['education']['other']['year'] = $eduData['other_year'] ?? '';
            $old['education']['other']['cgpa'] = $eduData['other_cgpa'] ?? '';

            $old['education']['current']['group'] = $eduData['current_group'] ?? '';
            $old['education']['current']['year'] = $eduData['current_year'] ?? '';
            $old['education']['current']['cgpa'] = $eduData['current_cgpa'] ?? '';
        }
    }
}

$conn->close();

// Helper function to safely get old value or empty string
function old($key, $default = '') {
    global $old;
    $keys = explode('.', $key);
    $value = $old;
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default;
        }
    }
    return htmlspecialchars($value);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Education Details Form</title>
</head>
<body>
    <h2>Student Educational Details Form</h2>
    <form action="educationDetailsProcess.php" method="post">

        <label for="roll_no">Roll Number:</label><br>
        <input 
            type="text" 
            id="roll_no" 
            name="rollno" 
            required 
            value="<?= old('rollno') ?>"
            <?php if (isset($_GET['roll_no'])) echo 'readonly'; ?>
        ><br>
        <span style="color:red"><?= $errors['rollno'] ?? '' ?></span><br><br>

        <h2>Educational Background</h2>

        <fieldset>
            <legend><strong>Schooling Details</strong></legend>

            <label for="prev_school">School Name:</label><br>
            <input type="text" id="prev_school" name="education[school][name]" required value="<?= old('education.school.name') ?>"><br><br>

            <label for="prev_board">Board/University:</label><br>
            <input type="text" id="prev_board" name="education[school][board]" required value="<?= old('education.school.board') ?>"><br><br>

            <label for="prev_year">Year of Passing:</label><br>
            <input type="number" placeholder="YYYY" min='1800' max='2100' id="prev_year" name="education[school][year]" required value="<?= old('education.school.year') ?>"><br><br>

            <label for="prev_CGPA">CGPA:</label><br>
            <input type="number" step="0.001" min='0' max='10' id="prev_CGPA" name="education[school][cgpa]" required value="<?= old('education.school.cgpa') ?>"><br><br>
        </fieldset>

        <fieldset>
            <legend><strong>Additional Academic Details</strong></legend>

            <label for="another_school">Institution Name:</label><br>
            <input type="text" id="another_school" name="education[other][name]" value="<?= old('education.other.name') ?>"><br><br>

            <label for="another_board">Board/University:</label><br>
            <input type="text" id="another_board" name="education[other][board]" value="<?= old('education.other.board') ?>"><br><br>

            <label for="another_year">Year of Passing:</label><br>
            <input type="number" placeholder="YYYY" min='1800' max='2100' id="another_year" name="education[other][year]" value="<?= old('education.other.year') ?>"><br><br>

            <label for="another_CGPA">CGPA:</label><br>
            <input type="number" step='0.001' min='0' max='10' id="another_CGPA" name="education[other][cgpa]" value="<?= old('education.other.cgpa') ?>"><br><br>
        </fieldset>

        <fieldset>
            <legend><strong>Current Education</strong></legend>

            <label for="course">Department / Group:</label><br>
            <?php $currentGroup = old('education.current.group'); ?>
            <select id="course" name="education[current][group]" required>
                <option value="">-- Select Group --</option>
                <option value="CSE" <?= $currentGroup === 'CSE' ? 'selected' : '' ?>>Computer Science (CSE)</option>
                <option value="MECH" <?= $currentGroup === 'MECH' ? 'selected' : '' ?>>Mechanical (MECH)</option>
                <option value="ECE" <?= $currentGroup === 'ECE' ? 'selected' : '' ?>>Electronics (ECE)</option>
                <option value="CIVIL" <?= $currentGroup === 'CIVIL' ? 'selected' : '' ?>>Civil</option>
                <option value="EEE" <?= $currentGroup === 'EEE' ? 'selected' : '' ?>>Electrical (EEE)</option>
            </select><br><br>

            <label for="year">Year of Study:</label><br>
            <?php $currentYear = old('education.current.year'); ?>
            <select id="year" name="education[current][year]" required>
                <option value="">-- Select Year --</option>
                <option value="1" <?= $currentYear === '1' ? 'selected' : '' ?>>1st Year</option>
                <option value="2" <?= $currentYear === '2' ? 'selected' : '' ?>>2nd Year</option>
                <option value="3" <?= $currentYear === '3' ? 'selected' : '' ?>>3rd Year</option>
                <option value="4" <?= $currentYear === '4' ? 'selected' : '' ?>>4th Year</option>
            </select><br><br>

            <label for="CGPA">Current CGPA :</label><br>
            <input type="number" step='0.001' min='0' max='10' id="CGPA" name="education[current][cgpa]" required value="<?= old('education.current.cgpa') ?>"><br><br>
        </fieldset>

        <br>
        <input type="submit" value="Submit">

    </form>
</body>
</html>
