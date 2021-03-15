<?php

    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");
    include_once("../DB/addNewData.php");

    \UTIL_VALIDATOR\validatePostRequest();

    \UPDATE_UNIVERSITY_VALIDATOR\validateNewUniversityParams_BODY();

    /*make sure that user's credentials are present in the request*/
    \UTIL_VALIDATOR\validateAuthParams_BODY();

    /*make sure that the session exists for the incoming user's request*/
    \SESSION\validateSession_BODY();

    \DATABASE_ADD_NEW_DATA\updateNewUniversityAndProgramsTrans();

    echo "<br>done<br>";



?>