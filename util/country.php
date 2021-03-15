<?php
    
    include_once("header.php");
    include_once("response.php");
    include_once("../DB/getData.php");

    
    /**
     * retrieve countries form database and print as json
     */
    echo \DATABASE_GET_DATA\getCountries();

?>