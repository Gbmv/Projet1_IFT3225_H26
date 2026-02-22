<?php

require_once "src/db_inc.php";
require_once "src/book_class.php";
require_once "src/account_class.php";

session_start();

$current_account = new Account;
$current_account->sessionLogin();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$book = new Book($current_account);

// 
echo $book->displayBooks($page);