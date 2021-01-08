<?php

    namespace LOGIN_NAME;
    include_once("validator.php");
    include_once("../util/validator.php");


    \UTIL_VALIDATOR\validatePostRequest();

    \LOGIN_VALIDATOR\validateLoginName();

    




?>