<?php


    include_once("../util/header.php");
    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/addNewData.php");

    /*make sure that the incoming request is a post request*/
    \UTIL_VALIDATOR\validatePostRequest();
    
    /*make sure that in the request all the necessary data for new user is present*/
    \REGISTER_VALIDATOR\validateRegisterParams();

    /*add the new user data in the database*/
    //\DATABASE_ADD_NEW_DATA\addUser();
    \DATABASE_ADD_NEW_DATA\addNewUserAndRequest();

?>