<?php

    namespace REGISTER_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");

    function validateRegisterParams() {

        if(empty($_POST["name"]) || empty($_POST["password"]) || empty($_POST["email"]) ||
        empty($_POST["name"]) || empty($_POST["name"]) || empty($_POST["name"]) ||
        empty($_POST["name"]) || empty($_POST["name"]) || empty($_POST["name"])
        )
        {
            sendResponseStatus(400);
            exit();
        }

    }

    


?>