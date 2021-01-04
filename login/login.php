<?php

include_once("../util/validator.php");
include_once("../util/session.php");


validatePostRequest();

validateLoginParams();

echo createNewSession(1);



?>