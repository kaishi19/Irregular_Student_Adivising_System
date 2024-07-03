<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/headerStyle.css">
</head>
<body>
    <header>
        <img src="..\images\school-logo-small.fc39d2ff.png" alt="Logo">
        <h1>CvSU - Irregular Student Course <br>Advising</h1>
        <nav>
            <strong>
            <!-- Use the session variable directly in the links -->
            <a href="regAdDashBoard.php">Home</a>
            <a href="viewPreReg.php">View Pre reg</a>
            <a href="viewCriteriaReg.php">View Students</a>
            <a href="../lib/logout.php">Logout</a>
            </strong>
        </nav>
    </header>
</body>
</html>