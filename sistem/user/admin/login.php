<?php
// Start the session
session_start();
<<<<<<< HEAD
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
=======

// Include the database connection
require 'koneksi.php';
>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910

// Placeholder for message if login fails
$message = "";

<<<<<<< HEAD
=======
// Check if the form is submitted
>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

<<<<<<< HEAD
    // Simulate database check (you should replace this with actual database validation)
    if ($username == "your_correct_username" && $password == "your_correct_password") {
        // Set session variables and redirect to the main page
        $_SESSION['username'] = $username;
        header('Location: main.php'); // Redirect to main.php on success
        exit();
=======
    // Validate input
    if (!empty($username) && !empty($password)) {
        // Query to check if the user exists and password matches
        $sql = "SELECT * FROM [sibatta].[user] WHERE username = ? AND password = ?";
        $params = array($username, $password);

        $stmt = sqlsrv_query($conn, $sql, $params);

        // Check if the query executed successfully
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Fetch the user data
        if ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Set session variables
            $_SESSION['username'] = $user['username'];

            // Redirect to main.php
            header('Location: main_user.php');
            exit();
        } else {
            // Invalid username or password
            $message = "Invalid username or password!";
        }
>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910
    } else {
        $message = "Please fill in all fields!";
    }
<<<<<<< HEAD

}
// Simulasi nama pengguna yang disimpan di session

?>
<!-- Replace in HTML -->
<span id="username"><?php echo $username; ?></span>

=======
}
>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PBL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <div class="container">
            <!-- Login Form -->
<<<<<<< HEAD
            <form class="needs-validation" novalidate method="POST" action="main.php">
                <div class="header text-center mb-4">
                    <img src="css/images/logo_Polinema.png" alt="Logo" class="logo" />
                </div>
                
                <h1 class="h3 mb-3 fw-normal text-center" style="color: black;">SIBATTA</h1>
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger text-center"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <!-- NIM Input -->
                <div class="form-floating mb-3">
                    <input name="username" type="" class="form-control" id="floatingInput" placeholder="Enter NIM" required>
                    <label for="floatingInput">NIM</label>
                    <div class="invalid-feedback">
                        Masukan NIM Yang Terdaftar
=======
            <form class="needs-validation" novalidate method="POST" action="">
                <div class="header text-center mb-4">
                    <img src="css/images/logo_Polinema.png" alt="Logo" class="logo" />
                </div>

                <h1 class="h3 mb-3 fw-normal text-center" style="color: black;">SIBATTA</h1>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger text-center"><?php echo $message; ?></div>
                <?php endif; ?>

                <!-- Username Input -->
                <div class="form-floating mb-3">
                    <input name="username" type="text" class="form-control" id="floatingInput" placeholder="Enter Username" required>
                    <label for="floatingInput">Username</label>
                    <div class="invalid-feedback">
                        Please enter your registered username.
>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">
<<<<<<< HEAD
                        Masukan Password.
                    </div>
                </div>
                
=======
                        Please enter your password.
                    </div>
                </div>

>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910
                <!-- Submit Button -->
                <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            </form>
        </div>
    </main>

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
<<<<<<< HEAD
        // Basic client-side validation
=======
        // Client-side validation
>>>>>>> 02823f3267ec4a6b84b38614e9d1ac2ca20f9910
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>
