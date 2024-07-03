<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
?>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
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
            <p>Select Registration Type:</p>
            <form method="post" action="signupStudent.php">
                <button type="submit" name="registrationType" value="student">Student Registration</button>
            </form>
            
            <form method="post" action="signupAdviser.php">
                <button type="submit" name="registrationType" value="adviser">Adviser Registration</button>
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