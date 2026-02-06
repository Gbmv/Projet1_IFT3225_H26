<?php 
    // configure la 
    $username = "root";
    $password = "root";
    $server = "localhost";    

// instatiates the database
try {
    $db = new PDO("mysql:host=$server; dbname=tp1_users", $username, $password);
    $db-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    } catch (PDOException $e) {
        // sends error message if an error occurs
        echo "ERROR: ". $e->getMessage();
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>