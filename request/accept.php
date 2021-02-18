<?php

    namespace ACCEPT_REQUEST;
    include_once("../util/header.php");
    include_once("../DB/addNewData.php");


    \DATABASE_ADD_NEW_DATA\AcceptRequest($_POST["user_id"]);

?>