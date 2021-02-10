<?php

    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");
    include_once("../DB/addNewData.php");

    \UTIL_VALIDATOR\validatePostRequest();

    \NEW_UNIVERSITY_VALIDATOR\validateNewUniversityParams_BODY();

    \DATABASE_ADD_NEW_DATA\addNewUniversityAndProgramsTrans();

    echo "<br>done<br>";



?>