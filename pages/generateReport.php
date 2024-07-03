<?php
// Start the session and include necessary files
session_start();
require_once('../lib/db.php');
require_once('../lib/functions.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Get student number from session
$studentNumber = $_SESSION['user'];

// Retrieve student's course and year level
$course = getStudentCourse($conn, $studentNumber);
$sqlYearLevel = "SELECT Year FROM students WHERE studNum = '$studentNumber'";
$resultYearLevel = $conn->query($sqlYearLevel);
$yearLevel = '';

if ($resultYearLevel && $resultYearLevel->num_rows > 0) {
    $row = $resultYearLevel->fetch_assoc();
    $yearLevel = $row['Year'];
}

// Fetch recommended subjects
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

// Start building the report
$report = "Recommended Subjects for Student Number: $studentNumber\n";
$report .= "Course: $course\n";
$report .= "Year Level: $yearLevel\n\n";

// Check if there are recommended subjects
if ($resultRecommendedSubjects && $resultRecommendedSubjects->num_rows > 0) {
    // Append recommended subjects to the report
    $report .= "Subject Code | Description | Units\n";
    while ($row = $resultRecommendedSubjects->fetch_assoc()) {
        $report .= $row['subjectCode'] . " | " . $row['description'] . " | " . $row['units'] . "\n";
    }
} else {
    $report .= "No recommended subjects found.\n";
}

// Set the appropriate headers for file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="report.txt"');

// Output the report content
echo $report;