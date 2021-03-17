<?php
    namespace DATABASE_GET_DATA;
    include_once("validator.php");
    include_once("connection.php");
    include_once("../util/response.php");




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

        //close the connection
        $conn->close();

        return json_encode($Users);

        
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
                User.User_ID, 
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
                inner join Program on User.Program_ID = Program.Program_ID
                where Account_Status.Name = 'pending'
                ;
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

    function handlePrepareStatement($conn, $regex, $limit) {
        //check empty values
        $defaultID_regex = "\\b\d*\\b";
        $countryID_regex = $defaultID_regex;
        $cityID_regex = $defaultID_regex;
        $programID_regex = $defaultID_regex;
        $Start_Admission_Date = "9998-01-01";
        $End_Admission_Date = "0000-01-01";
        $Budget = 2147483647;
        $MM_PCT = 1;
        

        if(!empty($_POST["Country_ID"])) {
            $countryID_regex = "\\b" . $_POST["Country_ID"] . "\\b";
        }

        if(!empty($_POST["City_ID"])) {
            $cityID_regex = "\\b" . $_POST["City_ID"] . "\\b";
        }

        if(!empty($_POST["Program_ID"])){
            $programID_regex = "\\b" . $_POST["Program_ID"] . "\\b";
        }

        if(!empty($_POST["Start_Admission_Date"])){
            $Start_Admission_Date = $_POST["Start_Admission_Date"];
            $End_Admission_Date = $Start_Admission_Date;
        }

        if(!empty($_POST["budget_US_$"])) {
            $Budget = $_POST["budget_US_$"];
        }

        if(!empty($_POST["MM_PCT"])){
            $MM_PCT = $_POST["MM_PCT"];
        }

        $constraints = $countryID_SQL . $cityID_SQL;

        $stmt = $conn->prepare(
            "select university.University_ID, university.Name,
             university.Description, Country.Name as CountryName
             from university
                inner join university_program
                on university.University_ID = university_program.University_ID
                inner join Country
                on university.Country_ID = Country.Country_ID
                        
                    where (
                    university.Name regexp ?
                    or
                    university.Description regexp ?
                    )

                    and university.Country_ID regexp ?
                    and university.Country_ID regexp ?
                    and university_program.Program_ID regexp ?
                    and university.Start_Admission_Date <= (? + interval 1 month)
                    and university.End_Admission_Date >= ?
                    and university_program.Fee_Total <= ?
                    and university_program.MM_PCT <= ?

                    group by university.University_ID
                    {$limit}
                    ;"
        );

        //query error
        if(!$stmt) {
            sendResponseStatus(500);    //internal server error.
            echo "Failed to prepare the statment: " . $stmt->error;
            exit();
        }


        $stmt->bind_param(
            "sssssssid", $regex, $regex, $countryID_regex, $cityID_regex,
            $programID_regex, $Start_Admission_Date, $End_Admission_Date, $Budget,
            $MM_PCT
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

        //collection array
        $collectionArr[] = array(
            "Total_Universities" => (int)$result->num_rows,
            "Page_Number" => (int)$_GET['page']
        );

        $collectionArr[] = $Universities;

        return json_encode($collectionArr);

    }


    /**
     * performs university search
    */
    function performUniversitySerach($limit) {
        $searchNameArr = explode(" ", trim($_POST["Name"]));

        $regex =  prepareRegularExpression($searchNameArr);

        //create new connection
        $conn = initConnection();




        echo handlePrepareStatement($conn, $regex, $limit);

        //close the connection
        $conn->close();

    }



    
    /**
     * retrieves universites form database;
     */
    function getUniversities($limit) {
        //create new connection
        $conn = initConnection();

        $collectionArr = array();
        //get total numbers of universities.
        $sql = "select count(University_ID) as Total_Universities from university;";
        $TotalUniversities =  getSingleColumn($conn, $sql, "Total_Universities");
        $collectionArr[] = array(
            "Total_Universities" => (int)$TotalUniversities,
            "Page_Number" => (int)$_GET['page']
        );

        //sql query to retrieve universites
        $sql = "select University_ID, university.Name, Description, Country.Name as Name_Country from university 
        inner join Country on university.Country_ID = Country.Country_ID
        {$limit}
        ;";

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


        $Universities = array();
        while($row = $result->fetch_assoc()) {
            $Universities[] = $row;
        }


        $collectionArr[] = $Universities;

        


        //close the connection
        $conn->close();

        return json_encode($collectionArr);
    }






    /**
     * retrieves university details form database;
     */
    function getUniversityDetails($id) {
        //create new connection
        $conn = initConnection();

        $collectionArr = array();
        //get total numbers of universities.
        $sql = "select university.*, Country.Name as Name_Country, City.Name as Name_City
                from university 
                inner join Country on university.Country_ID = Country.Country_ID
                inner join City on university.City_ID = City.City_ID
                where university.University_ID = {$id}
                ;";

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


        $University = NULL;
        while($row = $result->fetch_assoc()) {
            $University = $row;
        }
        $collectionArr[] = array("University" => $University);


        //now retrieve programs

        $sql = "select * from University_Program
                inner join Program on Program.Program_id = University_Program.Program_id
                where University_ID = {$id};";

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


        $UniversityPrograms = array();
        while($row = $result->fetch_assoc()) {
            $UniversityPrograms[] = $row;
        }
            


        $collectionArr[] = array("University_Program" => $UniversityPrograms);

        


        //close the connection
        $conn->close();

        return json_encode($collectionArr);
    }




    function getRecommendedUniversities($UserID, $limit) {
        //create new connection
        $conn = initConnection();
        

        $sql = "
        select university.University_ID, university.Name,
        university.Description, Country.Name as CountryName
        from university
            inner join university_program
            on university.University_ID = university_program.University_ID
            inner join Country
            on university.Country_ID = Country.Country_ID
            inner join User
            on
                university.Country_ID = (select (Country_ID) from User where User_ID = {$UserID})
                and university_program.Program_ID = (select (Program_ID) from User where User_ID = {$UserID})
                and university_program.Fee_Total <= (select (Budget_US_$) from User where User_ID = {$UserID})
                
            group by university.University_ID
            {$limit}
            ;
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


        $Universities = array();
        while($row = $result->fetch_assoc()) {
            $Universities[] = $row;
        }

        //collection array
        $collectionArr[] = array(
            "Total_Universities" => (int)$result->num_rows,
            "Page_Number" => (int)$_GET['page']
        );

        $collectionArr[] = $Universities;

        //close the connection
        $conn->close();

        return json_encode($collectionArr);
    }


    function getSavesSearches($UserID) {
        //create new connection
        $conn = initConnection();

        //sql query to retrieve users
        $sql = "select * from search where User_ID = {$UserID};";

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

        $savedSearches = array();
        while($row = $result->fetch_assoc()) {
            $savedSearches[] = $row;
        }

        return json_encode($savedSearches);

        //close the connection
        $conn->close();
    }




?>