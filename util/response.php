<?php


function sendResponseStatus($statusCode) {
    $sapitype = php_sapi_name();
    if (substr($sapitype, 0, 3) === 'cgi')
        return header("Status: " . $statusCode); 
    else
        return header("HTTP/1.1 " . $statusCode);
}



?>