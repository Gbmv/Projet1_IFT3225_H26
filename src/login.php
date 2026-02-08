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
    
    <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="../images/logo.png" alt="Logo" width="300" class="img-fluid mb-2">
            <h2 class="fw-bold">The Library</h2>
        </div>
    </div>
    
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class= "card shadow-sm" style="width: 400px; width: 100%;">
            <div class="card-body p-4">
                <h2 class = "text center mb-4">Sing-in</h2>
    </div>
    
    <!--Formulaire de connexion-->            
    <form method = "POST">
        <div class = "m-3">
            <label for = "email" class ="form-label">E-mail</label>
            <input type="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class = "m-3">
            <label for = "password" class = "form-label">Password</label>
            <input type="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <a class="d-block m-3" href="#">Forgot password?</a>

        <div class= "dgrid btn sm " >
            <button type="submit" class="btn btn-primary ">Login</button>
        </div> 


        <div class="text center m-3">
            <a class="mb-3" role="button" href="register.php">Don't have an account? Click here to register</a>
        </div>


    </form>    
    
    



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>