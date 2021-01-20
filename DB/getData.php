<?php
    namespace DATABASE_GET_DATA;
    //include_once("credential.php");
    include_once("validator.php");
    include_once("connection.php");
    include_once("../util/response.php");


    function getUsersJSON() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "select (name) from User;";

        $result = $conn->query($sql);

        //check if there is any error in query
        if(!$result) {
            sendResponseStatus(500);
            //echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }

        $users = array();
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return json_encode($users);

        //close the connection
        $conn->close();
    }

    

?>