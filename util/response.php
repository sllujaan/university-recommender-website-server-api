<?php



function prepareMsg($statusText, $msg) {
    return "<h1>$statusText</h1><p>$msg</p>";

}

function getMessage($statusCode) {
    $msg = "You don't have permission to access this resource.";
    switch ($statusCode) {
        case 400:
            return prepareMsg("Bad Request", $msg);
        case 401:
            return prepareMsg("Unauthorized", $msg);
        case 408:
            return prepareMsg("Request Timeout", $msg);
        case 404:
            return prepareMsg("Not Found", $msg);
        case 500:
            return prepareMsg("Internal Server Error", "Please contact to Administrator!");
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