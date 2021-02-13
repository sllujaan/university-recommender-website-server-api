<?php
    namespace DATABASE_GET_DATA;
    include_once("validator.php");
    include_once("connection.php");
    include_once("../util/response.php");
    include_once("addNewData.php");

    /**
     * retrives countries from the database.
     */
    function getCountries() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "select country.Country_ID, country.Name from country inner join city
                on
                country.Country_ID =  city.Country_ID
                group by country.Name;";

        $result = $conn->query($sql);

        //check if there is any error in query
        if(!$result) {
            sendResponseStatus(500);
            echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }

        $Countries = array();
        while($row = $result->fetch_assoc()) {
            $Countries[] = $row;
        }

        return json_encode($Countries);

        //close the connection
        $conn->close();
    }


    /**
     * retrives cites from database from they given country id.
     */
    function getCities($countryID) {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "select City_ID, Name from city where Country_ID = ?";

        $stmt = $conn->prepare($sql);

        //query error
        if(!$stmt) {
            sendResponseStatus(500);
            exit();
        }

        $stmt->bind_param("i", $countryID);

        if(!$stmt->execute()) {
            sendResponseStatus(500);
            exit();
        }

        $result = $stmt->get_result();

        //check if there is any error in query
        if(!$result) {
            sendResponseStatus(500);
            echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }

        $Cities = array();
        while($row = $result->fetch_assoc()) {
            $Cities[] = $row;
        }

        return json_encode($Cities);

        //close the connection
        $conn->close();
    }


    /**
     * retrieves programs from database
     */
    function getPrograms() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "select Program_ID, Name from Program;";

        $result = $conn->query($sql);

        //check if there is any error in query
        if(!$result) {
            sendResponseStatus(500);
            echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }

        $Programs = array();
        while($row = $result->fetch_assoc()) {
            $Programs[] = $row;
        }

        return json_encode($Programs);

        //close the connection
        $conn->close();
    }


    /**
     * retrieves users form database;
     */
    function getUsers() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "select User.Name as Name, User.Email as Email, Country.Name as Country, City.Name as City, Program.Name as Program
                from User 
                inner join Role on User.Role_ID = Role.Role_ID
                inner join Account_Status on User.Account_Status_ID = Account_Status.Account_Status_ID
                inner join Country on User.Country_ID = Country.Country_ID
                inner join City on User.City_ID = City.City_ID
                inner join Program on User.Program_ID = Program.Program_ID;";
        

        $result = $conn->query($sql);

        //check if there is any error in query
        if(!$result) {
            sendResponseStatus(500);
            echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }

        $Users = array();
        while($row = $result->fetch_assoc()) {
            $Users[] = $row;
        }

        return json_encode($Users);

        //close the connection
        $conn->close();
    }




    /**
     * retrieves users requests form database;
     */
    function getUsersRequests() {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "
                select 
                User.Name as Name, User.Email as Email, User.Start_Admission_Date as User_Start_Admission_Date,
                User.S_Education_PCT as User_S_Education_PCT, User.H_Education_PCT as User_H_Education_PCT,
                User.ETM_PCT as User_ETM_PCT, User.Budget_US_$ as User_Budget_US_$,
                Role.Name as User_Role, Request.Date_Time as Request_Creation_Date,
                Country.Name as Country, City.Name as City, Program.Name as Program, Account_Status.Name as Account_Status_Name
                
                from User
                inner join Request on User.User_ID = Request.User_ID
                inner join Role on User.Role_ID = Role.Role_ID
                inner join Account_Status on User.Account_Status_ID = Account_Status.Account_Status_ID
                inner join Country on User.Country_ID = Country.Country_ID
                inner join City on User.City_ID = City.City_ID
                inner join Program on User.Program_ID = Program.Program_ID;
                ";
        

        $result = $conn->query($sql);

        //check if there is any error in query
        if(!$result) {
            sendResponseStatus(500);
            echo "Failed to Retrieve the Record: " . $conn->error;
            exit();
        }

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }

        $Users = array();
        while($row = $result->fetch_assoc()) {
            $Users[] = $row;
        }

        return json_encode($Users);

        //close the connection
        $conn->close();
    }


    function prepareRegularExpression($arr) {
        $regex = "";
        foreach ($arr as $value) {
            $regex .= "($value)|";
        }
        $regex = substr($regex, 0, -1);
        return $regex;
    }

    function handlePrepareStatement($conn, $regex) {
        //check empty values
        $countryID = NULL;
        $countryID_SQL = "";
        $cityID = NULL;
        $cityID_SQL = "";
        $programID = NULL;
        $programID_SQL = "";
        $Budget = NULL;
        $Budget_SQL = "";
        $MM_PCT = NULL;
        $MM_PCT_SQL = "";

        if(!empty($_POST["Country_ID"])) {
            $countryID = $_POST["Country_ID"];
            $countryID_SQL = "and university.Country_ID = ? \r\n";
        }

        if(!empty($_POST["City_ID"])) {
            $cityID = $_POST["City_ID"];
            $countryID_SQL = "and university.City_ID = ? \r\n";
        }

        if(!empty($_POST["Program_ID"])){
            $programID = $_POST["Program_ID"];
            $countryID_SQL = "and university_program.Program_ID = ? \r\n";
        }

        if(!empty($_POST["budget_US_$"])) {
            $Budget = $_POST["budget_US_$"];
            $countryID_SQL = "and university_program.Fee_Total <= ? \r\n";
        }

        if(!empty($_POST["MM_PCT"])){
            $MM_PCT = $_POST["MM_PCT"];
            $countryID_SQL = "and university_program.MM_PCT <= ? \r\n";
        }

        $stmt = $conn->prepare(
            "select * from university
            inner join university_program
            on university.University_ID = university_program.University_ID
            
            where (
            university.Name regexp ?
            or
            university.Description regexp ?
            
            );"
        );

        //query error
        if(!$stmt) {
            sendResponseStatus(500);    //internal server error.
            echo "Failed to add the Record: " . $stmt->error;
            exit();
        }


        $stmt->bind_param(
            "ss", $regex, $regex
        );


        if(!$stmt->execute()) {
            sendResponseStatus(500);    //internal server error.
            echo "Failed to execute the statment: " . $stmt->error;
            exit();
        }

        $result = $stmt->get_result();

        //no row found
        if($result->num_rows === 0) {
            sendResponseStatus(404);
            exit();
        }
        
        $Universities = array();
        while($row = $result->fetch_assoc()) {
            $Universities[] = $row;
        }

        return json_encode($Universities);

    }


    /**
     * performs university search
    */
    function performUniversitySerach() {
        $searchNameArr = explode(" ", trim($_POST["Name"]));
        print_r( $searchNameArr );

        echo "<br>";

        $regex =  prepareRegularExpression($searchNameArr);

        //create new connection
        $conn = initConnection();

        echo handlePrepareStatement($conn, $regex);

        //close the connection
        $conn->close();

    }






?>