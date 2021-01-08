<?php

    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");


    \UTIL_VALIDATOR\validatePostRequest();
    
    \REGISTER_VALIDATOR\validateRegisterParams();




?>