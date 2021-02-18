<?php
    namespace DATABASE_ADD_NEW_DATA;
    //include_once("credential.php");
    include_once("validator.php");
    include_once("connection.php");
    include_once("../util/response.php");
    include_once("../util/util.php");


    /**
     * retrieves a single column from database
     * from the given sql statement, connection and column name.
     */
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
        //check that id is not empty. make sure the columnName is correct
        if(empty($id)) {
            sendResponseStatus(500);
            exit();
        }

        return $id;
    }

    function getSingleColumnTrans($conn, $sql, $columnName) {
        $result = $conn->query($sql);

        //in database there should be a record
        if($result->num_rows !== 1) {
            throw new \Exception("Failed to Retrieve the Record: " . $conn->error . " (FUN: ".__FUNCTION__.")");

        }

        $row = $result->fetch_assoc();
        $id = $row[$columnName];
        //check that id is not empty. make sure the columnName is correct
        if(empty($id)) {
            throw new \Exception("getSingleColumnTrans::500" . $conn->error . " (FUN: ".__FUNCTION__.")"); //internal server error
        }

        return $id;
    }

    /**
     * 
     * adds new user in the database.
     */
    function addUser() {
        //function has been deprecated.
        trigger_error("Deprecated function called.", E_USER_NOTICE);
        //create new connection
        $conn = initConnection();

        //retrieve Role_ID for normal users
        $sql = "select (Role_ID) from Role where Name = 'user';";
        $UserRoleID = getSingleColumn($conn, $sql, "Role_ID");
        //retrieve Account_Status_ID for normal users
        $sql = "select (Account_Status_ID) from Account_Status where Name = 'pending';";
        $AccountSatatusID = getSingleColumn($conn, $sql, "Account_Status_ID");


        $stmt = $conn->prepare(
            "insert into User (
                `Role_ID`,
                `Account_Status_ID`,
                `Name`,
                `Password`,
                `Email`,
                `Country_ID`,
                `City_ID`,
                `Program_ID`,
                `Start_Admission_Date`,
                `Budget_US_$`,
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
            "iisssiiisiddd", $UserRoleID, $AccountSatatusID,
            $_POST["name"], $hasedPassword, $_POST["email"],
            $_POST["country_id"], $_POST["city_id"], $_POST["program_id"],
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



    function handleException($e) {
        switch ($e->getMessage()) {
            case 'handleStatementExecutionTrans::400':
                sendResponseStatus(400);
                //echo "Failed to add the Record: " . $stmt->error;
                exit();
                break;
            
            default:
                sendResponseStatus(500);
                echo "UNKOWN ERROR<br>";
                echo $e->getMessage();
                //echo "Failed to add the Record: " . $stmt->error;
                exit();
                break;
        }
    }


    function handleStatementExecutionTrans($stmt) {
        define("DUPLICATE_KEY", 1062);
        if(!$stmt->execute()) {
            if((int)$stmt->errno === DUPLICATE_KEY) {
                throw new \Exception("handleStatementExecutionTrans::400"); //bad request
                // sendResponseStatus(400);
                // //echo "Failed to add the Record: " . $stmt->error;
                // exit();
            }
            echo $stmt->error;
            //other error code from database
            // sendResponseStatus(500);
            // exit();
            throw new \Exception("handleStatementExecutionTrans::500"); //internal server error
        }
    }


    /**
     * adds new user in the database.
     */
    function addNewUserTrans($conn) {

        //retrieve Role_ID for normal users
        $sql = "select (Role_ID) from Role where Name = 'user';";
        $UserRoleID = getSingleColumn($conn, $sql, "Role_ID");
        //retrieve Account_Status_ID for normal users
        $sql = "select (Account_Status_ID) from Account_Status where Name = 'pending';";
        $AccountSatatusID = getSingleColumn($conn, $sql, "Account_Status_ID");


        $stmt = $conn->prepare(
            "insert into User (
                `Role_ID`,
                `Account_Status_ID`,
                `Name`,
                `Password`,
                `Email`,
                `Country_ID`,
                `City_ID`,
                `Program_ID`,
                `Start_Admission_Date`,
                `Budget_US_$`,
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
                ?,
                ?,
                ?,
                ?
            )"
        );

        //query error
        if(!$stmt) {
            throw new \Exception("addNewUserTrans::500"); //internal server error
            // sendResponseStatus(500);
            // exit();
        }

        $hasedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $stmt->bind_param(
            "iisssiiisiddd", $UserRoleID, $AccountSatatusID,
            $_POST["name"], $hasedPassword, $_POST["email"],
            $_POST["country_id"], $_POST["city_id"], $_POST["program_id"],
            $_POST["start_admission_date"], $_POST["budget_us_$"], $_POST["s_education_pct"],
            $_POST["h_education_pct"], $_POST["etm_pct"]
        );

        handleStatementExecutionTrans($stmt);

    }


    function addNewRequestTrans($conn) {
        $stmt = $conn->prepare("
                insert into request (`User_ID`, `Date_Time`)
                values(
                (select User_ID from user where Name = ?)
                , NOW());
                ");
        
        //query error
        if(!$stmt) {
            throw new \Exception("addNewRequestTrans::500"); //internal server error
            // sendResponseStatus(500);
            // exit();
        }

        $stmt->bind_param("s", $_POST["name"]);

        handleStatementExecutionTrans($stmt);

        
    }

    /**
     * adds new user in the database.
     */
    function addNewUserAndRequest() {

        //create new connection
        $conn = initConnection();

        try{
            //First of all, let's begin a transaction
            $conn->begin_transaction();

            //add new user.
            addNewUserTrans($conn);
            //add new user registration request.
            addNewRequestTrans($conn);
            //commit transaction.
            $conn->commit();

        }
        catch(\Exception $e) {
            $conn->rollback();
            handleException($e);
        }
        

        //close the connection
        $conn->close();

        

    }



    function addNewUniversityTrans($conn, $universityData) {

        $stmt = $conn->prepare(
            "insert into University (
                `Name`,
                `Description`,
                `Country_ID`,
                `City_ID`,
                `Admission_Criteria`,
                `Start_Admission_Date`,
                `End_Admission_Date`,
                `Total_ETM`,
                `S_Education_MC_PCT`,
                `H_Education_MC_PCT`,
                `PCT_MC_ETM`,
                `Phone`,
                `Web_Link`,
                `Email`,
                `Address`
            )
            values(
                ?,
                ?,
                ?,
                ?,
                ?,
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

        $stmt->bind_param(
            "ssiisssidddssss",
            $universityData["Name"], $universityData["Description"], $universityData["Country_ID"],
            $universityData["City_ID"], $universityData["Admission_Criteria"], $universityData["Start_Admission_Date"],
            $universityData["End_Admission_Date"], $universityData["Total_ETM"], $universityData["S_Education_MC_PCT"],
            $universityData["H_Education_MC_PCT"], $universityData["PCT_MC_ETM"], $universityData["Phone"],
            $universityData["Web_Link"], $universityData["Email"], $universityData["Address"]
        );

        //query error
        if(!$stmt) {
            throw new \Exception("addNewUniversityTrans::500"); //internal server error
        }

        handleStatementExecutionTrans($stmt);

        $sql = "select University_ID from University where name = '".$universityData["Name"]."';";
        echo "<br>$sql<br>";
        $universityID = getSingleColumnTrans($conn, $sql, "University_ID");
        
        return $universityID;

    }

    function addNewUniversityProgramTrans($conn, $universityID, $program) {
        
        $stmt = $conn->prepare(
            "insert into University_Program (
                `University_ID`,
                `Program_ID`,
                `Description`,
                `Fee_Total`,
                `Fee_Description`,
                `MM_PCT`,
                `MM_PN`
            )
            values(
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
            throw new \Exception("addNewUniversityProgramTrans::500"); //internal server error
        }

        $stmt->bind_param(
            "iisisds",
            $universityID, $program["Program_ID"], $program["Description"],
            $program["Fee_Total"], $program["Fee_Description"],  $program["MM_PCT"],
            $program["MM_PN"]
        );

        handleStatementExecutionTrans($stmt);
    }

    
    /**
     * adds new universiy in the database
     */
    function addNewUniversityAndProgramsTrans() {

        //\DATABASE_VALIDATOR\verifyAdmin($conn, $_SESSION[$_POST["session_id"]]);

        //rest of the code....
        $requestData = \UTIL\getRequestData();
        $programs = $requestData["programs"];

        //create new connection
        $conn = initConnection();

        try{

            echo "<br>begining the transaction...<br>";
            //First of all, let's begin a transaction
            $conn->begin_transaction();

            //add new user.
            $universityID = addNewUniversityTrans($conn, $requestData);
            
            echo  $universityID;
            //add new user registration request.
            foreach ($programs as $program) {
                addNewUniversityProgramTrans($conn, $universityID, $program);
            }
            
            //commit transaction.
            $conn->commit();

            echo "<br>commited.<br>";

        }
        catch(\Exception $e) {
            $conn->rollback();
            echo "<br>rollbacked.<br>";
            handleException($e);
        }

        //close the connection
        $conn->close();
    }



    /**
     * creates a new search
     */
    function createNewSearch($userID) {

        //create new connection
        $conn = initConnection();


        $stmt = $conn->prepare(
            "insert into Search(
                `User_ID`,
                `Name`,
                `Country_ID`,
                `City_ID`,
                `Program_ID`,
                `budget_US_$`,
                `MM_PCT`
            ) values (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            );"
        );

        //query error
        if(!$stmt) {
            sendResponseStatus(500);    //internal server error.
            echo "Failed to add the Record: " . $stmt->error;
            exit();
        }


        //check empty values
        $countryID = NULL;
        $cityID = NULL;
        $programID = NULL;
        $Budget = NULL;
        $MM_PCT = NULL;

        if(!empty($_POST["Country_ID"])) $countryID = $_POST["Country_ID"];
        if(!empty($_POST["City_ID"])) $cityID = $_POST["City_ID"];
        if(!empty($_POST["Program_ID"])) $programID = $_POST["Program_ID"];
        if(!empty($_POST["budget_US_$"])) $Budget = $_POST["budget_US_$"];
        if(!empty($_POST["MM_PCT"])) $MM_PCT = $_POST["MM_PCT"];

        $stmt->bind_param(
            "isiiiid",
            $userID, $_POST["Name"], $countryID, $cityID,
            $programID, $Budget, $MM_PCT
        );


        try {
            handleStatementExecutionTrans($stmt);
        }
        catch(\Exception $e) {
            handleException($e);
        }

        //close the connection
        $conn->close();

    }




    function UpdateNewUniversityTrans($conn, $universityData) {

        $stmt = $conn->prepare(
            "update university
            set
            `Name` = ?,
            `Description` = ?,
            `Country_ID` = ?,
            `City_ID` = ?,
            `Admission_Criteria` = ?,
            `Start_Admission_Date` = ?,
            `End_Admission_Date` = ?,
            `Total_ETM` = ?,
            `S_Education_MC_PCT` = ?,
            `H_Education_MC_PCT` = ?,
            `PCT_MC_ETM` = ?,
            `Phone` = ?,
            `Web_Link` = ?,
            `Email` = ?,
            `Address` = ?
            where University_ID = 1
            ;"
        );

        $stmt->bind_param(
            "ssiisssidddssss",
            $universityData["Name"], $universityData["Description"], $universityData["Country_ID"],
            $universityData["City_ID"], $universityData["Admission_Criteria"], $universityData["Start_Admission_Date"],
            $universityData["End_Admission_Date"], $universityData["Total_ETM"], $universityData["S_Education_MC_PCT"],
            $universityData["H_Education_MC_PCT"], $universityData["PCT_MC_ETM"], $universityData["Phone"],
            $universityData["Web_Link"], $universityData["Email"], $universityData["Address"]
        );

        //query error
        if(!$stmt) {
            throw new \Exception("updateNewUniversityTrans::500"); //internal server error
        }

        handleStatementExecutionTrans($stmt);

    }

    /**
     * updates new universiy in the database
     */
    function updateNewUniversityAndProgramsTrans($universityID) {

        //\DATABASE_VALIDATOR\verifyAdmin($conn, $_SESSION[$_POST["session_id"]]);

        //rest of the code....
        $requestData = \UTIL\getRequestData();
        $programs = $requestData["programs"];

        //create new connection
        $conn = initConnection();

        try{

            echo "<br>begining the transaction...<br>";
            //First of all, let's begin a transaction
            $conn->begin_transaction();

            //add new user.
            UpdateNewUniversityTrans($conn, $requestData);
            
            //add new user registration request.
            // foreach ($programs as $program) {
            //     addNewUniversityProgramTrans($conn, $universityID, $program);
            // }
            
            //commit transaction.
            $conn->commit();

            echo "<br>commited.<br>";

        }
        catch(\Exception $e) {
            $conn->rollback();
            echo "<br>rollbacked.<br>";
            handleException($e);
        }

        //close the connection
        $conn->close();
    }



    /**
     * accepts user registration request
     */
    function AcceptRequest($userID) {
        //create new connection
        $conn = initConnection();

        $stmt = $conn->prepare(
            "update User
            set Account_Status_ID = (select (Account_Status_ID) from Account_Status where Name = 'approved')
            where User_ID = ?;"
        );

        $stmt->bind_param("i", $userID);


        //query error
        if(!$stmt) {
            sendResponseStatus(500);
            echo "Failed to update the Record: " . $conn->error;
            exit();
        }

        try {
            handleStatementExecutionTrans($stmt);
        }
        catch(\Exception $e) {
            handleException($e);
        }

        //close the connection
        $conn->close();
    }


    
    /**
     * rejects user registration request
     */
    function RejectRequest($userID) {
        //create new connection
        $conn = initConnection();

        $stmt = $conn->prepare(
            "update User
            set Account_Status_ID = (select (Account_Status_ID) from Account_Status where Name = 'rejected')
            where User_ID = ?;"
        );

        $stmt->bind_param("i", $userID);


        //query error
        if(!$stmt) {
            sendResponseStatus(500);
            echo "Failed to update the Record: " . $conn->error;
            exit();
        }

        try {
            handleStatementExecutionTrans($stmt);
        }
        catch(\Exception $e) {
            handleException($e);
        }

        //close the connection
        $conn->close();
    }


?>