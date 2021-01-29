<?php

    include_once("header.php");
    include_once("response.php");
    include_once("../DB/getData.php");
    include_once("../util/util.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");

    /*make sure that the incoming request is a post request*/
    \UTIL_VALIDATOR\validatePostRequest();

    /*make sure that user's credentials are present in the request*/
    \UTIL_VALIDATOR\validateAuthParams_POST();

    /*make sure that the session exists for the incoming user's request*/
    \SESSION\validateSession_POST();

    /**
     * retrive users from the database and print as json.
     */
    echo \DATABASE_GET_DATA\getUsers();

?>