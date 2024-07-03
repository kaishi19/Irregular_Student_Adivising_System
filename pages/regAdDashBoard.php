<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
include '../includes/headerRegAd.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
    $studNum = $_POST['studNum'];
    $adviserUserID = $_POST['adviserUserID'];

    $insertSql = "UPDATE students SET adviser = '$adviserUserID' WHERE studNum = '$studNum'";
    $conn->query($insertSql);
}

$searchTerm = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_students'])) {
    $searchTerm = $_POST['search_term'];
}

$sqlAllStudents = "SELECT studNum, name, Year FROM students 
                   WHERE adviser = '' AND (studNum LIKE '%$searchTerm%' OR name LIKE '%$searchTerm%')";
$resultAllStudents = $conn->query($sqlAllStudents);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - All Students</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <h2 class="title-box">List of All Students</h2>
    <div class="dashboard-box">
        <form action="" method="POST">
            <label for="search_term">Search Students:</label>
            <input type="text" id="search_term" name="search_term" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search_students">Search</button>
        </form>

        <?php
        if ($resultAllStudents) {
            echo '<table>
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $resultAllStudents->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['studNum'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['Year'] . '</td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="studNum" value="' . $row['studNum'] . '">
                                <input type="hidden" name="adviserUserID" value="' . $_SESSION['user'] . '">
                                <button class="view-form-button" type="submit" name="add_student">Add Student</button>
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