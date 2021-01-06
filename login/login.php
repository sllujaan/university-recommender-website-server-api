<?php

include_once("../util/validator.php");
include_once("../util/session.php");
include_once("../DB/validator.php");


validatePostRequest();

validateLoginParams();

echo createNewSession(1);



?>