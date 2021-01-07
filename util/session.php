<?php


// Start the session
if(session_id() === '') {
    session_start();
}


function createNewSession($userID) {
    $client = array("session_id"=> null, "user_id"=> null);

    $client["session_id"] = md5(uniqid(rand(), true));
    $client["user_id"] = $userID;

    $_SESSION[$client["session_id"]] = $client["user_id"];
    $_SESSION[$client["session_id"] . "_created"] = time();
    return json_encode($client);

}


function clearSession($session_id) {
    unset($_SESSION[$_SESSION[$session_id] . "_created"]);
    unset($_SESSION[$session_id]);
}



function validateSession() {
    $requestData = getRequestData();
    $session_id = $requestData["session_id"];
    $user_id = $requestData["user_id"];

    if(!is_string($session_id) || !is_integer($user_id)) {
        sendResponseStatus(400);    //400 bad request
        exit();
    }

    //check if no session exists for the user
    if(empty($_SESSION[$session_id])) {
        sendResponseStatus(401);    //401 unauthorized
        exit();
    }

    //check if session id is valid
    if($_SESSION[$session_id] !== $user_id) {
        clearSession($session_id);
        sendResponseStatus(401);    //401 unauthorized
        exit();
    }

    //check if session expired
    if((time() - $_SESSION[$session_id . "_created"]) > 10) {
        clearSession($session_id);
        sendResponseStatus(408);    //408 request timeout
        exit();
    }
    
}






// $client = array("session_id"=> null, "user_id"=> null);

// $client["session_id"] = md5(uniqid(rand(), true));
// $client["user_id"] = hash('md5', '1');



// $_SESSION[$client["session_id"]] = $client["user_id"];



// echo json_encode($client);

// echo "<br><br>";

// $data = json_decode(file_get_contents('php://input'), true);
// if(empty($data["session_id"]) || empty($data["user_id"])) {
//     echo "session_id or user_id is missing.";
// }


?>