<?php

include_once("../util/util.php");
include_once("../util/validator.php");
include_once("../util/session.php");



\UTIL_VALIDATOR\validatePostRequest();

\UTIL_VALIDATOR\validateAuthParams_BODY();

\SESSION\validateSession_BODY();


echo "private";



?>