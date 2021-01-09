<?php
    namespace DATABASE_ADD_NEW_DATA;
    //include_once("credential.php");
    include_once("connection.php");
    include_once("../util/response.php");

    function getSingleColumn($conn, $sql, $columnName) {

        $result = $conn->query($sql);

        //in database there should be a record
        if($result->num_rows !== 1) { 
            sendResponseStatus(500);
            exit();
        }

        $row = $result->fetch_assoc();
        $id = $row[$columnName];
        return $id;
    }

    //add new user in database----
    function addUser() {
        //create new connection
        $conn = initConnection();

        //retrieve normal User Role_ID
        $sql = "select (Role_ID) from Role where Name = 'user';";
        $UserRoleID = getSingleColumn($conn, $sql, "Role_ID");


        //close the connection
        $conn->close();
    }


    



    // $sql = "select * from role";

    // $result = $conn->query($sql);

    // if($result->num_rows > 0) {
    //     while($row = $result->fetch_assoc()) {
    //         echo "<br>name: ". $row["Name"] . "<br>";
    //     }
    // }
    // else {
    //     echo "0 results";
    // }


?>