<?php



function prepareMsg($statusText, $msg) {
    return "<h1>$statusText</h1><p>$msg</p>";

}

function getMessage($statusCode) {
    $msg = "";
    switch ($statusCode) {
        case 400:
            return prepareMsg("Bad Request", "You don't have permission to access this resource.");
        default:
            return "";
            break;
    } 
}


function sendResponseStatus($statusCode) {
    $sapitype = php_sapi_name();
    if (substr($sapitype, 0, 3) === 'cgi') {
        echo getMessage($statusCode);
        return header("Status: " . $statusCode); 
    }
    else {
        echo getMessage($statusCode);
        return header("HTTP/1.1 " . $statusCode);
    }
}




?>