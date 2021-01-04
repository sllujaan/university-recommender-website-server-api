<?php


// Start the session
if(session_id() === '') {
    session_start();
}


function createNewSession($userID) {
    $client = array("session_id"=> null, "user_id"=> null);

    $client["session_id"] = md5(uniqid(rand(), true));
    $client["user_id"] = hash('md5', $userID);

    $_SESSION[$client["session_id"]] = $client["user_id"];
    $_SESSION[$client["session_id"] . "_created"] = time();
    return json_encode($client);

}


function clearSession($session_id) {
    unset($_SESSION[$session_id]);
    unset($_SESSION[$_SESSION[$session_id] . "_created"]);
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