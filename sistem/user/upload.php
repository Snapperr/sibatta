<?php
// Define the directory to save uploaded files
$uploadDir = 'uploads/';

// Create uploads directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
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
            } else {
                $message = 'Error uploading file.';
            }
        } else {
            $message = 'There was an error with the file upload.';
        }
    }
}

// Retrieve list of uploaded files
$files = array_diff(scandir($uploadDir), array('.', '..')); // List files in the uploads directory

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="css/upload.css">
</head>

<body>
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
    <div class="container mt-4">
        <h1>Upload File</h1>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <!-- Form Upload -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fileInput" class="form-label">Pilih File</label>
                <input type="file" class="form-control" id="fileInput" name="files[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        <!-- Table -->
        <!-- Table -->
<div class="table-container mt-4">
    <h3>Uploaded Files</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>File Name</th>
                <th>File Size</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($files)): ?>
                <?php foreach ($files as $index => $file): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $file; ?></td>
                        <td><?php echo number_format(filesize($uploadDir . $file) / 1024, 2) . ' KB'; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', filemtime($uploadDir . $file)); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="<?php echo $uploadDir . $file; ?>" download class="btn btn-sm btn-success me-2">Download</a>
                                <input type="checkbox" name="file_check[]" value="<?php echo $file; ?>">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No files uploaded yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Handle sidebar toggle
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Close sidebar when overlay is clicked
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>

</html>
