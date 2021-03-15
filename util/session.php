<?php

    namespace SESSION;
    include_once("response.php");

    /*Session Time*/
    define("SESSION_TIME", 60*60); //60*60 = 1 hour


    // Start the session
    if(session_id() === '') {
        session_start();
    }


    /**
     * creates a new session for a user
     */
    function createNewSession($userID) {
        $client = array("session_id"=> null, "user_id"=> null);
        $client["session_id"] = md5(uniqid(rand(), true));
        $client["user_id"] = $userID;

        //check if session_id already exists, because the statement md5(uniqid(rand(), true))
        //may generate duplicate key in future
        if(!empty($_SESSION[$client["session_id"]])) {
            sendResponseStatus(500);
            exit();
        }

        $_SESSION[$client["session_id"]] = $client["user_id"];
        $_SESSION[$client["session_id"] . "_created"] = time();
        return json_encode($client);
    }


    /**
     * removes the session from session storage.
     */
    function clearSession($session_id) {
        unset($_SESSION[$_SESSION[$session_id] . "_created"]);
        unset($_SESSION[$session_id]);
    }

    /**
     * validates a session for a user
     * if session does not exits for the user it sends appropriate response.
     */
    function validateSession($session_id, $user_id) {

        if(!is_string($session_id) || !is_integer((int)$user_id)) {
            sendResponseStatus(400);    //400 bad request
            exit();
        }

        //check if no session exists for the user
        if(empty($_SESSION[$session_id])) {
            sendResponseStatus(401);    //401 unauthorized
            exit();
        }

        //check if session id is valid
        if((int)$_SESSION[$session_id] !== (int)$user_id) {
            clearSession($session_id);
            sendResponseStatus(401);    //401 unauthorized
            exit();
        }

        //check if session expired
        if((time() - $_SESSION[$session_id . "_created"]) > SESSION_TIME) {
            clearSession($session_id);
            sendResponseStatus(408);    //408 request timeout
            exit();
        }
    }


    //data in coming through post request
    function validateSession_POST() {
        if(empty($_POST["session_id"]) || empty($_POST["user_id"])) {
            sendResponseStatus(505);
            exit();
        }
        validateSession($_POST["session_id"], $_POST["user_id"]);
    }

    //data in coming through request body
    function validateSession_BODY() {
        $requestData = \UTIL\getRequestData();
        $session_id = $requestData["session_id"];
        $user_id = $requestData["user_id"];
        validateSession($session_id, $user_id);
    }

?>