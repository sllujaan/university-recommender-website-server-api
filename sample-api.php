<?php

    //include("./util.php");

    function sendResponseStatus($statusCode) {
        $sapitype = php_sapi_name();
        if (substr($sapitype, 0, 3) == 'cgi')
            return header("Status: " . $statusCode); 
        else
            return header("HTTP/1.1 " . $statusCode);
    }

    // $sapitype = php_sapi_name();
    // if (substr($sapitype, 0, 3) == 'cgi')
    //     header("Status: 404"); 
    // else
    //     header("HTTP/1.1 404");


    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //echo "hello post";

        echo $_POST["name"];
        // if(!empty($_POST["name"])) {
        //     echo "hello " . $_POST["name"];
        // }
        // else {
        //     echo "hello guest";
        // }
    }
    else {
        if(!empty($_GET["name"])) {
            echo "hello " . $_GET["name"];
        }
        else {
            echo "hello stranger.";
        }
    }

    

    

    // sendResponseStatus(400);
    // echo "1234";

    //echo "HTTP/1.1 " . 404

?>