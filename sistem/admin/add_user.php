<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sibatta";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get form data
  $user = $_POST['username'];
  $phone = $_POST['no_telepon'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Basic validation for password match
  if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
  }

  // Hash the password before saving to the database
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert user into the database
  $sql = "INSERT INTO users (username, no_telepon, email, password) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $user, $phone, $email, $hashed_password);

  if ($stmt->execute()) {
    echo "User added successfully!";
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close connection
  $stmt->close();
  $conn->close();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">SIBATTA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Log Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Table and Add User Section -->
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
      <h2>User List</h2>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-person-plus-fill"></i> Add User</button>
    </div>
    <div class="my-3">
      <input type="text" class="form-control" id="search" placeholder="Search..." />
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No Telepon</th>
          <th>Prodi</th>
          <th>Level</th>
        </tr>
      </thead>
      <tbody id="userTableBody">
        <?php
        // // if ($result->num_rows > 0) {
        // //     $no = 1;
        // //     while($row = $result->fetch_assoc()) {
        // //         echo "<tr>
        // //                 <td>{$no}</td>
        // //                 <td>{$row['username']}</td>
        // //                 <td>{$row['no_telepon']}</td>
        // //                 <td>{$row['email']}</td>
        // //                 <td>
        // //                     <a href='edit_user.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
        // //                     <a href='delete_user.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
        // //                 </td>
        // //               </tr>";
        // //         $no++;
        // //     }
        // // } else {
        //     echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
        // // }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Modal to Add User -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="add_user_process.php">
            <div class="mb-3">
              <label for="ID" class="form-label">NIM</label>
              <input type="text" class="form-control" id="ID" name="ID" required>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Nama</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="no_telepon" class="form-label">No Telepon</label>
              <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
              </select>
            </div>
            <!-- Prodi Dropdown (Dynamically Loaded) -->
            <div class="mb-3">
              <label for="prodi" class="form-label">Prodi</label>
              <select class="form-select" id="prodi" name="prodi" required> 
              <option value="user">Teknologi Informasi</option>
              <option value="admin">Sistem Informasi Bisnis</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="level" class="form-label">User Level</label>
              <select class="form-select" id="level" name="level" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
          </form>
        </div>
      </div>
    </div>
  </div>

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
                <a class="nav-link text-dark d-flex align-items-center" href="history.php">
                    <ion-icon name="time-outline" class="me-2"></ion-icon> <span>History</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark d-flex align-items-center" href="upload.php">
                    <ion-icon name="cloud-upload-outline" class="me-2"></ion-icon> <span>Upload</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark d-flex align-items-center" href="add_user.php">
                    <ion-icon name="cloud-upload-outline" class="me-2"></ion-icon> <span>ADD</span>
                </a>
            </li>
        </ul>
        <div class="modal-footer">
        <button class="logout-btn btn btn-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <ion-icon name="log-out-outline" style="font-size: 20px;"></ion-icon>
        <span>Log Out</span>
    </a>
</div>

  <!-- Optional JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('#userTableBody tr');
      rows.forEach(row => {
        const name = row.cells[1].innerText.toLowerCase();
        if (name.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
</body>

</html>