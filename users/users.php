<?php
    namespace USERS;

    include_once("../DB/getData.php");

    echo \DATABASE_GET_DATA\getUsersJSON();

?>