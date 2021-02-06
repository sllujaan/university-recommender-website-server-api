<?php

    namespace CREAT_SEARCH_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");



    function validateCreateSearchParams() {
        if(empty($_POST["Name"])) {
            sendResponseStatus(400);
            exit();
        }
    }

    

    /*
    if(
            empty($_POST["Name"]) || empty($_POST["Country_ID"]) ||
            empty($_POST["City_ID"]) || empty($_POST["Program_ID"]) ||
            empty($_POST["Budget_US_$"]) || empty($_POST["MM_PCT"])
        )
    */


?>