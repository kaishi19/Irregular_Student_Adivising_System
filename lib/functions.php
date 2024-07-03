<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\Exception.php';
require 'PHPMailer\src\SMTP.php';

function createUserStduent($studNum, $password, $email, $name) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO students (studNum, password, email, name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $studNum, $hashedPassword, $email, $name);
    return $stmt->execute();
}

function createUserAdvisers($name, $password, $email) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO `registration adviser` (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $hashedPassword, $email);
    return $stmt->execute();
}

function getUserStudent($studNum) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM students WHERE studNum = ?");
    if (!$stmt) {
        return null; 
    }

    $stmt->bind_param("s", $studNum);
    $success = $stmt->execute();
    
    if (!$success) {
        return null; 
    }

    $result = $stmt->get_result();
    return $result ? $result->fetch_assoc() : null;
}

function getUserAdviser($name) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `registration adviser` WHERE `username` = ?");
    if (!$stmt) {
        return null; 
    }

    $stmt->bind_param("s", $name);
    $success = $stmt->execute();
    
    if (!$success) {
        return null; 
    }

    $result = $stmt->get_result();
    return $result ? $result->fetch_assoc() : null;
}

function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

function signUpUserVerificationnStudents($studNum, $password, $confirmPassword, $email, $name)
{
    if (getUserStudent($studNum)) {
        return 'Student Number already exists. Please choose another.';
    }

    if($confirmPassword != $password){
        return 'Wrong confirm password';
    }

    if (createUserStduent($studNum, $password, $email, $name)) {
        return 'User created successfully.';
    } else {
        return 'Error creating user. Please try again.';
    }
}

function signUpUserVerificationnAdvisers($Name, $password, $confirmPassword, $email)
{
    if (getUserAdviser($Name)) {
        return 'Adviser already exists. Please choose another.';
    }

    if($confirmPassword != $password){
        return 'Wrong confirm password';
    }

    if (createUserAdvisers($Name, $password, $email)) {
        return 'User created successfully.';
    } else {
        return 'Error creating user. Please try again.';
    }
}

function loginUserVerification($studNum, $password)
{
    $userStudent = getUserStudent($studNum);
    $userAdviser = getUserAdviser($studNum);
    session_start();
    $_SESSION['user'] = $studNum;

    if ($userStudent !== null && verifyPassword($password, $userStudent['password'])) {
        header("Location: pages/studentDashBoard.php");
        exit();
    } else if ($userAdviser !== null && verifyPassword($password, $userAdviser['password'])) {
        header("Location: pages/regAdDashBoard.php");
        exit();
    } else if ($studNum == 'admin' && $password == '123') {
        header("Location: pages/adminDashBoard.php");
        exit();
    }
}

function saveVerificationCodeToDatabase($email, $verificationCode) {
    global $conn;

    $updateRegistrationAdviserQuery = "UPDATE `registration adviser` SET verification_code = ? WHERE email = ?";
    $updateRegistrationAdviserStmt = $conn->prepare($updateRegistrationAdviserQuery);

    if (!$updateRegistrationAdviserStmt) {
        throw new Exception("Error preparing statement for registration_advisers: " . $conn->error);
    }

    $updateRegistrationAdviserStmt->bind_param("ss", $verificationCode, $email);
    $updateRegistrationAdviserStmt->execute();

    $updateIrregularStudentQuery = "UPDATE `students` SET verification_code = ? WHERE email = ?";
    $updateIrregularStudentStmt = $conn->prepare($updateIrregularStudentQuery);

    if (!$updateIrregularStudentStmt) {
        throw new Exception("Error preparing statement for irregular_students: " . $conn->error);
    }

    $updateIrregularStudentStmt->bind_param("ss", $verificationCode, $email);
    $updateIrregularStudentStmt->execute();
}

