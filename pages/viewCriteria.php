<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
include '../includes/header.php';
session_start();
$studentNumber = $_SESSION['user'];
$sqlYearLevel = "SELECT Year FROM students WHERE studNum = '$studentNumber'";
$resultYearLevel = $conn->query($sqlYearLevel);
$course = getStudentCourse($conn, $studentNumber);

if ($resultYearLevel && $resultYearLevel->num_rows > 0) {
    $row = $resultYearLevel->fetch_assoc();
    $yearLevel = $row['Year'];
} else {
    $yearLevel = '';
}
$sqlStudentSubjects = "SELECT subjectCode, status FROM taken_subjects WHERE studNum = '$studentNumber'";
$resultStudentSubjects = $conn->query($sqlStudentSubjects);

$sqlRecommendedSubjects = "SELECT * FROM subjects 
    WHERE Year <= '$yearLevel'
    AND Course = '$course'
    AND subjectCode NOT IN (
        SELECT ts.subjectCode FROM taken_subjects ts
        WHERE ts.studNum = '$studentNumber' AND ts.status = 'PASSED'
    )
    AND (
        (prerequisites IS NULL OR prerequisites = '')
        OR
        (prerequisites IN (
            SELECT ts.subjectCode FROM taken_subjects ts
            WHERE ts.studNum = '$studentNumber' AND ts.status = 'PASSED'
        ))
        OR
        (subjectCode IN (
            SELECT ts.subjectCode FROM taken_subjects ts
            WHERE ts.studNum = '$studentNumber' AND ts.status = 'FAILED'
        ))
    )";
$resultRecommendedSubjects = $conn->query($sqlRecommendedSubjects);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Admin Dashboard</title>
    <style>
        .highlight-prerequisites {
            background-color: #C8A320; /* Change the color as needed */
        }

        .highlight-previous-years {
            background-color: #D3D3D3; /* Change the color as needed */
        }
    </style>
</head>

<body>
    <h2 class="title-box">Recommended Subjects</h2>
    <div class="dashboard-box">
    <button id="generateReportBtn">Generate Report</button>
        <?php
        if ($resultRecommendedSubjects && $resultRecommendedSubjects->num_rows > 0) {
            echo '       <table>
            <thead>
                <tr>
                    <th colspan="3">Legend</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="highlight-prerequisites">Prerequisites</td>
                    <td colspan="2">Recommended Subjects</td>
                </tr>
                <tr>
                    <td class="highlight-previous-years">Previous Years</td>
                    <td colspan="2">Takeable Subjects</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <th>Subject Code</th>
                    <th>Description</th>
                    <th>Units</th>
                </tr>';

            while ($row = $resultRecommendedSubjects->fetch_assoc()) {
                $highlightClass = '';

                if (isSubjectUsedAsPrerequisiteForUser($conn, $studentNumber, $row['subjectCode'], $yearLevel)) {
                    // Check if the user hasn't chosen subjects with prerequisites for the current year
                    $highlightClass = 'highlight-prerequisites';
                } else {
                    $highlightClass = 'highlight-previous-years';
                }

                

                echo '<tr class="' . $highlightClass . '">
                        <td>' . $row['subjectCode'] . '</td>
                        <td>' . $row['description'] . '</td>
                        <td>' . $row['units'] . '</td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo "$yearLevel";
            echo '<p>No recommended subjects found.</p>';
        }
        ?>
    </div>

    <script>
        document.getElementById("generateReportBtn").addEventListener("click", function() {
            // Redirect to a PHP script that generates the report
            window.location.href = "generateReport.php";
        });
    </script>
</body>

</html>