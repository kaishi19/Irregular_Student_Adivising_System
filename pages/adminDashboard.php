<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');

$message = '';

$sqlMaxUnits = "SELECT * FROM units";
$resultMaxUnits = $conn->query($sqlMaxUnits);
$maxUnitsRow = $resultMaxUnits->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add_subject') {
        handleAddSubjectAction();
    } elseif ($_POST['action'] === 'edit_subject') {
        handleEditSubjectAction($_POST['subject_code']);
    } elseif ($_POST['action'] === 'set_max_units') {
        $newMaxUnits = $_POST['max_units'];
        $year = $_POST['year'];
        $updateMaxUnitsSql = "UPDATE units SET `Max Units` = $newMaxUnits WHERE Year = $year";
        $conn->query($updateMaxUnitsSql);
    } else {
        $message = 'Invalid action.';
    }
}

$sqlAllSubjects = "SELECT * FROM subjects";
$resultAllSubjects = $conn->query($sqlAllSubjects);

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchQuery)) {
    $sqlAllSubjects = "SELECT * FROM subjects WHERE subjectCode LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
    $resultAllSubjects = $conn->query($sqlAllSubjects);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/userManagement.css">
</head>

<body>

    <nav>
        <a href="#" onclick="openForm('addForm')">Add Subject</a>
        <a href="#" onclick="openForm('searchForm')">Search Subject</a>
        <a href="#" onclick="openForm('existingSubjectsForm')">Existing Subjects</a>
        <a href="#" onclick="openForm('setMaxUnitsForm')">Set Max Units</a>
        <a href="../index.php">Go Back</a>
    </nav>

    <div class="container">

        <form method="post" action="" class="form-container" id="addForm" style="display: none;">
            <h2>Add Subject</h2>
            <label for="subject_code">Subject Code:</label>
            <input type="text" id="subject_code" name="subject_code" required><br>
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required><br>
            <label for="units">Units:</label>
            <input type="number" id="units" name="units" required><br>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required><br>
            <input type="hidden" name="action" value="add_subject">
            <input type="submit" value="Add Subject">
        </form>

        <form method="get" action="" class="form-container" id="searchForm" style="display: none;">
            <h2>Search Subject</h2>
            <label for="search">Search Subject:</label>
            <input type="text" id="search" name="search" placeholder="Enter subject code or description"
                value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="submit" value="Search">
        </form>

        <?php if ($resultAllSubjects && $resultAllSubjects->num_rows > 0) : ?>
            <h2>Existing Subjects</h2>
            <table>
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Description</th>
                        <th>Units</th>
                        <th>Year</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultAllSubjects->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['subjectCode']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['units']; ?></td>
                            <td><?php echo $row['Year']; ?></td>
                            <td><?php echo $row['Course']; ?></td>
                            <td><a href="#" onclick="openForm('editForm<?php echo $row['subjectCode']; ?>')">Edit</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php $resultAllSubjects->data_seek(0); ?>

            <?php while ($row = $resultAllSubjects->fetch_assoc()) : ?>
                <form method="post" action="" class="form-container" id="editForm<?php echo $row['subjectCode']; ?>"
                    style="display: none;">
                    <input type="hidden" name="action" value="edit_subject">
                    <input type="hidden" name="subject_code" value="<?php echo $row['subjectCode']; ?>">
                    <h2>Edit Subject - <?php echo $row['subjectCode']; ?></h2>
                    <label for="description">Description:</label>
                    <input type="text" name="description" value="<?php echo $row['description']; ?>"><br>
                    <label for="units">Units:</label>
                    <input type="number" name="units" value="<?php echo $row['units']; ?>"><br>
                    <label for="year">Year:</label>
                    <input type="number" name="year" value="<?php echo $row['Year']; ?>"><br>
                    <label for="year">Course:</label>
                    <input type="text" name="course" value="<?php echo $row['Course']; ?>"><br>
                    <input type="submit" value="Save Changes">
                </form>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No subjects found.</p>
        <?php endif; ?>

        <form method="post" action="" class="form-container" id="setMaxUnitsForm" style="display: none;">
            <h2>Set Max Units</h2>
            <label for="max_units">Maximum Units:</label>
            <input type="number" id="max_units" name="max_units" value="<?php echo $maxUnitsRow['Max Units']; ?>" required>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" value="<?php echo $maxUnitsRow['Year']; ?>" required>
            <input type="hidden" name="action" value="set_max_units">
            <input type="submit" value="Set Max Units">
        </form>
    </div>

    <script>
        function openForm(formId) {
            closeAllForms();
            document.getElementById(formId).style.display = 'block';
        }

        function closeAllForms() {
            var forms = document.querySelectorAll('.form-container');
            forms.forEach(function (form) {
                form.style.display = 'none';
            });
        }

        document.addEventListener('mousedown', function (event) {
            var isInsideForm = event.target.closest('.form-container');
            if (!isInsideForm) {
                closeAllForms();
            }
        });

        document.querySelectorAll('nav a').forEach(function(link) {
            link.addEventListener('mousedown', function(event) {
                event.preventDefault();
            });
        });
    </script>

</body>

</html>
