<?php 
    $servername = "localhost";
    $username = "user";
    $password = "pwd";
    $dbname = "tp1-ift3225";

    // PDO object
    $pdo = NULL;

    try {
        // PDO object creation
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // sets pdo error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected sucessfuly";

    } catch(PDOException $e){
        echo 'Database connection failed' . $e->getMessage();
        die();
    }

// connection string 