<?php
    
    include_once("../util/header.php");
    include_once("validator.php");
    include_once("../util/session.php");
    include_once("../util/validator.php");
    include_once("../DB/addNewData.php");


    \UTIL_VALIDATOR\validatePostRequest();

    \SESSION\validateSession_POST();

    \CREAT_SEARCH_VALIDATOR\validateCreateSearchParams();

    \DATABASE_ADD_NEW_DATA\createNewSearch($_POST["session_id"]);


?>