<?php
    
    include_once("header.php");
    include_once("response.php");
    include_once("../DB/getData.php");

    echo \DATABASE_GET_DATA\getCountries();

    sendResponseStatus(200);
    exit();

?>