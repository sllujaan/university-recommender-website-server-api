<?php

    namespace UTIL_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");

     /*make sure that the incoming request is a post request*/
    function validatePostRequest() {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            sendResponseStatus(400);
            exit();
        }
    }

    /**
     * validates the session of a user.
     * credentials are coming through request body.
     */
    function validateAuthParams_BODY() {
        $reqestData = \UTIL\getRequestData();
        if(empty($reqestData["session_id"]) || empty($reqestData["user_id"])) {
            sendResponseStatus(400);
            exit();
        }
    }

    /**
     * validates the session of a user.
     * credentials are coming through form data.
     */
    function validateAuthParams_POST() {
        if(empty($_POST["session_id"]) || empty($_POST["user_id"])) {
            sendResponseStatus(400);
            exit();
        }
    }

?>