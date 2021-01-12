<?php

    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");

    \UTIL_VALIDATOR\validatePostRequest();

    \UTIL_VALIDATOR\validateAuthParams_POST();

    \SESSION\validateSession_POST();

    \DATABASE_VALIDATOR\verifyAdmin();

    echo "done";



?>