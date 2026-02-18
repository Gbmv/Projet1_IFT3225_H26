<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// start the session
session_start();
require "src/db_inc.php";
require "src/account_class.php";

$error = '';

// Verify if it was posted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $account = new Account();

        //Try login
        if ($account->login($email, $password)) {
            // 
            $account->sessionLogin();
            //Sucessful login, redirect to home page
            header('Location: ./home.php');
            exit();
        } else {
            //Login failed, show error message
            $error = 'Invalid email or password';
        }
    } catch (Exception $e) {
        $error = "Error in the system " . $e->getMessage();
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap css stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="flex-column min-vh-100" style="background-color:#fff2df">


    <!--Navbar-->
    <nav class="navbar" style="background-color:#674d3c">
        <div class="container-fluid">
            <!--logo -->
            <a class="navbar-brand">
                <img src="./images/logo.png"
                    style="width:80px;" class="img-fluid" alt="logo">
            </a>
        </div>
    </nav>

    <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="./images/logo.png" alt="Logo" width="300" class="img-fluid mb-2">
            <h2 class="fw-bold">The Library</h2>
        </div>
    </div>


    <div class="container d-flex flex-column align-items-center justify-content-center rounded mb-5" style="width: 50%; min-height: 80vh;background-color:#a2836e">
        <div class="card shadow m-4" style="width:70%;">
            <div class="card-body p-4">
                <h2 class="text-center mb-4">Sign in</h2>
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger text-center">
                        <strong>Atenção:</strong> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <!--Formulaire de connexion-->
                <form method="POST" action="">
                    <!-- email -->
                    <div class="form-floating mb-3" style="width: 100%">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        <label for="email" class="form-label">E-mail</label>
                    </div>
                    <!-- password -->
                    <div class="form-floating mb-3" style="width: 100%">
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <label for="password" class="form-label">Password</label>
                    </div>

                    <!--Sign in button-->
                    <div class="d-grid mb-3">
                        <button class="btn shadow-sm" style="background-color:ffcc5c" type="submit" name="ok" type="submit">Sign in</button>
                    </div>

                    <!--Link to create an account-->
                    <div class="text-center m-3">
                        <a class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover mb-3" role="button" href="./register.php">Don't have an account? Click here to register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>


    <footer class="footer mt-auto py-4 border-top" style="background-color:#674d3c">
        <p></p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>