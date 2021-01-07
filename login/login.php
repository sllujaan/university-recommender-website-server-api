<?php

include_once("../util/validator.php");
include_once("../util/session.php");
include_once("../DB/validator.php");


validatePostRequest();

validateLoginParams();

verifyUser($_POST["name"], $_POST["password"]);

echo createNewSession(1);



?>