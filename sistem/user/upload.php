<?php
include 'koneksi.php'; // Include the database connection

// Define the directory to save uploaded files
$uploadDir = 'uploads/';

// Create uploads directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
<<<<<<< Updated upstream
    // Loop through uploaded files
    foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['files']['name'][$key];
        $fileSize = $_FILES['files']['size'][$key];
        $fileTmpName = $_FILES['files']['tmp_name'][$key];
        $fileError = $_FILES['files']['error'][$key];
        
        if ($fileError === UPLOAD_ERR_OK) {
            // Move the uploaded file to the upload directory
            $targetFile = $uploadDir . basename($fileName);
            if (move_uploaded_file($fileTmpName, $targetFile)) {
                $message = 'File uploaded successfully!';
=======
    // Retrieve the user ID and title from the form
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $uploadedAt = date('Y-m-d'); // Current date

    if ($userId > 0 && !empty($title)) {
        foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
            $fileName = $_FILES['files']['name'][$key];
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileError = $_FILES['files']['error'][$key];

            if ($fileError === UPLOAD_ERR_OK) {
                // Create a unique file name to avoid overwriting
                $targetFile = $uploadDir . time() . '_' . basename($fileName);
                if (move_uploaded_file($fileTmpName, $targetFile)) {
                    // Insert file data into the database
                    $sql = "INSERT INTO [sibatta].[document] (user_id, title, uploaded_at) 
                            VALUES (?, ?, ?)";
                    $params = [$userId, $title, $uploadedAt];
                    $stmt = sqlsrv_query($conn, $sql, $params);

                    if ($stmt) {
                        $message = 'File uploaded and saved to the database successfully!';
                    } else {
                        $message = 'Database error: ' . print_r(sqlsrv_errors(), true);
                    }
                } else {
                    $message = 'Error moving uploaded file.';
                }
>>>>>>> Stashed changes
            } else {
                $message = 'There was an error with the file upload.';
            }
        }
    } else {
        $message = 'Please provide a valid User ID and Title.';
    }
}

<<<<<<< Updated upstream
// Retrieve list of uploaded files
$files = array_diff(scandir($uploadDir), array('.', '..')); // List files in the uploads directory

?>

=======
// Retrieve list of uploaded documents from the database
$sql = "SELECT document_id, title, uploaded_at, validated_by FROM [sibatta].[document]";
$stmt = sqlsrv_query($conn, $sql);
$documents = [];
if ($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $documents[] = $row;
    }
}
?>

>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
<<<<<<< Updated upstream
<div id="sidebar">
        <div class="text-center p-3">
            <img src="css/images/logo_Polinema.png" alt="Logo" width="50" height="40" class="img-fluid">
            <h5 class="mt-2 text-dark">SIBATTA</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a class="nav-link text-dark d-flex align-items-center" href="main_user.php">
                    <ion-icon name="home-outline" class="me-2"></ion-icon> <span>Beranda</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark d-flex align-items-center" href="upload.php">
                    <ion-icon name="cloud-upload-outline" class="me-2"></ion-icon> <span>Upload</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark d-flex align-items-center" href="history.php">
                    <ion-icon name="time-outline" class="me-2"></ion-icon> <span>History</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Horizontal Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-outline-light me-2" id="sidebarToggle">
                <ion-icon name="menu-outline"></ion-icon>
            </button>
            <span class="navbar-brand">SIBATTA</span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="location.reload()">
                            <ion-icon name="refresh-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <ion-icon name="chatbubbles-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <ion-icon name="mail-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
   
    <!-- Overlay -->
    <div id="overlay"></div>

    <!-- Main Content -->
=======
>>>>>>> Stashed changes
    <div class="container mt-4">
        <h1>Upload File</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Form Upload -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="number" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="fileInput" class="form-label">Select Files</label>
                <input type="file" class="form-control" id="fileInput" name="files[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Uploaded Files -->
        <div class="table-container mt-4">
            <h3>Uploaded Documents</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Document ID</th>
                        <th>Title</th>
                        <th>Uploaded At</th>
                        <th>Validated By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td><?php echo $doc['document_id']; ?></td>
                                <td><?php echo $doc['title']; ?></td>
                                <td><?php echo $doc['uploaded_at']->format('Y-m-d'); ?></td>
                                <td><?php echo $doc['validated_by'] ?: 'Not validated'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No documents uploaded yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