function emailExistsInDatabase($email) {
    global $conn;

    try {
        $irregularStudentQuery = "SELECT * FROM students WHERE email = ?";
        $irregularStudentStmt = $conn->prepare($irregularStudentQuery);
        if (!$irregularStudentStmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }
        $irregularStudentStmt->bind_param('s', $email);
        $irregularStudentStmt->execute();
        $irregularStudentStmt->store_result();
        $irregularStudentResult = $irregularStudentStmt->num_rows > 0;

        $adviserQuery = "SELECT * FROM `registration adviser` WHERE email = ?";
        $adviserStmt = $conn->prepare($adviserQuery);
        if (!$adviserStmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }
        $adviserStmt->bind_param('s', $email);
        $adviserStmt->execute();
        $adviserStmt->store_result();
        $adviserResult = $adviserStmt->num_rows > 0;

        return $irregularStudentResult || $adviserResult;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function sendVerificationCode($email, $verificationCode) {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {
        echo "debug level $level; message: $str";
    };
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';      
        $mail->SMTPAuth   = true;
        $mail->Username   = 'irregsystem13@gmail.com'; 
        $mail->Password   = 'eqho cayl ghlv ynmh';       
        $mail->SMTPSecure = 'tls';                
        $mail->Port = 587;                    

        //Recipients
        $mail->setFrom('irregsystem13@gmail.com', 'Developers');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code for Irregular Student Advising System';
        $mail->Body    = "Your verification code is: $verificationCode";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function generateVerificationCode($length = 6) {
    $characters = '0123456789';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

function checkVerificationCode($email, $userInputCode) {
    global $conn; 

    try {
        $registrationAdviserQuery = "SELECT * FROM `registration adviser` WHERE email = ? AND verification_code = ?";
        $registrationAdviserStmt = $conn->prepare($registrationAdviserQuery);

        if (!$registrationAdviserStmt) {
            throw new Exception("Error preparing statement for registration_advisers: " . $conn->error);
        }

        $registrationAdviserStmt->bind_param("ss", $email, $userInputCode);
        $registrationAdviserStmt->execute();
        $registrationAdviserStmt->store_result();

        if ($registrationAdviserStmt->num_rows > 0) {
            header("Location: changePassword.php?email=$email");
            exit();
        }

        $registrationAdviserStmt->close();

        $irregularStudentQuery = "SELECT * FROM `students` WHERE email = ? AND verification_code = ?";
        $irregularStudentStmt = $conn->prepare($irregularStudentQuery);

        if (!$irregularStudentStmt) {
            throw new Exception("Error preparing statement for irregular_students: " . $conn->error);
        }

        $irregularStudentStmt->bind_param("ss", $email, $userInputCode);
        $irregularStudentStmt->execute();
        $irregularStudentStmt->store_result();

        if ($irregularStudentStmt->num_rows > 0) {
            header("Location: changePassword.php?email=$email");
            exit();
        } else {
            $message = "Verification code is incorrect.";
        }

        $irregularStudentStmt->close();
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

function updatePassword($newPassword, $email) {
    global $conn;

    try {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $registrationAdviserQuery = "UPDATE `registration adviser` SET password = ? WHERE email = ?";
        $registrationAdviserStmt = $conn->prepare($registrationAdviserQuery);

        if (!$registrationAdviserStmt) {
            throw new Exception("Error preparing statement for registration_advisers: " . $conn->error);
        }

        $registrationAdviserStmt->bind_param("ss", $hashedPassword, $email);
        $registrationAdviserStmt->execute();

        $registrationAdviserStmt->close();

        $irregularStudentQuery = "UPDATE `students` SET password = ? WHERE email = ?";
        $irregularStudentStmt = $conn->prepare($irregularStudentQuery);

        if (!$irregularStudentStmt) {
            throw new Exception("Error preparing statement for irregular_students: " . $conn->error);
        }

        $irregularStudentStmt->bind_param("ss", $hashedPassword, $email);
        $irregularStudentStmt->execute();

        $irregularStudentStmt->close();

        return true; 
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false; 
    }
}

function getStudentYearLevel($conn, $studentNumber) {
    $sqlYearLevel = "SELECT Year FROM students WHERE studNum = '$studentNumber'";
    $resultYearLevel = $conn->query($sqlYearLevel);

    if ($resultYearLevel && $resultYearLevel->num_rows > 0) {
        $row = $resultYearLevel->fetch_assoc();
        return $row['Year'];
    } else {
        return '';
    }
}

function getStudentCourse($conn, $studentNumber) {
    $sqlYearLevel = "SELECT course FROM students WHERE studNum = '$studentNumber'";
    $resultYearLevel = $conn->query($sqlYearLevel);

    if ($resultYearLevel && $resultYearLevel->num_rows > 0) {
        $row = $resultYearLevel->fetch_assoc();
        return $row['course'];
    } else {
        return '';
    }
}

function updateYearLevel($conn, $studentNumber, $newYearLevel) {
    $updateYearLevelSql = "UPDATE students SET Year = '$newYearLevel' WHERE studNum = '$studentNumber'";
    $conn->query($updateYearLevelSql);
}

function updateCourse($conn, $studentNumber, $course) {
    $updateYearLevelSql = "UPDATE students SET Course = '$course' WHERE studNum = '$studentNumber'";
    $conn->query($updateYearLevelSql);
}

function addNewSubject($conn, $studentNumber, $newSubjectCode) {
    $insertSql = "INSERT INTO taken_subjects (studNum, subjectCode, status) VALUES ('$studentNumber', '$newSubjectCode', 'IN PROGRESS')";
    $conn->query($insertSql);
}

function updateSubjectStatus($conn, $studentNumber, $marks) {
    foreach ($marks as $subjectCode => $mark) {
        $updateSql = "UPDATE taken_subjects SET status = '$mark' WHERE studNum = '$studentNumber' AND subjectCode = '$subjectCode'";
        $conn->query($updateSql);
    }
}

function getStudentInfo($conn, $studentNumber) {
    $sqlStudentInfo = "SELECT name, email FROM students WHERE studNum = '$studentNumber'";
    $resultStudentInfo = $conn->query($sqlStudentInfo);
    return $resultStudentInfo->fetch_assoc();
}

function getAllSubjects($conn, $yearLevel, $course) {
    $sqlAllSubjects = "SELECT * FROM subjects WHERE Year <= ? AND course = ?";
    
    $stmt = $conn->prepare($sqlAllSubjects);
    $stmt->bind_param("is", $yearLevel, $course);
    $stmt->execute();
    
    return $stmt->get_result();
}

function getStudentSubjects($conn, $studentNumber) {
    $sqlStudentSubjects = "SELECT ts.subjectCode, ts.status, s.description, s.units FROM taken_subjects ts JOIN subjects s ON ts.subjectCode = s.subjectCode WHERE ts.studNum = '$studentNumber'";
    return $conn->query($sqlStudentSubjects);
}

function handleAddSubjectAction() {
    global $conn;
    $subjectCode = $_POST['subject_code'];
    $description = $_POST['description'];
    $units = $_POST['units'];
    $year = $_POST['year'];
    $course = $_POST['course'];

    $sql = "INSERT INTO subjects (subjectCode, description, units, Year, Course) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiis", $subjectCode, $description, $units, $year, $course);

    if ($stmt->execute()) {
        $GLOBALS['message'] = 'Subject added successfully!';
    } else {
        $GLOBALS['message'] = 'Error adding subject.';
    }
}

function handleEditSubjectAction($subjectCode) {
    global $conn;
    $description = $_POST['description'];
    $units = $_POST['units'];
    $year = $_POST['year'];
    $course = $_POST['course'];

    $sql = "UPDATE subjects SET description=?, units=?, Year=?, Course=? WHERE subjectCode=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiss", $description, $units, $year, $course, $subjectCode);


    if ($stmt->execute()) {
        $GLOBALS['message'] = 'Subject updated successfully!';
    } else {
        $GLOBALS['message'] = 'Error updating subject.';
    }
}

function getCurrentUnits($conn, $studentNumber) {
    $sql = "SELECT SUM(s.units) AS total_units
            FROM taken_subjects ts
            JOIN subjects s ON ts.subjectCode = s.subjectCode
            WHERE ts.studNum = '$studentNumber' AND ts.status != 'PASSED'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_units'];
    }

    return 0; 
}


function getSubjectUnits($conn, $subjectCode) {

    $sql = "SELECT units FROM subjects WHERE subjectCode = '$subjectCode'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['units'];
    }

    return 0; 
}

function getMaxUnits($conn, $yearLevel) {
    $sql = "SELECT `Max Units` FROM units WHERE `Year` = '$yearLevel'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['Max Units'];
    }

    return 0; 
}

function deleteSubject($conn, $studentNumber, $subjectCode) {
    $sql = "DELETE FROM taken_subjects WHERE studNum = '$studentNumber' AND subjectCode = '$subjectCode'";
    return $conn->query($sql);
}

function updateEmail($conn, $studentNumber, $newEmail) {
    $stmt = $conn->prepare("UPDATE students SET email = ? WHERE studNum = ?");
    $stmt->bind_param("ss", $newEmail, $studentNumber);
    return $stmt->execute();
}

function getFailedSubjectCount($conn, $studentNumber) {
    $sql = "SELECT COUNT(*) AS failed_count FROM taken_subjects WHERE `studNum` = '$studentNumber' AND `status` = 'FAILED'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['failed_count'];
    }

    return 0;
}

function isSubjectUsedAsPrerequisiteForUser($conn, $studentNumber, $subjectCode, $studentYearLevel) {
    $sql = "SELECT COUNT(*) AS count 
            FROM subjects s
            WHERE s.prerequisites IS NOT NULL 
            AND s.prerequisites <> ''
            AND s.prerequisites LIKE '%$subjectCode%'
            AND s.Year < '$studentYearLevel'";
    
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    return false;
}

function isSubjectAdded($conn, $studentNumber, $subjectCode) {
    $query = "SELECT COUNT(*) as count FROM taken_subjects WHERE studNum = ? AND subjectCode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $studentNumber, $subjectCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    return $count > 0;
}
?>