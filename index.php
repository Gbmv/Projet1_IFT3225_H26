<?php
    require './src/account_class.php';
    require './src/db_inc.php';
    // require instead of include, because not having the sanitization methods may compromise security
    require './src/sanitization.php'; // will sanitize all input from the form

    session_start(); // starts session

    $nameErr = $emailErr = $passwordErr = $msgErr = $success = $success_feedback = "";

    // define variables and set values to empty
    $name = $email = $password = ""; // define variables and set to empty values
    $newId = 0;
    $valid = false;

    // sanitization of the data from the form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // checks for input name errors, sends error message if so
        if (empty($_POST["name"])){
            $nameErr = '<div class="alert alert-danger" role="alert">Name required</div>';
            $valid = false;
        } else {
            $name = clean($_POST["name"]);
            if (!preg_match("/^[a-zA-Z-']*$/", $name)){
                $nameErr = '<div class="alert alert-danger" role="alert">Only letters and white space allowed</div>';
                $valid = false;
            } else {
                $valid = true;
            }
        }
        // checks for input email errors, sends error message if so
        if (empty($_POST["email"])){
            $emailErr = '<div class="alert alert-danger" role="alert">Email required</div>';
            $valid = false;
        }
        else {
            $email = clean($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = '<div class="alert alert-danger" role="alert">Invalid email format</div>';
                $valid = false;
            } else {
                $valid = true;
            }
        }
        // checks if password was typed at all, sends error msg if not
        if (empty($_POST["password"])){
            $passwordErr = '<div class="alert alert-danger" role="alert">Password required</div>';
            $valid = false;
        } else {
            $password = clean($_POST["password"]);
            $valid = true;
        }
    }

    /** AFTER sanitizing it, use account methods to manipulate the data into the accounts table **/

    if ($valid == true){
    // instantiates account class, all values are set null at first
        try {
            $account = new Account();

            // adds new account to the accounts table with the submitted form data. stores account's id inside id
            $account->addAccount($email, $password, $name);


            $success = '<script>console.log("New account created.")</script>';

            // gives feedback to user, indicating account was successfully created and pointing to login page
            $success_feedback = 
            '<div class="alert alert-sucess" role="alert">
                <h4 class="alert-heading">Great news!</h4>
                <p>Your account has been just created, $name</p>
                <hr>
                <p class="mb-0">Now head to to the login page below so you can access the website</p>
                <a href="src/login.php">Sign in</a>
            </div>';

            // after account is created and added to the table, sends user back to login page to login into his account
            /* if ($account) {
                header("Location: src/login.php");
            } */
        } catch(Exception $e){
            //
            $msgErr = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
            die();
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Registering space</title>
</head>
<body class="flex-column min-vh-100" style="background-color:#fff2df">
    <nav class="navbar" style="background-color:#674d3c">
        <div class="container-fluid">
            <!--logo -->
            <a class="navbar-brand">
                <img src="images/logo.png" 
                style="width:80px;" class="img-fluid" alt="logo">
            </a>
        </div>
    </nav>

     <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="images/logo.png" alt="Logo" width="220" class="img-fluid mb-2">
            <h2 class="fw-bold">The Library</h2>
        </div>
    </div>
    
    <!--Register box-->
    <div class="container d-flex align-items-center justify-content-center rounded mb-5" style="width: 70%; min-height: 80vh;background-color:#a2836e">
        <div class= "card shadow-m d-flex m-4" style="width:60%;">
            <div class="card-body mx-auto p-4">
                <h2 class = "text mb-4">Register</h2>
            </div>
            <!--Formulaire d'inscription-->
            <form method="POST" action="" class="needs-validation" novalidate>
                <!--Name input -->
                <div class = "form-floating m-3" style="width: 80%" >
                    <input type="name" class="form-control" name="name" placeholder="Enter your name" required>
                    <label for = "name" class ="form-label">Name</label>
                    <?php echo $nameErr;?>
                </div>
                <!-- Email input -->
                <div class = "form-floating m-3" style="width: 80%">
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    <label for = "email" type="email" class ="form-label">E-mail</label>
                    <?php echo $emailErr;?>
                </div>
                <!-- Password input -->
                <div class = "form-floating m-3" style="width: 80%">
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                    <label for = "password" class = "form-label">Password</label>
                    <?php echo $passwordErr;?>
                </div>
                <!-- Clicking on this button will submit the form -->
                <div class = "m-3">
                    <button class="btn" style="background-color:ffcc5c" type="submit" name="ok">Create account</button>
                </div>

                <!-- Redirects user to login page, if they have an existing account -->
                <div class="text center m-3">
                    <a role="button" href="src/login.php">Already have an account? Click here</a>
                </div>
            </form>
            <div>
                <?php
                    echo $msgErr;
                    echo $success;
                    echo $success_feedback;
                ?>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto py-4 border-top" style="background-color:#674d3c"><p></p></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>