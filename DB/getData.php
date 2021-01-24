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


    function getCities($cityID) {
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

        $stmt->bind_param("i", $cityID);

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

    

?>