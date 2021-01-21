<?php

    include_once("validator.php");
    include_once("../DB/validator.php");
    include_once("../util/validator.php");
    include_once("../DB/addNewData.php");


    \UTIL_VALIDATOR\validatePostRequest();
    
    \REGISTER_VALIDATOR\validateRegisterEmailParams();

    \DATABASE_VALIDATOR\validateUserEmail();




?>