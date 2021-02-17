<?php

    include_once("header.php");
    include_once("../DB/getData.php");
    include_once("util.php");



    /**
     * checks if country page is present in the request.
     */
    if(!isset($_GET['page'])) {
        //no page found in url
        sendResponseStatus(400);
        echo "No id found in URL.";
        exit();
    }

    /**
     * checks if the country page in the request is a number.
     */
    if(filter_var($_GET['page'], FILTER_VALIDATE_INT) === false) {
        sendResponseStatus(400);
        echo "Invalid page in URL.";
        exit();
    }

    /**
     * check valid values i.e negative values
     */
    if($_GET['page'] < 1) {
        sendResponseStatus(400);
        echo "Invalid page range.";
        exit();
    }


    $limit = \UTIL\generateLimitFromPageNumber($_GET['page']);

    /**
     * retrive users from the database and print as json.
     */
    echo \DATABASE_GET_DATA\getUniversities($limit);

    


?>