<!-- Code inspiré par w3schools: Bootstrap / PHP -->

<?php

require "db_inc.php";
require "book_class";

session_start();

// card template
$card =
    '<div class="col-12 col-md-3">
        <div class="card h-100" style="background-color:#5A3422;">
            <div class="card-header text-center">
                <h4 style="color:#C9A24D; font-family:Georgia, serif;">Book name</h4>
            </div>
            <img class="card-img-top" src="./images/book_bg_2.png" alt="Card image">
            <div class="card-body">
                <p style="color: #F3E7D3">Author name</p>
            </div>
            <div class="card-footer" style="border-top-color:#8C4F2C">
                <button class="btn" type="button">
                    <img src="./images/delete_icon.svg" class="img-fluid" style="width:30px;" alt="remove">
                </button>
            </div>  
        </div>
    </div>';

// book card logic




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap css stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="flex-column min-vh-100" style="background-color:#fff2df">

    <!-- navbar-->
    <nav class="navbar sticky-top" style="background-color:#2B1A12">
        <div class="container-fluid">
            <!--logo -->
            <a class="navbar-brand">
                <img src="images/logo.png"
                    style="width:80px;" class="img-fluid" alt="logo">
            </a>

            <!-- toggler button shows/hides navbar features-->
            <button
                class="navbar-toggler"
                style="background-color:#C9A24D"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavbar">

                <img src="images/person-gear.svg" class="img-fluid"
                    alt="user adjusts icon"
                    style="width:40px">
            </button>
            <!-- navbar features div-->
            <div class="collapse navbar-collapse navbar navbar-dark" id="collapsibleNavbar">
                <ul class="navbar-nav" style="color:#C9A24D">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit_account.php">Modify Account</a>

                    </li>
                    <li class="nav-item">
                        <!-- Triggers modal to confirm if user wants to delete their account-->
                        <button class="btn nav-link" type="button" data-bs-toggle="modal" data-bs-target="#delete_confirmation">Delete Account</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal for account deletion-->
    <div class="container">
        <div class="modal fade" role="dialog" id="delete_confirmation">
            <div class="modal-dialog modal-dialog-centered">
                <!--Modal-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title alert alert-danger">Attention!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>You're about to delete this account</p>
                        <button class="btn btn-danger shadow-sm w-75" type="button" id="delete_account">Delete account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for account modification -->
    <div class="container">
        <div class="modal fade" role="dialog" id="account_modification">
            <div class="modal-dialog modal-dialog-centered">
                <!--Modal-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title alert alert-danger">Attention!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>You're about to delete this account</p>
                        <button class="btn btn-danger shadow-sm w-75" type="button" id="delete_account">Delete account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="images/logo.png" alt="Logo" width="200" class="img-fluid mb-2">
            <h2 class="fw-bold" style="font-family:Georgia, sans">The Library</h2>
        </div>
    </div>

    <!-- Assim vamos fazer os cards (tuiles)
        - Os cards vao ficar dentro de um container que vai organizá-los
        - cada card é um div de tipo card e possui um div de tipo card-body

        exemplo:
    -->
    <div class="container my-5">
        <div class="row g-5 justify-content-center">
            <?php
            echo $card;
            echo $card;
            echo $card;
            ?>

            <!--Tile button: creates a new book card-->
            <div class="col-12 col-md-3 d-grid justify-content-center">
                <!--Clicking the button will activate a modal containing the form-->
                <button class="btn p-0 border-0 bg-transparent">
                    <img class="card-img img-fluid" src="./images/plus_button2.png">
                </button>
            </div>

            <div class="container">
                <div class="modal fade" role="dialog" id="add_book">
                    <div class="modal-dialog modal-dialog-centered">
                        <!--Modal-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add a book</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="form-floating mb-3 mt-3">
                                    <form method="POST" action="">
                                        <input type="">Book name</input>
                                        <input>Author</input>
                                    </form>
                                </div>
                                
                                <button class="btn btn-danger shadow-sm w-75" type="button" id="delete_account">Delete account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- pagination -->
    <div class="container">
        <ul class="pagination mx-auto justify-content-center" style="width:fit-content;">
            <li class="page-item"><a class="page-link" style="background-color:#2B1A12; color:#C9A24D; border-color:#C9A24D !important" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" style="background-color:#2B1A12; color:#C9A24D; border-color:#C9A24D !important" href="#">1</a></li>
            <li class="page-item"><a class="page-link" style="background-color:#2B1A12; color:#C9A24D; border-color:#C9A24D !important" href="#">2</a></li>
            <li class="page-item"><a class="page-link" style="background-color:#2B1A12; color:#C9A24D; border-color:#C9A24D !important" href="#">3</a></li>
            <li class="page-item"><a class="page-link" style="background-color:#2B1A12; color:#C9A24D; border-color:#C9A24D !important" href="#">Next</a></li>
        </ul>
    </div>


    <!-- Footer -->
    <footer class="footer mt-auto py-4 border-top" style="background-color:#2B1A12">
        <p></p>
    </footer>

    <!--Bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>