<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap css stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h1>Sign In</h1>

    <div class="container">
        <h1>Register</h1>
        <!--Formulaire d'inscription-->
        <form method="POST">
            <label>Email
                <input type="email" class="form-control" placeholder="Enter your email"></input>
            </label>
            <label>Password
                <input type="password" class="form-control" placeholder="Enter your password"></input>
            </label>
            <button>Connect</button>
        </form>
        
        <a role="button" href="login.php">Create an account</a>
        <a role="button" href="login.php">Already have an account? Click here to sign in</a>

        <button>Login</button>
        <a class="" role="button" href="register.php">Don't have an account? Click here to register</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>