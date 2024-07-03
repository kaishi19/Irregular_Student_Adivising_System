<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
include '../includes/header.php';

session_start();
$studentNumber = $_SESSION['user'];
$yearLevel = getStudentYearLevel($conn, $studentNumber);
$course = getStudentCourse($conn, $studentNumber);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['year']) || isset($_POST['course'])) {
    $newYearLevel = $_POST['year'];
    $newCourse = $_POST['course'];
    updateYearLevel($conn, $studentNumber, $newYearLevel);
    updateCourse($conn, $studentNumber, $newCourse);

    header("Location: " . $_SERVER['REQUEST_URI']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_subject'])) {
        $newSubjectCode = $_POST['new_subject'];

        $currentUnits = getCurrentUnits($conn, $studentNumber);
        $subjectUnits = getSubjectUnits($conn, $newSubjectCode);

        $maxUnits = getMaxUnits($conn, $yearLevel);

        if (($currentUnits + $subjectUnits) <= $maxUnits) {
            $failedCount = getFailedSubjectCount($conn, $studentNumber);
        
            // Check if the subject has failed 3 times
            if ($failedCount >= 3) {
                // Cut the units to 15
                $currentUnits = 15;
                echo '<script>alert("Student has failed the subject three times. Units have been cut to 15.");</script>';
            }else{
                addNewSubject($conn, $studentNumber, $newSubjectCode);
            }
        
        } else {
            echo '<script>alert("Adding the subject exceeds the maximum units allowed for the year.");</script>';
        }
    }

    if (isset($_POST['marks'])) {
        $marks = $_POST['marks'];
        updateSubjectStatus($conn, $studentNumber, $marks);
    }
    
    if (isset($_POST['delete_subject'])) {
        $subjectCodeToDelete = $_POST['delete_subject'];
        if (deleteSubject($conn, $studentNumber, $subjectCodeToDelete)) {
            echo '<script>alert("Subject deleted successfully.");</script>';
        } else {
            echo '<script>alert("Failed to delete the subject.");</script>';
        }
    }

    if (isset($_POST['email']) || isset($_POST['name'])) {
        $newEmail = $_POST['email'];
        updateEmail($conn, $studentNumber, $newEmail);

        if (updateEmail($conn, $studentNumber, $newEmail)) {
            echo '<script>alert("Email and Name updated successfully.");</script>';
        } else {
            echo '<script>alert("Failed to update Email and Name.");</script>';
        }
    }

}

$studentInfo = getStudentInfo($conn, $studentNumber);
$allSubjects = getAllSubjects($conn, $yearLevel, $course);
$studentSubjects = getStudentSubjects($conn, $studentNumber);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .hidden {
            display: none;
        }

        .toggle-link {
            cursor: pointer;
            color: green;
            text-decoration: none;
            border-bottom: 1px solid #3498db;
            padding-bottom: 2px;
            margin-right: 10px;
        }

        .toggle-link:hover {
            color: #2980b9;
            border-bottom: 1px solid #2980b9;
        }
    </style>
    <script>
        function toggleSection(sectionId) {
            var section = document.getElementById(sectionId);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }

        function toggleEdit(field) {
            const displayElement = document.getElementById(`${field}Display`);
            const inputElement = document.getElementById(`${field}Input`);

            if (displayElement && inputElement) {
                displayElement.classList.toggle('hidden');
                inputElement.classList.toggle('hidden');

                if (!displayElement.classList.contains('hidden')) {
                    // If displaying, copy the value from the display to the input
                    inputElement.value = displayElement.innerText.trim();
                }
            }
        }
    </script>
</head>

<body>
    <h2 class="title-box">Subjects</h2>
    <div class="dashboard-box">
        <div class="dashboard-options">
            <div class="dashboard-option" onclick="toggleSection('studentInfoSection')">
                <span>Student Information</span>
            </div>
            <div class="dashboard-option" onclick="toggleSection('addSubjectsSection')">
                <span>Add Subjects</span>
            </div>
            <div class="dashboard-option" onclick="toggleSection('currentSubjectsSection')">
                <span>Current Subjects</span>
            </div>
        </div>
        <div class="text-container">
            <form action="" method="POST" class="styled-form">
                <input type="hidden" name="user" value="<?php echo $studentNumber; ?>">
                <label for="year" class="form-label">Year Level:</label>
                <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($yearLevel); ?>">
                <label for="course" class="form-label">Course:</label>
                <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($course); ?>">
                <br><br>
                <input type="submit" value="Submit" class="form-button">
            </form>
        </div>

        <h2>
        </h2>
        <div id="studentInfoSection" class="hidden student-info">
            <form action="" method="POST" class="styled-form">
                <p>Name: <?php echo $studentNumber; ?></p>
                <p>Email: <span id="emailDisplay"><?php echo $studentInfo['email']; ?></span>
                    <input type="email" name="email" id="emailInput" class="hidden" value="<?php echo $studentInfo['email']; ?>" />
                    <button type="button" onclick="toggleEdit('email')">Edit</button>
                </p>
                <p>Year Level: <?php echo $yearLevel; ?></p>
                
                <input type="submit" value="Submit" class="form-button">
            </form>
        </div>
        


        <h2>
        </h2>
        <div id="addSubjectsSection" class="hidden">
            <form action="" method="POST" class="styled-form">
                <label for="subject" class="form-label">Select Subject:</label>
                <select name="new_subject" class="form-select">
                    <?php
                    if ($allSubjects && $allSubjects->num_rows > 0) {
                        while ($row = $allSubjects->fetch_assoc()) {
                            $subjectCode = $row['subjectCode'];
                            $description = $row['description'];

                            $isSubjectAdded = isSubjectAdded($conn, $studentNumber, $subjectCode);

                            if (!$isSubjectAdded) {
                                echo '<option value="' . $subjectCode . '">' . $subjectCode . ' - ' . $description . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="form-button">Add Subject</button>
            </form>
        </div>

        <h2>
        </h2>
        <div id="currentSubjectsSection" class="hidden">
        <?php
        if ($studentSubjects && $studentSubjects->num_rows > 0) {
            echo '<form action="" method="POST">';

            echo '<table>
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Description</th>
                            <th>Units</th>
                            <th>Mark</th>
                            <th>Action</th> <!-- Added column for delete action -->
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $studentSubjects->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['subjectCode'] . '</td>
                        <td>' . $row['description'] . '</td>
                        <td>' . $row['units'] . '</td>
                        <td>
                        <select name="marks[' . $row['subjectCode'] . ']">
                            <option value="PASSED" ' . ($row['status'] == 'PASSED' ? 'selected' : '') . '>PASSED</option>
                            <option value="FAILED" ' . ($row['status'] == 'FAILED' ? 'selected' : '') . '>FAILED</option>
                            <option value="IN PROGRESS" ' . ($row['status'] == 'IN PROGRESS' ? 'selected' : '') . '>IN PROGRESS</option>
                        </select>
                        </td>
                        <td>
                            <button type="submit" name="delete_subject" value="' . $row['subjectCode'] . '">Delete</button>
                        </td>
                    </tr>';
            }

            echo '</tbody></table>';

            echo '<input type="hidden" name="student_number" value="' . $studentNumber . '">';
            echo '<input type="hidden" name="year_level" value="' . $yearLevel . '">';
            echo '<br>';
            echo '<input type="submit" value="Submit Marks">';
            echo '</form>';
        } else {
            echo '<p>No subjects found.</p>';
        }
        ?>
        </div>
    </div>
</body>

</html>
