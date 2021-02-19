<?php

    namespace ACCEPT_REQUEST;
    include_once("../util/header.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("validator.php");
    include_once("../DB/addNewData.php");

    /*make sure that the incoming request is a post request*/
    \UTIL_VALIDATOR\validatePostRequest();
    
    /*make sure that in the request all the necessary data for new user is present*/
    \REQUEST_VALIDATOR\validateRequestAcceptParams_POST();

    /*make sure that user's credentials are present in the request*/
    \UTIL_VALIDATOR\validateAuthParams_POST();

    /*make sure that the session exists for the incoming user's request*/
    \SESSION\validateSession_POST();

    \DATABASE_ADD_NEW_DATA\RejectRequest($_POST["user_id_requested"]);

?>