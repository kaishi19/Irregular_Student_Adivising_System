<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
include '../includes/headerRegAd.php';
session_start();
$user = $_SESSION['user'];

// Fetch all students and their form submissions from the database
$sqlAdvisees = "SELECT students.studNum, students.name, forms.file_path 
               FROM students 
               LEFT JOIN forms ON students.studNum = forms.studentNumber
               WHERE students.adviser = '$user'";
$resultAllStudents = $conn->query($sqlAdvisees);

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
        <?php
        if ($resultAllStudents->num_rows > 0) {
            echo '<table>
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Form Submission</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = $resultAllStudents->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['studNum'] . '</td>
                        <td>' . $row['name'] . '</td>
                        <td>';

                // Display link to form submission if available
                if ($row['file_path']) {
                    echo '<button class="view-form-button" onclick="openModal(\'formModal\', \'' . $row['file_path'] . '\')">View Form</button>';
                } else {
                    echo 'No Form Submitted';
                }

                echo '</td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No students found.</p>';
        }
        ?>

    </div>

    <!-- Modal for displaying the form submission -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('formModal')">&times;</span>
            <iframe id="formIframe" style="width: 100%; height: 400px; border: none;"></iframe>
            <button onclick="printForm()" class="print-button">Print</button>
        </div>
    </div>

    <script>
        // Function to open the modal with the given URL
        function openModal(modalId, url) {
            var modal = document.getElementById(modalId);
            var iframe = document.getElementById('formIframe');
            iframe.src = url;
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = 'none';
        }

        // Function to print the content of the modal
        function printForm() {
            var iframe = document.getElementById('formIframe').contentWindow;
            iframe.focus();
            iframe.print();
        }

        // Close the modal if the user clicks outside the modal content
        window.onclick = function (event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                var modal = modals[i];
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>