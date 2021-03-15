<?php

    include_once("header.php");
    include_once("response.php");
    include_once("../DB/getData.php");

    /**
     * retrieve programs from database and print as json.
     */
    echo \DATABASE_GET_DATA\getPrograms();

?>