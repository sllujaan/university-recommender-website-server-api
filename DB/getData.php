<?php
    namespace DATABASE_GET_DATA;
    //include_once("credential.php");
    include_once("validator.php");
    include_once("connection.php");
    include_once("../util/response.php");


    function getUsers() {
        //create new connection
        $conn = initConnection();

        

        //close the connection
        $conn->close();
    }

    

?>