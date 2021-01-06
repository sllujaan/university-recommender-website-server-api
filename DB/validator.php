<?php
    include_once("credential.php");
    include_once("connection.php");


    $conn = initConnection(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = "select * from role";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<br>name: ". $row["Name"] . "<br>";
        }
    }
    else {
        echo "0 results";
    }



    $conn->close();

?>