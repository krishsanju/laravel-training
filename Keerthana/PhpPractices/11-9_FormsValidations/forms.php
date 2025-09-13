<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Form 1</h2>

    <form action="process1.php" method = 'post'>
        <input name = 'username' type ="text" placeholder=" Enter name"><br>
        <input name = 'password' type ="pwd" placeholder=" Enter pwd"><br>
        <input type='submit'><br>

        <!-- when name attribute is not given url is after submiting is -->
                <!-- http://localhost:8080/process.php? -->
        <!-- when name attribute is given url is -->
                <!-- http://localhost:8080/process.php?username=sia&password=suki -->
        
        <!-- but when post method is used url is  MORE SECURE-->                 
                <!-- http://localhost:8080/process.php? -->

    </form>

        <h2>Form 1 Search Here</h2>
    <form action="process2.php" method="GET">
        <input name="query" type="text" placeholder="type..."><br>
        <input type="submit">


    </form>

</body>
</html>