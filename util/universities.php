<?php

    include_once("header.php");
    include_once("../DB/getData.php");

    
    /**
     * retrive users from the database and print as json.
     */
    echo \DATABASE_GET_DATA\getUniversities();

    


?>