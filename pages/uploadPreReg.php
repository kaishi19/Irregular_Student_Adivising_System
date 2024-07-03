<?php
require_once('../lib/db.php');
require_once('../lib/functions.php');
include '../includes/header.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] != 4) {
    $user = mysqli_real_escape_string($conn, $_SESSION['user']);

    $fileUploadDir = '../uploads/';

    $fileUploadPath = $fileUploadDir . basename($_FILES['fileUpload']['name']);

    // Use finfo to get MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileMimeType = finfo_file($finfo, $_FILES['fileUpload']['tmp_name']);
    finfo_close($finfo);

    // Define allowed MIME types
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];

    // Check if the MIME type is allowed
    if (in_array($fileMimeType, $allowedMimeTypes) && move_uploaded_file($_FILES['fileUpload']['tmp_name'], $fileUploadPath)) {
        // Prepare and execute the SQL query
        $sqlInsert = "INSERT INTO forms (studentNumber, file_path) VALUES (?, ?)";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("ss", $user, $fileUploadPath);

        if ($stmt->execute()) {
            echo '<script>alert("File uploaded successfully.");</script>';
        } else {
            echo '<script>alert("Failed to insert into the database.");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("Invalid file type. Please upload an image (jpg, jpeg, png) or a PDF.");</script>';
    }
}

// Close the database connection
$conn->close();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        #fileDropZone {
            border: 2px dashed #ccc;
            padding: 70px; 
            text-align: center;
            cursor: pointer;
        }

        #fileDropZone.dragover {
            background-color: #f0f8ff; 
        }

        label[for="fileUpload"] {
            display: block;
            margin: 10px auto; 
            cursor: pointer;
        }


        input[type="file"] {
            display: none; 
        }

        input[type="submit"] {
            background-color: #195905;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            margin-left: 47%;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }
    </style>
</head>

<body>
    <h2 class="title-box">Pre-registration Form</h2>
    <div class="dashboard-box">
        <form action="" method="post" enctype="multipart/form-data">
            <div id="fileDropZone">
                <p>Drag and drop your file here</p>
                <p>or</p>
                <label for="fileUpload">Select a file:</label>
                <input type="file" name="fileUpload" id="fileUpload">
                <span id="selectedFileName"></span> <!-- Display selected file name -->
            </div>
            <input type="submit" value="Upload">
        </form>
    </div>

    <script>
        const fileDropZone = document.getElementById('fileDropZone');
        const selectedFileName = document.getElementById('selectedFileName');
        const fileUpload = document.getElementById('fileUpload');

        fileDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileDropZone.classList.add('dragover');
        });

        fileDropZone.addEventListener('dragleave', () => {
            fileDropZone.classList.remove('dragover');
        });

        fileDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            fileDropZone.classList.remove('dragover');

            const files = e.dataTransfer.files;
            updateSelectedFileName(files);
        });

        fileUpload.addEventListener('change', () => {
            const files = fileUpload.files;
            updateSelectedFileName(files);
        });

        function updateSelectedFileName(files) {
            if (files.length > 0) {
                selectedFileName.textContent = `Selected File: ${files[0].name}`;
            } else {
                selectedFileName.textContent = '';
            }
        }
    </script>
</body>