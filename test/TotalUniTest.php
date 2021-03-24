<?php
    
    include_once("../util/header.php");
    include_once("../DB/getData.php");
    include_once("../DB/connection.php");


    //create new connection
    $conn = initConnection();

    echo \DATABASE_GET_DATA\getTotalUniversities($conn);

    //close the connection
    $conn->close();


?>