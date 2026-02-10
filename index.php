<!-- Code inspiré par w3schools: Bootstrap / PHP -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap css stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

    <!-- navbar-->
    <nav class="navbar bg-light navbar-light sticky-top ">
        <div class="container-fluid">
            <!--logo -->
            <a class="navbar-brand">
                <img src="images/logo.png" 
                style="width:80px;" class="img-fluid" alt="logo">
            </a>

            <!-- toggler button shows/hides navbar features-->
            <button 
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavbar">
                <img src="images/person-gear.svg" class="img-fluid"
                    alt="user adjusts icon"
                    style="width:40px">
            </button>
            <!-- navbar features div-->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item" href="edit_account.php">Modify Account</a>
                    </li>
                    <li>
                        <a class="nav-item" href="delete_account.php">Delete Account</a>
                    </li>
                    <li><a class="dropdown-item" href="#">Other</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="images/logo.png" alt="Logo" width="200" class="img-fluid mb-2">
            <h2 class="fw-bold">The Library</h2>
        </div>
    </div>

    <!-- Assim vamos fazer os cards (tuiles)
        - Os cards vao ficar dentro de um container que vai organizá-los
        - cada card é um div de tipo card e possui um div de tipo card-body

        exemplo:
    -->
    <div class="container- row p-4 col-10 mx-auto" label="card-container" >
        <!-- one card -->
        <div class="card col">
            <div class="card-header">Name and author's name</div>
            <div class="card-body">
                <h4 class="card-title">
                    Description:</h4>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis harum ipsa iure eveniet temporibus velit modi aliquid libero, illo natus adipisci ut saepe nostrum, voluptatem perferendis accusamus placeat incidunt vitae.</p>
            </div>
            <div class="card-footer">Delete</div>
        </div>
        <!-- second card-->
         <div class="card col">
            <div class="card-header">Name and author's name</div>
            <div class="card-body">
                <h4 class="card-title">
                    Description:</h4>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis harum ipsa iure eveniet temporibus velit modi aliquid libero, illo natus adipisci ut saepe nostrum, voluptatem perferendis accusamus placeat incidunt vitae.</p>
            </div>
            <div class="card-footer">Delete</div>
        </div>
        <!-- third card -->
        <div class="card col">
            <div class="card-header">Name and author's name</div>
            <div class="card-body">
                <h4 class="card-title">
                    Description:</h4>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis harum ipsa iure eveniet temporibus velit modi aliquid libero, illo natus adipisci ut saepe nostrum, voluptatem perferendis accusamus placeat incidunt vitae.</p>
            </div>
            <div class="card-footer">Delete</div>
        </div>
        <div class="card w-100">
            <div class="card-header">Name and author's name</div>
            <div class="card-body">
                <h4 class="card-title">
                    Description:</h4>
                <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis harum ipsa iure eveniet temporibus velit modi aliquid libero, illo natus adipisci ut saepe nostrum, voluptatem perferendis accusamus placeat incidunt vitae.</p>
            </div>
            <div class="card-footer">Delete</div>
        </div>
    </div>
    
    <!-- pagination -->
    <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
    
    <!-- aqui colocamos um container normal .container -->

    <!--Bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>
</html>