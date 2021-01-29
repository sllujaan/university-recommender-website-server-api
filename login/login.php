<?php

    include_once("../util/header.php");
    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");


    /*make sure that the incoming request is a post request*/
    \UTIL_VALIDATOR\validatePostRequest();

    /*make sure that in the request (user name and password) are present*/
    \LOGIN_VALIDATOR\validateLoginParams();

    /**
     * check if the user exists in the database
     * returns: user id
     */
    $userId = \DATABASE_VALIDATOR\verifyUser($_POST["name"], $_POST["password"]);

    /** 
     * print json on screen that contains session_id and user_id
    */
    echo \SESSION\createNewSession($userId);

?>