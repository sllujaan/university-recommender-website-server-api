<?php

    namespace UPDATE_UNIVERSITY_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");



    function validateNewUniversityParams() {
        if(
            empty($_POST["name"]) || empty($_POST["password"])
        ) {
            sendResponseStatus(400);
            exit();
        }
    }


    function validateProgramsParams($programsArr) {
        foreach ($programsArr as $program) {
            if(
                empty($program["Program_ID"]) ||
                empty($program["Description"]) || empty($program["Fee_Total"]) ||
                empty($program["Fee_Description"]) || empty($program["MM_PCT"]) ||
                empty($program["MM_PN"])
            ) {
                echo "<br>Invalid data Programs<br>";
                sendResponseStatus(400);    //bad request.
                exit();
            }
        }
    }


    function validateNewUniversityParams_BODY() {
        //get the request data as array
        $requestData = \UTIL\getRequestData();
        
        if(empty($requestData)) {
            sendResponseStatus(400);    //bad request.
            exit();
        }

        if(
            empty($requestData["University_ID"]) ||
            empty($requestData["Name"]) || empty($requestData["Description"]) ||
            empty($requestData["Country_ID"]) || empty($requestData["City_ID"]) ||
            empty($requestData["Admission_Criteria"]) || empty($requestData["Start_Admission_Date"]) ||
            empty($requestData["End_Admission_Date"]) || empty($requestData["Total_ETM"]) ||
            empty($requestData["S_Education_MC_PCT"]) || empty($requestData["H_Education_MC_PCT"]) ||
            !isset($requestData["Phone"]) || !isset($requestData["Web_Link"]) || !isset($requestData["Email"]) ||
            empty($requestData["Address"])
        ) {
            echo "<br>Invalid data Name<br>";
            sendResponseStatus(400);    //bad request.
            exit();
        }

        if(!is_array($requestData["programs"]) || count($requestData["programs"]) < 1) {
            echo "<br>Invalid data Pro<br>";
            sendResponseStatus(400);    //bad request.
            exit();
        }

        validateProgramsParams($requestData["programs"]);

        return $requestData["University_ID"];

    }

    


?>