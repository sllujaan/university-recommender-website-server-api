<?php

    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");
    include_once("../DB/addNewData.php");

    \UTIL_VALIDATOR\validatePostRequest();

    \NEW_UNIVERSITY_VALIDATOR\validateNewUniversityParams_BODY();

    //\UTIL_VALIDATOR\validateAuthParams_POST();

    //\SESSION\validateSession_POST();

    //\DATABASE_ADD_NEW_DATA\addNewUniversity();

    echo "<br>done<br>";



?>