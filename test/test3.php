<?php
    
    include_once("../util/header.php");
    include_once("../DB/connection.php");



    //create new connection
    $conn = initConnection();
    

    try{


        // First of all, let's begin a transaction
        $conn->begin_transaction();

        $sql = "insert into user (name) values ('jake5');";
        $result = $conn->query($sql);

        if(!$result) {
            throw new Exception($conn);
        }

        $sql = "insert into user (name) values ('jake6');";
        $result = $conn->query($sql);

        if(!$result) {
            throw new Exception($conn);
        }

        $conn->commit();

        echo "commited.<br>";
    
    }
    catch(Exception $e) {
        echo "exception.<br>";
        $conn->rollback();
        echo $e->getMessage(); 

    }

    //close the connection
    $conn->close();
    

?>