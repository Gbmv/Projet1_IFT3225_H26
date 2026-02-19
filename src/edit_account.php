<?php

// Debbuging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db_inc.php';
require_once __DIR__ . '/account_class.php';
require_once __DIR__ . '/book_class.php';

session_start();
$error = '';
$success = '';

$account = new Account();


// If doesn't have an or the account it's not athenticated goes to the login page
if(!$account->sessionLogin() || !$account->isAuthenticated()){
    header('Location: login.php');
    exit;
}

// Get the informations of the user
$accountId = (int)$account->getId();
$emailInfo = $account->getEmail();

// Took the new values of the user
if($_SERVER['REQUEST_METHOD']==='POST'){
    $newName = $_POST['name']??'';
    $newEmail = $_POST['email']??'';
    $newPassword = $_POST['password']??'';
    try{
// Calls the function that changes the informations of the user
$account->editAccount($accountId, $newEmail, $newPassword,$newName);

//Updates the email of the user in the page 
$emailInfo = $newEmail;

$success = 'Account updated';

header('Location: ../home.php');
exit;

}catch (Exception $e) {
        $error = "Error in the system " . $e->getMessage();
        }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit login</title>
    <!-- Bootstrap css stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="flex-column min-vh-100" style="background-color:#fff2df">


    <!--Navbar-->
    <nav class="navbar" style="background-color:#674d3c">
        <div class="container-fluid">
            <!--logo -->
            <a class="navbar-brand">
                <img src="../images/logo.png"
                    style="width:80px;" class="img-fluid" alt="logo">
            </a>
        </div>
    </nav>

    <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="../images/logo.png" alt="Logo" width="300" class="img-fluid mb-2">
            <h2 class="fw-bold">The Library</h2>
        </div>
    </div>


    <div class="container d-flex flex-column align-items-center justify-content-center rounded mb-5" style="width: 50%; min-height: 80vh;background-color:#a2836e">
        <div class= "card shadow m-4" style="width:70%;">
            <div class="card-body p-4">
                <h2 class="text-center mb-4">Modify account</h2>


                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger text-center">
                        <strong>Atenção:</strong> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

            
                <!--Formulaire de connexion-->
                <form method="POST">

                    <div class="form-floating mb-3" style="width: 100%">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                        <label for="name" class="form-label">Modify name</label>
                    </div>

                    <div class="form-floating mb-3" style="width: 100%">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        <label for="email" class="form-label">Modify e-mail</label>
                    </div>

                    <div class = "form-floating mb-3" style="width: 100%">
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <label for="password" class="form-label">Modify password</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button class="btn shadow-sm" style="background-color:ffcc5c" type="submit" name="ok" type="submit" >Confirm</button>
                    </div>
                </form>
                 <div class="text-center">
                    <a href="../home.php">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-4 border-top" style="background-color:#674d3c"><p></p></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>