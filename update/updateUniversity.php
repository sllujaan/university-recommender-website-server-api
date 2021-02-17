<?php

    include_once("validator.php");
    include_once("../util/validator.php");
    include_once("../util/session.php");
    include_once("../DB/validator.php");
    include_once("../DB/addNewData.php");

    \UTIL_VALIDATOR\validatePostRequest();

    \UPDATE_UNIVERSITY_VALIDATOR\validateNewUniversityParams_BODY();

    \DATABASE_ADD_NEW_DATA\updateNewUniversityAndProgramsTrans(59);

    echo "<br>done<br>";



?>