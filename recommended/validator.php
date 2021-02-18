<?php

    namespace REGISTER_VALIDATOR;
    include_once("../util/response.php");


    /**
     * Validates if user name is present in the incoming request.
     */
    function validateRecommededParams() {
        if(empty($_POST["name"])) {
            sendResponseStatus(400);
            exit();
        }
    }

    /**
     * Validates if user email is present in the incoming request.
     */
    function validateRegisterEmailParams() {
        if(empty($_POST["email"])) {
            sendResponseStatus(400);
            exit();
        }
    }

?>