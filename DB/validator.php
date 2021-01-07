<?php
    namespace DATABASE_VALIDATOR;
    include_once("credential.php");
    include_once("connection.php");
    include_once("../util/response.php");

    function verifyUser($name, $password) {
        $conn = initConnection(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        
        $stmt = $conn->prepare("SELECT * FROM user WHERE Name = ? AND Password = ?");
        $stmt->bind_param("ss", $pName, $pPassword);

        // set parameters and execute
        $pName = $name;
        $pPassword = $password;
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows !== 1) { //if user found there should be only one row
            sendResponseStatus(401);
            exit();
        }
        else {
            while ($row = $result->fetch_assoc()) {
                echo "<br>name: ". $row["Name"] . "<br>";
            }
        }
        


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