<?php

    namespace LOGIN_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");

    function validateLoginName() {
        if(empty($_POST["name"])) {
            sendResponseStatus(400);
            exit();
        }
    }

    function validateLoginParams() {
        if(empty($_POST["name"]) || empty($_POST["password"])) {
            sendResponseStatus(400);
            exit();
        }
    }

    


?>