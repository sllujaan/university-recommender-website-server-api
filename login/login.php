<?php

include_once("validator.php");
include_once("../util/validator.php");
include_once("../util/session.php");
include_once("../DB/validator.php");


\UTIL_VALIDATOR\validatePostRequest();

\LOGIN_VALIDATOR\validateLoginParams();

$userId = \DATABASE_VALIDATOR\verifyUser($_POST["name"], $_POST["password"]);

echo \SESSION\createNewSession($userId);



?>