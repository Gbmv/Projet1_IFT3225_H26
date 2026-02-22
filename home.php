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
require_once(__DIR__ . '/src/sanitization.php');


session_start();

// instantiates account and logs into it
$current_account = new Account;
$current_account->sessionLogin();

/* Adding books logic */
// first sanitize data
$titleErr = $authorErr = $categoryErr = $msgErr = $success = $success_feedback = "";

// define variables and set values to empty
$title = $author = $category = ""; // define variables and set to empty values
$newId = 0;
$valid = false;
// sanitization of the data from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // checks for input name errors, sends error message if so
    if (empty($_POST["title"])) {
        $titleErr = '<div class="alert alert-danger" role="alert">Title required</div>';
        $valid = false;
    } else {
        // cleans and capitalizes title input
        $title = clean($_POST["title"]);
        $title = ucwords($title);
        $valid = true;
    }

    // checks for input email errors, sends error message if so
    if (empty($_POST["author"])) {
        $authorErr = '<div class="alert alert-danger" role="alert">Author required</div>';
        $valid = false;
    } else {
        // cleans and capitalizes author input
        $author = clean($_POST["author"]);
        $author = ucwords($author);
        $valid = true;
    }
    // checks if password was typed at all, sends error msg if not
    if (empty($_POST["categories"])) {
        $categoryErr = '<div class="alert alert-danger" role="alert">Category required</div>';
        $valid = false;
    } else {
        // cleans and capitalizes category input
        $category = clean($_POST["categories"]);
        $valid = true;
    }
}

/** AFTER sanitizing it, adds book to the books table*/
if ($valid == true) {
    try {
        // instatiates new book object with account as an argument
        $book = new Book($current_account);
        // Try to add the book to the user's book table
        $book->addBook($title, $author, $category);

        // If successful, displays new book in the book tiles grid

        // If there is an error, catch it and display the message
    } catch (Exception $e) {
        $msgErr = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
    }
}

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
                <img src="<?php echo BASE_URL; ?>images/logo.png"
                    style="width:80px;" class="img-fluid" alt="logo">
            </a>

            <div class="nav-item me-auto" style="color:#C9A24D">
                <p>Hey, <?php echo htmlspecialchars($current_account->getName() ?? ''); ?>!</p>
                <p><?php echo htmlspecialchars($current_account->getEmail() ?? ''); ?></p>
            </div>
            <!-- toggler button shows/hides navbar features-->
            <button
                class="navbar-toggler"
                style="background-color:#C9A24D"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavbar">

                <img src="<?php echo BASE_URL; ?>images/person-gear.svg" class="img-fluid"
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
                        <form action="./src/delete_account.php" method="POST">
                            <button class="btn btn-danger shadow-sm w-75" type="submit" name="delete" id="delete_account">Delete account</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h6>Edit Account</h6>
                        <form>
                            <!-- New name -->
                            <div class="form-floating mb-3">
                                <input type="text" id="new_name" placeholder="Enter new name" name="new_name"></input>
                                <label for="new_name">Choose New Name</label>
                            </div>
                            <!-- New email -->
                            <div class="form-floating mb-3">
                                <input type="text" id="new_email" placeholder="Enter new email" name="new_email"></input>
                                <label for="new_email">Choose New Email</label>
                            </div>
                            <!-- New password -->
                            <div class="form-floating mb-3">
                                <input type="text" id="new_password" placeholder="Enter new password" name="new_password"></input>
                                <label for="new_password">Choose New Password</label>
                            </div>

                            <button class="btn btn-danger shadow-sm w-75" type="submit" id="modify_account">Modify account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Logo-->
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-4">
            <img src="<?php echo BASE_URL; ?>images/logo.png" alt="Logo" width="200" class="img-fluid mb-2">
            <h2 class="fw-bold" style="font-family:Georgia, sans">The Library</h2>
        </div>
    </div>

    <!-- Library: Grid of book tiles -->
    <div class="container my-5">
        <div class="row g-5 justify-content-center">

            <!-- Contains all books from book's table that was fetched from db AND add book button-->
            <div class="row g-5 justify-content-center" id="books_grid"></div>


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
                                        <label class="form-label p-2" for="categories" style="font-family:'Georgia, serif'; color:#2B1A12">Category</label>
                                        <select class="form_select" style="color:#2B1A12; background-color:#fff2df; border-color:#C9A24D; font-family:'Georgia, serif'" name="categories" id="categories">
                                            <option></option>
                                            <option value="Action">Action</option>
                                            <option value="Adventure">Adventure</option>
                                            <option value="Romance">Romance</option>
                                            <option value="Religion">Religions</option>
                                            <option value="Horror">Horror</option>
                                            <option value="Sciences">Sciences</option>
                                            <option value="History">History</option>
                                            <option value="Biography">Biography</option>
                                            <option value="Fantasy">Fantasy</option>
                                            <option value="SciFi">SciFi</option>
                                            <option value="Philosophy">SciFi</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <!--Button : adds book to user's book table by submitting form-->
                                        <button class="btn shadow-sm w-75" type="submit" style="background-color:#8C4F2C; color: F3E7D3; border-color:#C9A24D; font-family:Georgia, serif" id="add_book" data-bs-dismiss="modal">Add</button>
                                    </form>
                                </div>
                                <?php
                                echo $titleErr;
                                echo $authorErr;
                                echo $categoryErr;
                                ?>
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
            <?php
            // makes sure we have a page number to be compared
            $current_p = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            // creates an array to the pages 1 to 5 (could be more, but for thiss project, will be 5)
            for ($i = 1; $i <= 5; $i++):
                // colors logic, if its the current page, highlights hte page number
                $bg = ($current_p == $i) ? "#C9A24D" : "#2B1A12";
                $color = ($current_p == $i) ? "#2B1A12" : "#C9A24D";
                $border = ($current_p == $i) ? "#2B1A12" : "#C9A24D";
            ?>
            <li class="page-item">
                <a class="page-link"
                    style="background-color:<?php echo $bg; ?>; color:<?php echo $color; ?>; border-color:<?php echo $border; ?> !important;"
                    href="?page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>


    <!-- Footer -->
    <footer class="footer mt-auto py-4 border-top" style="background-color:#2B1A12">
        <p></p>
    </footer>

    <!--Bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script>
        // fetch runs since page is opened
        document.addEventListener("DOMContentLoaded", function() {
            //calls first page automatically    
            loadPage(1);
        })

        // loads pages
        function loadPage(pageNumber) {
            // fetch will go to the php file without reloading the page
            fetch(<?php echo BASE_URL ?> 'get_books.php?page=' + pageNumber)
                .then(response => {
                    if (!response.ok) throw new Error('Page not found');
                    return response.text();
                })
                .then(html => {
                    // retrieves books_grid container
                    const container = document.getElementById('books_grid');
                    // adds html inside of it (the books grid we created in displayBooks)
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error('Loading : ', error)
                    document.getElementById('books_grid').innerHTML = "Error loading books";
                });
        }
    </script>
</body>

</html>