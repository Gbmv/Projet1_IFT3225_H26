<!-- Code inspiré par w3schools: Bootstrap / PHP -->

<?php

//Debbugging: displays all errors and warnings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// __DIR__ returns the absolute path of the current file's directory.
require_once(__DIR__ . '/src/db_inc.php');
require_once(__DIR__ . '/src/account_class.php');
require_once(__DIR__ . '/src/book_class.php');


session_start();    

$account = new Account();
$book = new Book($account);



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
                        <a class="nav-link" href="src/logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="src/edit_account.php">Modify Account</a>
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
                        <!--Submits delete account form by pressing the button-->
                        <form action="src/delete_account.php" method="POST">
                            <button class="btn btn-danger shadow-sm w-75" type="button" name="delete" id="delete_account">Delete account</button>
                        </form>
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

    <!-- Library: Grid of book tiles -->
    <div class="container my-5">
        <div class="row g-5 justify-content-center">
            <?php


            $account = new Account();
            $book = new Book($account);
            // // Test of an imaginary book, to see if the cards are well displayed.
          
            // // Crets the book teste
            // $bookObj->addBook("Book Teste", "Author Test", "Fantasy");

            // We call the displayBooks function to display all the books of the user in the form of cards
            echo $book->displayBooks();
           

            ?>

            <!--Tile button: creates a new book card-->
            <div class="col-12 col-md-3 d-grid justify-content-center">
                <!--Clicking the button will activate a modal containing the form-->
                <button class="btn p-0 border-0 bg-transparent" type="button" data-bs-toggle="modal" data-bs-target="#add_book">
                    <img class="card-img img-fluid" style="width:70%" src="./images/plus_button2.png">
                </button>
            </div>

            <!-- Modal: Add a book -->
            <div class="container">
                <div class="modal fade" role="dialog" id="add_book">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="font-family:Georgia, serif">Add a book</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="form-floating mb-3 mt-3">
                                    <!--Form contains book title, author and category-->
                                    <form method="POST" action="">
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="title" class="form-control" placeholder="Title" name="title" required>
                                            <label for="title" class="form-label" style="font-family:Georgia, serif">Title</label>
                                        </div>
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="author" class="form-control" placeholder="Author" name="author" required>
                                            <label for="author" class="form-label" style="font-family:Georgia, serif">Author</label>
                                        </div>
                                        <!--Categories menu-->
                                        <label class="form-label p-2" for="categories" style="font-family:'Georgia, serif'; color:#2B1A12" >Category</label>
                                        <select class="form_select" style="color:#2B1A12; background-color:#fff2df; border-color:#C9A24D; font-family:'Georgia, serif'" name="categories" id="categories">
                                            <option></option>
                                            <option name="Action">Action</option>
                                            <option name="Adventure">Adventure</option>
                                            <option name="Romance">Romance</option>
                                            <option name="Religion">Religions</option>
                                            <option name="Horror">Horror</option>
                                            <option name="Sciences">Sciences</option>
                                            <option name="History">History</option>
                                            <option name="Biography">Biography</option>
                                            <option name="Fantasy">Fantasy</option>
                                            <option name="SciFi">SciFi</option>
                                            <option name="Philosophy">Philosophy</option>
                                            <option name="Other">Other</option>
                                        </select>

                                    </form>
                                </div>
                                
                                <button class="btn shadow-sm w-75" type="button" style="background-color:#8C4F2C; color: F3E7D3; border-color:#C9A24D; font-family:Georgia, serif" id="delete_account">Add</button>
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