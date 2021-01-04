<?php

// Start the session
session_start();

echo md5(uniqid(rand(), true));

echo "<br><br>";


$id = "1";
//$hased_id = password_hash($id, PASSWORD_DEFAULT);
$hased_id = hash('md5', '1');

echo $hased_id;

$_SESSION[$hased_id] = '{data: "your are a user with id 1"}';

if(!isset($_SESSION[$hased_id . "_created"])) {
    echo "<br><br>new sesseion Created.";
    $_SESSION[$hased_id . "_created"] = time();
}



if((time() - $_SESSION[$hased_id . "_created"]) > 5 ) {
    echo "<br><br>";
    echo "Session Expired!";
    unset($_SESSION[$hased_id . "_created"]);
}

// // remove all session variables
// session_unset();
// // destroy the session
// session_destroy();



?>