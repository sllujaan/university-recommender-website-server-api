<?php


    include_once("../util/header.php");
    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/addNewData.php");


    \UTIL_VALIDATOR\validatePostRequest();
    
    \REGISTER_VALIDATOR\validateRegisterParams();

    \DATABASE_ADD_NEW_DATA\addUser();


?>