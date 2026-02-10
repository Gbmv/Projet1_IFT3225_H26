<?php 
    $servername = "localhost";
    $username = "root";
    $dbname = "tp1-ift3225";

    // PDO object
    $pdo = NULL;

    /* helper function to write to console */
    // Source - https://stackoverflow.com/a/20147885
    // Posted by Senador
    // Retrieved 2026-02-10, License - CC BY-SA 4.0
    /*
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }*/

    // tries to stablish connection to database, sends message to console to confirm it
    try {
        // PDO object creation
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username);
        // sets pdo error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<script>console.log('Connected successfully to database');</script>";

    } catch(PDOException $e){
        // prints error message if connection failed
        echo 'Database connection failed' . $e->getMessage();
        die();
    }

// connection string 