<?php 
session_start();
session_detroy(); // finishes the session 
// directs user to home page
header("Location: home.html"); 
exit;