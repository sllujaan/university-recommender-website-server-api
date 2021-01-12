<?php

include_once("validator.php");
include_once("../util/validator.php");


\UTIL_VALIDATOR\validatePostRequest();

\UTIL_VALIDATOR\validateAuthParams_POST();



echo "done";



?>