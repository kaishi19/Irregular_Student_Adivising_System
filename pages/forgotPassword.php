<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : ''; 
    
    if (!empty($email) && emailExistsInDatabase($email)) {
        $verificationCode = generateVerificationCode();
        sendVerificationCode($email, $verificationCode);
    
        saveVerificationCodeToDatabase($email, $verificationCode);
    
        header("Location: enterCode.php?email=$email");
        exit();
    } else {
        $message = 'Email not found. Please check your email and try again.';
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <img class="logo" src="..\images\school-logo-small.fc39d2ff.png" alt="Logo">
            <h3>CvSU - Irregular<br> Student<br> Course Advising</h3>
            <p>Please provide your CvSU email address to receive a verification code.</p>
            <form method="post" action="">
                <input type="text" name="email" placeholder="Email" required><br>
                <br>
                <input type="submit" value="Send Code">
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