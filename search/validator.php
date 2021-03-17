<?php

    namespace CREAT_SEARCH_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");



    function validateCreateSearchParams() {
        if(
            !isset($_POST["Name"]) || !isset($_POST["Country_ID"]) ||
            !isset($_POST["City_ID"]) || !isset($_POST["Program_ID"]) ||
            !isset($_POST["Budget_US_$"]) || !isset($_POST["MM_PCT"]) ||
            !isset($_POST["Start_Admission_Date"])
        ) {
            sendResponseStatus(400);
            exit();
        }
    }

    function validateCreateSearchParams_BODY($search) {
        if(
            !isset($search["Name"]) || !isset($search["Country_ID"]) ||
            !isset($search["City_ID"]) || !isset($search["Program_ID"]) ||
            !isset($search["Budget_US_$"]) || !isset($search["MM_PCT"])
        ) {
            sendResponseStatus(400);
            exit();
        }
    }

    function validateSearchParams() {
        validateCreateSearchParams();
    }

    function validateSearchParams_BODY() {
        $requestData = \UTIL\getRequestData();
        validateCreateSearchParams_BODY($requestData);
    }

    

    /*
    if(
            empty($_POST["Name"]) || empty($_POST["Country_ID"]) ||
            empty($_POST["City_ID"]) || empty($_POST["Program_ID"]) ||
            empty($_POST["Budget_US_$"]) || empty($_POST["MM_PCT"])
        )
    */


?>