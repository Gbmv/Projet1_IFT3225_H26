<?php
    require './src/account_class.php';
    // require instead of include, because not having the sanitization methods may compromise security
    require './src/sanitization.php'; // will sanitize all input from the form

    session_start(); // starts session

    $nameErr = $emailErr = $passwordErr = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Registering space</title>
</head>
<body>
     <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="images/logo.png" alt="Logo" width="300" class="img-fluid mb-2">
            <h2 class="fw-bold">The Library</h2>
        </div>
    </div>
    <!--Register box-->
    <div class="container d-flex align-items-center justify-content-center " style="min-height: 100vh;">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class= "card shadow-sm" style="width: 100%; width: 100%;">
            <div class="card-body mx-auto p-4">
                <h2 class = "text mb-4">Register</h2>
    </div>
        <!--Formulaire d'inscription-->
        <form method="POST" action="register.php">
            <!--Name input -->
            <div class = "m-3">
                <label for = "name" class ="form-label">Name</label>
                <input type="name" class="form-control" name="name" placeholder="Enter your name" required>
                <span class="error">*<?php echo $nameErr; ?></span>
            </div>
            <!-- Email input -->
            <div class = "m-3">
                <label for = "email" class ="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                <span class="error">*<?php echo $emailErr; ?></span>

            </div>

            <!-- Password input -->
            <div class = "m-3">
                <label for = "password" class = "form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                <span class="error">*<?php echo $passwordErr; ?></span>
            </div>
             <!-- Clicking on this button will submit the form -->
            <div class = "m-3">
                <button type="submit" name="ok">Create account</button>
            </div>

            <!-- Redirects user to login page, if they have an existing account -->
             <div class="text center m-3">
                <a role="button" href="src/login.php">Already have an account? Click here</a>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

<?php 

    // define variables and set values to empty
    $name = $email = $password = ""; // define variables and set to empty values
    $id = 0;

    // sanitization of the data from the form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // checks for input name errors, sends error message if so
        if (empty($_POST["name"])){
            $nameErr = "Name required";
        } else {
            $name = clean($_POST["name"]);
            if (!preg_match("/^[a-zA-Z-']*$/", $name)){
                $nameErr = "Only letters and white space allowed";
            }
        }
        // checks for input email errors, sends error message if so
        if (empty($_POST["email"])){
            $emailErr = "Email required";
        }
        else {
            $email = clean($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "Invalid email format";
            }   
        }
        // checks if password was typed at all, sends error msg if not
        if (empty($_POST["password"])){
            $passwordErr = "Password required";
        } else {
            $password = clean($_POST["password"]);
        }
    }
    /** AFTER sanitizing, use account methods to manipulate the data into the accounts table **/

    // instantiates account class, all values are set null at first
    $account = new Account();
    

    // adds new account to the accounts table with the submitted form data. stores account's id inside id
    //$account->addAccount($email, $password, $name);

    // after account is created and added to the table, sends user back to login page to login into his account
    /*if ($account) {
        header("Location: src/login.php");
    }
        */
?>