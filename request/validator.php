<?php

    namespace REQUEST_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");

    /**
     * Validates if user name is present in the incoming request.
     */
    function validateRequestAcceptParams_POST() {
        if(empty($_POST["user_id_requested"])) {
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