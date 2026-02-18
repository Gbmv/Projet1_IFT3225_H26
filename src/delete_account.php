<?php
session_start();

require_once "db_inc.php";
require_once "account_class.php";

// instantiates account object
$account = new Account();
$account_id = $account->getAccountIdFromActiveSession();
echo "<p>" . $account_id . "</p>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // tries to delete account and stores bool value if so
    $deleted = $account->deleteAccount($account_id);

    // after account is deleted, sends back to login page
    if ($deleted) {
        session_abort();
        sleep(3);
        header('Location: ./index.php');
    }
}
