
<?php
    public function logout(){
        

        global $pdo; 

        // verifies if usr's id exist
        if (is_null($this->id)){
            return;
        }
    }


session_start();
session_destroy(); // finishes the session 
// directs user to home page
header("Location: home.html"); 
exit;