<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/headerStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <img src="..\images\school-logo-small.fc39d2ff.png" alt="Logo">
        <h1>CvSU - Irregular Student Course Advising</h1>
        <nav>
        <div class="dropdown">
        <button class="menu" onclick="toggleDropdown()">
            <img src="../images/menu.svg" class="burger" id="menuIcon">
        </button>
            <div class="dropdown-content" id="myDropdown">
                <strong>
                    <a href="studentDashboard.php">Home</a>
                    <a href="uploadPreReg.php">Upload Pre reg</a>
                    <a href="viewCriteria.php">Recommendation</a>
                    <a href="../lib/logout.php">Logout</a>
                </strong>
            </div>
            </div>
        </nav>
    </header>

    <script src="../js/function.js"></script>
</body>
</html>