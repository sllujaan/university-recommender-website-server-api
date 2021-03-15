<?php
    
    include_once("validator.php");
    include_once("../util/header.php");
    include_once("../util/response.php");
    include_once("../util/validator.php");
    include_once("../DB/getData.php");


    /*make sure that the incoming request is a post request*/
    \UTIL_VALIDATOR\validatePostRequest();

    echo \DATABASE_GET_DATA\getRecommendedUniversities($_POST['id']);

?>