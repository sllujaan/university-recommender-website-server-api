<?php

    include_once("header.php");
    include_once("../DB/getData.php");
    include_once("util.php");



    \UTIL\validatePageNumberURL();


    $limit = \UTIL\generateLimitFromPageNumber($_GET['page']);

    /**
     * retrive users from the database and print as json.
     */
    echo \DATABASE_GET_DATA\getUniversities($limit);

    


?>