<?php
    
    include_once("../util/header.php");
    include_once("validator.php");
    include_once("../util/session.php");
    include_once("../util/validator.php");
    include_once("../DB/getData.php");


    \UTIL_VALIDATOR\validatePostRequest();

    /*make sure that user's credentials are present in the request*/
    \UTIL_VALIDATOR\validateAuthParams_POST();

    \SESSION\validateSession_POST();

    echo \DATABASE_GET_DATA\getSavesSearches($_SESSION[$_POST["session_id"]]);


?>