<?php
    require "db_inc.php";
    require "account_class.php";

    // instantiates account object
    $account = new Account(); 
    $account_id = $account->getAccountIdFromActiveSession();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        try {
            // tries to delete account and stores bool value if so
            $deleted = $account->deleteAccount($account_id);
            
            if ($deleted){
                echo '
                    <p style="color:red;">Your account has been deleted</p>
                ';
                header('Location: ');
            }
            


        } catch(PDOException $e){
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
?>