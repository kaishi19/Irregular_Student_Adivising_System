<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_GET['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $newPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

    if ($password == $newPassword) {
        if (updatePassword($newPassword, $email)) {
            $message = 'Password updated successfully.';
        } else {
            $message = 'Password update failed. Please try again.';
        }
    } else {
        $message = 'Passwords do not match. Please try again.';
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
            <img src="..\images\school-logo-small.fc39d2ff.png" alt="Logo">
            <h3>CvSU - Irregular<br> Student<br> Course Advising</h3>
            <p>Reset Password</p>
            <h3>Enter your new password</h3>
            <form method="post" action="">
                <input type="password" name="password" placeholder="Enter New Password" required><br>
                <input type="password" name="confirmPassword" placeholder="Confirm New Password" required><br>
                <br>
                <input type="submit" value="Reset Password">
                <br><br>
                <a href="../index.php" class="register-button">Back to Login</a>
            </form>
            <p><?php echo $message; ?></p>
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