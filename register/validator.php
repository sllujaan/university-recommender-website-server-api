<?php

    namespace REGISTER_VALIDATOR;
    include_once("../util/util.php");
    include_once("../util/response.php");

    function validateRegisterParams() {

        if(
            empty($_POST["name"]) || empty($_POST["password"]) || empty($_POST["email"]) ||
            empty($_POST["country_id"]) || empty($_POST["city_id"]) || empty($_POST["program_id"]) ||
            empty($_POST["start_admission_date"]) || empty($_POST["budget_us_$"]) || empty($_POST["s_education_pct"]) ||
            empty($_POST["h_education_pct"]) || empty($_POST["etm_pct"])
        )
        {
            sendResponseStatus(400);
            exit();
        }

    }

    


?>