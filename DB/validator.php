<?php
    namespace DATABASE_VALIDATOR;
    include_once("credential.php");
    include_once("connection.php");
    include_once("../util/response.php");


    //make sure there is only one sql row in result
    function verifyPassword($result, $password) {
        $row = $result->fetch_assoc();
        if(!password_verify($password, $row["Password"])) {
            sendResponseStatus(401);
            exit();
        }
        return $row["User_ID"];
    }

    function verifyUser($name, $password) {
        $conn = initConnection(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        
        $stmt = $conn->prepare("SELECT User_ID, Password FROM user WHERE Name = ?");
        $stmt->bind_param("s", $pName);

        // set parameters and execute
        $pName = $name;
        $stmt->execute();
        $result = $stmt->get_result();

        //if user found there should be only one row
        if($result->num_rows !== 1) { 
            sendResponseStatus(401);
            exit();
        }
        
        //verify password
        $userID = verifyPassword($result, $password);

        //close the connection
        $conn->close();

        return $userID;

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