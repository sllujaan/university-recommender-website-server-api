<?php
    include_once("credential.php");
    include_once("../util/response.php");

    // Report all errors except E_WARNING
    error_reporting(E_ALL & ~E_WARNING);
    
    /**
     * create a new connection with database.
     * return the connection instance.
     */
    function initConnection() {
        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        // Check connection
        if ($mysqli->connect_errno) {
            sendResponseStatus(500);
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }     
        return $mysqli;
    }

?>