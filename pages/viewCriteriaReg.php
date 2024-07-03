<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
include '../includes/headerRegAd.php';
session_start();
$adviserUserID = $_SESSION['user'];

if (isset($_POST['deleteStudent'])) {
    $studentToDelete = $_POST['deleteStudent'];
    
    $sqlUpdateStudent = "UPDATE students SET adviser = '' WHERE studNum = '$studentToDelete' AND adviser = '$adviserUserID'";
    $resultUpdateStudent = $conn->query($sqlUpdateStudent);
    
    if ($resultUpdateStudent) {
    } else {
        echo "Error updating student.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adviser Dashboard - Priority Criteria</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <h2 class="title-box">Students</h2>
    <div class="dashboard-box">
        <?php
        $sqlAllStudents = "SELECT studNum, name FROM students WHERE adviser = '$adviserUserID'";
        $resultAllStudents = $conn->query($sqlAllStudents);

        if ($resultAllStudents && $resultAllStudents->num_rows > 0) {
            echo '<table>
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $resultAllStudents->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['studNum'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="deleteStudent" value="' . $row['studNum'] . '">
                                <button class="view-form-button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No students found.</p>';
        }
        ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>