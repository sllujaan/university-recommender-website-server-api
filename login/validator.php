<?php

    namespace LOGIN_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");

    /*It checks if login form parameters (i.e name or password) are not present*/
    function validateLoginParams() {
        if(empty($_POST["name"]) || empty($_POST["password"])) {
            sendResponseStatus(400);
            exit();
        }
    }

?>