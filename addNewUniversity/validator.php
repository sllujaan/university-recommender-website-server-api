<?php

    namespace NEW_UNIVERSITY_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");


    function validateNewUniversityParams() {
        if(empty($_POST["name"]) || empty($_POST["password"])) {
            sendResponseStatus(400);
            exit();
        }
    }

    


?>