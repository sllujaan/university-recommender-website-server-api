<?php
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


function validateSession() {
    $requestData = getRequestData();
    $session_id = $requestData["session_id"];
    $user_id = $requestData["user_id"];

    if(!is_string($session_id) || !is_string($user_id)) {
        sendResponseStatus(400);    //400 bad request
        exit();
    }

    if(empty($_SESSION[$session_id])) {
        sendResponseStatus(401);    //401 unauthorized
        exit();
    }

    if($_SESSION[$session_id] !== $user_id) {
        sendResponseStatus(401);    //401 unauthorized
        exit();
    }

    //check if session expired
    if((time() - $_SESSION[$session_id . "_created"]) > 10) {
        sendResponseStatus(408);    //408 request timeout
        exit();
    }




}


?>