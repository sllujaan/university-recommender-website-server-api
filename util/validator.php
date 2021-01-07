<?php
namespace VALIDATOR;
include_once("../util/util.php");
include_once("../util/response.php");

// Start the session
if(session_id() === '') {
    session_start();
}



function validatePostRequest() {
    if($_SERVER["REQUEST_METHOD"] !== "POST") {
        sendResponseStatus(400);
        exit();
    }
}


function validateLoginParams() {
    if(empty($_POST["name"]) || empty($_POST["password"])) {
        sendResponseStatus(400);
        exit();
    }
}


function validateAuthParams() {
    $reqestData = getRequestData();
    if(empty($reqestData["session_id"]) || empty($reqestData["user_id"])) {
        sendResponseStatus(400);
        exit();
    }
}




?>