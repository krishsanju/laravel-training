<?php
session_start();

// Retrieve errors and old input
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// Clear them so they don’t persist on refresh
unset($_SESSION['errors'], $_SESSION['old']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
</head>
<body>




    <div align = "left">
            <h2>Student Registration Form</h2>

            <form action="backendProcess.php" method="post" enctype="multipart/form-data">
            Student Name: <input type="text" name="name" placeholder="Enter your name" value="<?= htmlspecialchars($old['name'] ?? '') ?>"><br>
            <span style="color:red"><?= $errors['name'] ?? '' ?></span><br><br>
            
            Roll No: <input type="text" name="rollno" placeholder="Enter your Rollno." value="<?= htmlspecialchars($old['rollno'] ?? '') ?>"><br>
            <span style="color:red"><?= $errors['rollno'] ?? '' ?></span><br><br>

            Upload your photo<small> (.jpg, .jpeg, .png) </small> : <input type="file" name="photo"  > <br>
            <span style="color:red"><?= $errors['photo'] ?? '' ?></span><br><br>
                        

            Set Password : <input type="password" name="password" placeholder="Set a strong password" value = "<?= htmlspecialchars($old['password'] ?? '')?>"><br>
            <span style="color:red"><?= $errors['password'] ?? '' ?></span><br><br>
            
            Birthday: <input type="date" name="birthday" value="<?= htmlspecialchars($old['birthday'] ?? '') ?>"><br>
            <span style="color:red"><?= $errors['birthday'] ?? '' ?></span><br><br>

            Student Age: <input type="number" name="age" placeholder="Enter your age" value="<?= htmlspecialchars($old['age'] ?? '') ?>"><br>
            <span style="color:red"><?= $errors['age'] ?? '' ?></span><br><br>

            Email : <input type="email"  name="email" placeholder="Enter your email" value="<?= htmlspecialchars($old['email'] ?? '') ?>"><br>
            <span style="color:red"><?= $errors['email'] ?? '' ?></span><br><br>

            Phone Number: <input type="tel" name="phone" placeholder="Enter your phone number" value="<?= htmlspecialchars($old['phone'] ?? '') ?>"><br>
            <span style="color:red"><?= $errors['phone'] ?? '' ?></span><br><br>


            <label>Gender:</label>
                <label><input type="radio" name="gender" value="male"
                        <?= (isset($old['gender']) && $old['gender'] == 'male') ? "checked"  : ' ' ?>> Male</label>
                <label><input type="radio" name="gender" value="female"
                        <?= (isset($old['gender']) && $old['gender'] == 'female') ? "checked"  : ' ' ?>> Female</label>
                <label><input type="radio" name="gender" value="other"
                        <?= (isset($old['gender']) && $old['gender'] == 'other') ? "checked"  : ' ' ?>> Other</label><br><br>

                        
            <label>Choose your Intrest Group:</label><br>
                <label><input type="checkbox" name="group[]" value="cse" 
                        <?= (isset($old['group']) &&  in_array('cse', $old['group'])) ? 'checked' : '' ?>> CSE</label>
                <label><input type="checkbox" name="group[]" value="mech" 
                        <?= (isset($old['group']) &&  in_array('mech', $old['group'])) ? 'checked' : '' ?>> MECH</label>
                <label><input type="checkbox" name="group[]" value="ece" 
                        <?= (isset($old['group']) &&  in_array('ece', $old['group'])) ? 'checked' : '' ?>> ECE</label>
                <label><input type="checkbox" name="group[]" value="civil" 
                        <?= (isset($old['group']) &&  in_array('civil', $old['group'])) ? 'checked' : '' ?>> CIVIL</label>
                <label><input type="checkbox" name="group[]" value="eee" 
                        <?= (isset($old['group']) &&  in_array('eee', $old['group'])) ? 'checked' : '' ?>> EEE</label><br><br>

            Address: <br>
            <input type="text" name="street" placeholder="Street Address" value="<?= htmlspecialchars($old['street'] ?? '') ?>">
            <input type="text" name="city" placeholder="City" value="<?= htmlspecialchars($old['city'] ?? '') ?>">
            <input type="text" name="state" placeholder="State" value="<?= htmlspecialchars($old['state'] ?? '') ?>">
            <input type="text" name="zip" placeholder="ZIP Code" value="<?= htmlspecialchars($old['zip'] ?? '') ?>">
            <input type="text" name="country" placeholder="Country" value="<?= htmlspecialchars($old['country'] ?? '') ?>"><br><br>

            Upload Previous Marks Memos (PDF or DOC only):
            <input type="file" name="marks[]" accept=".pdf, .doc, .docx" multiple><br>
            <span style="color:red"><?= $errors['memos'] ?? '' ?></span><br><br>


            
            Color of text : <input type="color" name="color"><br><br>
            <input type="button" onclick="alert('Check your details for last time')" value="Click Me!"><br><br>
            <input type="reset" value="Reset">
            <input type="submit" value="Submit">
        </form>
    </div>

    
</body>
</html>