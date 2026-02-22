<?php 
    $servername = "localhost";
    $username = "root";
    $dbname = "tp1-ift3225";
    $password = "root";

    
    // PDO object
    $pdo = NULL;

    // tries to stablish connection to database, sends message to console to confirm it
    try {
        // PDO object creation
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // sets pdo error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<script>console.log('Connected successfully to database');</script>";

    } catch(PDOException $e){
        // prints error message if connection failed
        echo 'Database connection failed' . $e->getMessage();
        die();
    }

    

    // makes sure base_url is not declared twice
    if (!defined('BASE_URL')) {
   // grabs root path from project 
    define('BASE_URL', `/Projet1_IFT3225_H26/`);
}