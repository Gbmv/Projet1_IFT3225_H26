<?php 

    /* Sanitizes all input */

    // sanitizes a string, trimming, removing slashes and preventing js injections
    function clean($data):string {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>