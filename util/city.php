<?php
    
    include_once("header.php");
    include_once("response.php");
    include_once("../DB/getData.php");


    /**
     * checks if country id is present in the request.
     */
    if(!isset($_GET['id'])) {
        //no id found in url
        sendResponseStatus(400);
        echo "No id found in URL";
        exit();
    }

    /**
     * checks if the country id in the request is a number.
     */
    if(filter_var($_GET['id'], FILTER_VALIDATE_INT) === false) {
        sendResponseStatus(400);
        echo "Invalid id in URL";
        exit();
    }


    /**
     * retrive the cities from the country id and print as json.
     */
    echo \DATABASE_GET_DATA\getCities($_GET['id']);

?>