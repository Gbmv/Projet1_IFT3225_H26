<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Registering space</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <!--Formulaire d'inscription-->
        <form method="POST" action="data_processing.php">
            <div class="input-group">
                <span class="input-group-text">John Doe</span>
                <input type="text" name="name" class="form-control" placeholder="Enter your name"></input>
            <div class="input-group">
                <span class="input-group-text">johndoe@outlook.com</span>
                <input type="email" name="email" class="form-control" placeholder="Enter your email"></input>
            </div>
            <div class="input-group">
                <span class="input-group-text">johndoe123</span>
                <input type="password" name="pwd" class="form-control" placeholder="Enter your password"></input>
            </div>
            <!-- Clicking on this button will submit the form -->
            <button type="submit" name="ok">Create account</button>
        </form>
        
        <a role="button" href="login.php">Already have an account? Click here</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>