<?php
    
    include_once("../util/header.php");
    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../DB/getData.php");


    \UTIL_VALIDATOR\validatePostRequest();

    \CREAT_SEARCH_VALIDATOR\validateSearchParams();

    \DATABASE_GET_DATA\performUniversitySerach();


?>