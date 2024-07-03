<?php
require_once('lib/db.php');
require_once('lib/functions.php');

$message = '';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studNum = $_POST['studNum'];
    $password = $_POST['password'];
    
    $rememberMe = isset($_POST['rememberMe']) ? true : false;

    $message = loginUserVerification($studNum, $password);

    if (empty($message) && $rememberMe) {
        setcookie('studNum', $studNum, time() + (30 * 24 * 3600)); // 30 days expiration
        setcookie('password', $password, time() + (30 * 24 * 3600));
    }
}

?>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CvSU Irregular Student Advising</title>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <img class="logo" src="images\school-logo-small.fc39d2ff.png" alt="Logo">
            <h3>CvSU - Irregular<br> Student<br> Course Advising</h3>
            <p>Login</p>
            <form method="post" action="index.php">
                <input type="text" name="studNum" placeholder="Username" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <label>
                    <input type="checkbox" name="rememberMe"> Remember Me
                </label>
                <a href="pages/forgotPassword.php" class="forgot-password">Forgot Password?</a>
                <br>
                <input type="submit" value="Login">
                <br><br>
                <a href="pages/option.php" class="register-button">Register</a>
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
        <img class="Statue" src="images\layadiwa-removebg-preview.png" alt="statue">
    </div>
</body>
</html>