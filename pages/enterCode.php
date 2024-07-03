<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');

// Check if the email parameter is set in the URL
if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    // If the email parameter is not set, redirect to the index page
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verificationCode = isset($_POST['code']) ? $_POST['code'] : '';

    // Call the function to check the verification code
    checkVerificationCode($email, $verificationCode);
}
?>
?>

<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <img src="..\images\school-logo-small.fc39d2ff.png" alt="Logo">
            <h3>CvSU - Irregular<br> Student<br> Course Advising</h3>
            <p>Login</p>
            <form method="post" action="">
                <input type="text" name="code" placeholder="Enter Code" required><br>
                <br>
                <input type="submit" value="Verify">
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