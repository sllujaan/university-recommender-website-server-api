<?php

    namespace LOGIN_NAME;
    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../DB/validator.php");

    \UTIL_VALIDATOR\validatePostRequest();

    \LOGIN_VALIDATOR\validateLoginName();

    \DATABASE_VALIDATOR\verifyUserName($_POST["name"]);


?>