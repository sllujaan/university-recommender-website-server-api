<?php

include_once("../util/util.php");
include_once("../util/validator.php");
include_once("../util/session.php");



validatePostRequest();

validateAuthParams();

validateSession();


echo "private";



?>