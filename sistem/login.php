<?php
// Start the session
session_start();

// Placeholder for message if login fails
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simulate database check (you should replace this with actual database validation)
    if ($username == "your_correct_username" && $password == "your_correct_password") {
        // Set session variables and redirect to the main page
        $_SESSION['username'] = $username;
        header('Location: main.php'); // Redirect to main.php on success
        exit();
    } else {
        // Display error message if login fails
        $message = "Invalid NIM or Password!";
    }
}
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
            <form class="needs-validation" novalidate method="POST" action="main_user.php">
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
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">
                        Masukan Password.
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            </form>
        </div>
    </main>

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Basic client-side validation
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
