<?php
    namespace DATABASE_VALIDATOR;
    //include_once("credential.php");
    include_once("connection.php");
    include_once("../util/response.php");


    /**
     * verifies password
     */
    function verifyPassword($result, $password) {
        $row = $result->fetch_assoc();
        if(!password_verify($password, $row["Password"])) {
            sendResponseStatus(401);
            exit();
        }
        return $row["User_ID"];
    }

    /**
     * verifies if the user exits in the database.
     */
    function verifyUser($name, $password) {
        $conn = initConnection();
        
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


    //checks if the name exists in database
    function verifyUserName($name) {
        //create new connection
        $conn = initConnection();
        
        $stmt = $conn->prepare("SELECT User_ID FROM user WHERE Name = ?");
        $stmt->bind_param("s", $pName);

        // set parameters and execute
        $pName = $name;
        $stmt->execute();
        $result = $stmt->get_result();

        //if user name found there should be only one row
        if($result->num_rows === 1) { 
            sendResponseStatus(200);
            exit();
        }

        //verify that no user found
        if($result->num_rows < 1) { 
            sendResponseStatus(404);
            exit();
        }

        //close the connection
        $conn->close();
    }

    /**
     * varifies the user is admin.
     */
    function verifyAdmin($conn, $userID) {

        $sql = "select * from User inner join Role
        on User.Role_ID = Role.Role_ID
        and Role.Name = 'admin'
        and User.User_ID = " . $userID . ";";


        $result = $conn->query($sql);

        //in database there should be only one admin
        if($result->num_rows !== 1) { 
            sendResponseStatus(401);
            //echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

    }

    /**
     * handles statement execution and sends appropriate response to user.
     */
    function handleStatementExecution($stmt) {
        if(!$stmt->execute()) {
            sendResponseStatus(500);
            echo "Failed to add the Record: " . $stmt->error;
            exit();
        }

        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            sendResponseStatus(409); //conflict
            exit();
        }
    }


    /**
     * validates if user name exists in the database.
     */
    function validateUserName() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $stmt = $conn->prepare("SELECT User_ID FROM user WHERE Name = ?;");

        //query error
        if(!$stmt) {
            sendResponseStatus(500);
            exit();
        }

        $stmt->bind_param("s", $_POST["name"]);

        handleStatementExecution($stmt);

        //close the connection
        $conn->close();
    }


    /**
     * validates if user email exists in the database.
     */
    function validateUserEmail() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $stmt = $conn->prepare("SELECT User_ID FROM user WHERE Email = ?;");

        //query error
        if(!$stmt) {
            sendResponseStatus(500);
            exit();
        }

        $stmt->bind_param("s", $_POST["email"]);

        handleStatementExecution($stmt);

        //close the connection
        $conn->close();
    }

?>