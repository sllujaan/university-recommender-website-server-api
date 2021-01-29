<?php


    /**
     * generates message to display on web browsers.
     */
    function prepareMsg($statusText, $msg) {
        return "<h1>$statusText</h1><p>$msg</p>";

    }

    /**
     * generates appropriate message from http status codes.
     */
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
            case 409:
                return prepareMsg("Conflict", $msg);
            case 500:
                return prepareMsg("Internal Server Error", "Please contact to Administrator!");
            default:
                return "";
                break;
        } 
    }

    /**
     * sets response header from http status code.
     */
    function sendResponseStatus($statusCode) {
        $sapitype = php_sapi_name();
        if (substr($sapitype, 0, 3) === 'cgi') {
            header("Access-Control-Allow-Origin: *");
            header("Status: " . $statusCode);
            echo getMessage($statusCode);
        }
        else {
            header("Access-Control-Allow-Origin: *");
            header("HTTP/1.1 " . $statusCode);
            echo getMessage($statusCode);
        }
    }

?>