<?php
    header("Access-Control-Allow-Origin: *");

    include_once("response.php");
    include_once("../DB/getData.php");

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

    echo \DATABASE_GET_DATA\getCities($_GET['id']);


    sendResponseStatus(200);
    exit();

?>