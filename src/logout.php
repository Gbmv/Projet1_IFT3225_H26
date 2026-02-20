<?php
session_start();
session_destroy(); // finishes the session 
// directs user to home page
header("Location: ../index.php"); 
exit;
?>
