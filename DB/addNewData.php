<?php
    namespace DATABASE_ADD_NEW_DATA;
    //include_once("credential.php");
    include_once("validator.php");
    include_once("connection.php");
    include_once("../util/response.php");

    function getSingleColumn($conn, $sql, $columnName) {
        $result = $conn->query($sql);

        //in database there should be a record
        if($result->num_rows !== 1) { 
            sendResponseStatus(500);
            //echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        $row = $result->fetch_assoc();
        $id = $row[$columnName];
        //check that id is not empty. make columnName is correct
        if(empty($id)) {
            sendResponseStatus(500);
            exit();
        }

        return $id;
    }

    //add new user in database----
    function addUser() {
        //create new connection
        $conn = initConnection();

        //retrieve Role_ID for normal users
        $sql = "select (Role_ID) from Role where Name = 'user';";
        $UserRoleID = getSingleColumn($conn, $sql, "Role_ID");
        //retrieve Account_Status_ID for normal users
        $sql = "select (Account_Status_ID) from Account_Status where Name = 'pending';";
        $AccountSatatusID = getSingleColumn($conn, $sql, "Account_Status_ID");


        

        $stmt = $conn->prepare("
            insert into User (
            `Role_ID`,
            `Account_Status_ID`,
            `Name`,
            `Password`,
            `Email`,
            `Start_Admission_Date`,
            `Budget`,
            `S_Education_PCT`,
            `H_Education_PCT`,
            `ETM_PCT`
            )
            values
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )"
        );

        //query error
        if(!$stmt) {
            sendResponseStatus(500);
            exit();
        }

        $hasedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "iissssiddd", $UserRoleID, $AccountSatatusID,
            $_POST["name"], $hasedPassword, $_POST["email"],
            $_POST["start_admission_date"], $_POST["budget_us_$"], $_POST["s_education_pct"],
            $_POST["h_education_pct"], $_POST["etm_pct"]
        );


        define("DUPLICATE_KEY", 1062);
        if(!$stmt->execute()) {
            if((int)$stmt->errno === DUPLICATE_KEY) {
                sendResponseStatus(400);
                //echo "Failed to add the Record: " . $stmt->error;
                exit();
            }
            //other error code from database
            sendResponseStatus(500);
            exit();
        }

        //close the connection
        $conn->close();
    }

    


    function addNewUniversity() {
        //create new connection
        $conn = initConnection();

        \DATABASE_VALIDATOR\verifyAdmin($conn);

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