<?php
// Debbuging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db_inc.php';
require_once __DIR__ . '/account_class.php';
require_once __DIR__ . '/book_class.php';


session_start();

// If we don't have a book id or if the request method is not POST, we redirect to home page
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['book_id'])) {
    header('Location: ../home.php');
    exit();
}

try{

    // We instantiate the book class to be able to call the delete book function
    $account = new Account();
    $bookObj = new Book($account);


    // We call our fonction to delete the book with the id we got from the form
    $bookObj->deleteBook($_POST['book_id']);
    // We redirect to home page
    header('Location: ../home.php');
    exit();
}catch (Throwable $e) {
    echo "<pre>$e</pre>";
} 
