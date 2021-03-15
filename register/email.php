<?php

    /**
     * this file validates if the user email already exists in the database.
     */
    include_once("validator.php");
    include_once("../DB/validator.php");
    include_once("../util/validator.php");
    include_once("../DB/addNewData.php");


    /*make sure that the incoming request is a post request*/
    \UTIL_VALIDATOR\validatePostRequest();
    
    /*make sure that in the request contains the user email*/
    \REGISTER_VALIDATOR\validateRegisterEmailParams();

    /*check if the user email already exits in the database and send appropriate response*/
    \DATABASE_VALIDATOR\validateUserEmail();

?>