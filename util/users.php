<?php

    include_once("header.php");
    include_once("../DB/getData.php");
    include_once("../util/util.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");



    \UTIL_VALIDATOR\validatePostRequest();

    \UTIL_VALIDATOR\validateAuthParams_BODY();

    \SESSION\validateSession_BODY();
    

    echo \DATABASE_GET_DATA\getUsers();


?>