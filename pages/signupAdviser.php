<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['Name']) && isset($_POST['password']) && isset($_POST['confirmPassword']) && isset($_POST['email'])) {
        $Name = $_POST['Name'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $email = $_POST['email'];

        $message = signUpUserVerificationnAdvisers($Name, $password, $confirmPassword, $email);
    }
}

?>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <input type="text" name="Name" placeholder="Name" required><br>
                <input type="text" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be at least 8 characters long and include at least one lowercase letter, one uppercase letter, and one digit"><br>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br>
                <br>
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