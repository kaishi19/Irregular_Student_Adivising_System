<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['studNum']) && isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_POST['email'])) {
        $studNum = $_POST['studNum'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email address.';
        }
        $name = $_POST['name'];
        
        $message = signUpUserVerificationnStudents($studNum, $password, $confirmPassword, $email, $name);
    }

}

?>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>CvSU Irregular Student Advising</title>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <img class="logo" src="..\images\school-logo-small.fc39d2ff.png" alt="Logo">
            <h3>CvSU - Irregular<br> Student<br> Course Advising</h3>
            <p>Login</p>
            <p><?php echo $message; ?></p>
            <form method="post" action="">
                <input type="text" name="studNum" placeholder="Student Number" required><br>
                <input type="email" name="email" placeholder="Email" required title="Please enter a valid email address"><br>
                <input type="text" name="name" pattern="[A-Za-z\s]+" title="Please enter a valid name (letters and spaces only)" placeholder="Name" required><br>
                <input type="password" name="password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, and one digit"><br>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br>                <br>
                <input type="submit" value="Register">
                <br><br>
                <a href="../index.php" class="register-button">Back to Login</a>
            </form>
        </div>
        <div class="separator"></div>
        <div class="vertical-box"></div>
    </div>

    <div class="right-side">
        <h1 class="truth">T R U T H</h1>
        <br>
        <h1 class="excellence">E X C E L L E N C E</h1>
        <br>
        <h1 class="service">S E R V I C E</h1>
        <img class="Statue" src="..\images\layadiwa-removebg-preview.png" alt="statue">
    </div>
</body>
</html>