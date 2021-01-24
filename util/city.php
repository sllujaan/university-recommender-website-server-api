<?php

    include_once("response.php");


    if(!isset($_GET['id'])) {
        //no id found in url
        sendResponseStatus(400);
        echo "No id found in URL";
        exit();
    }

    if(filter_var($_GET['id'], FILTER_VALIDATE_INT) === false) {
        sendResponseStatus(400);
        echo "Invalid id in URL";
        exit();
    }

    


    sendResponseStatus(200);
    exit();

?>