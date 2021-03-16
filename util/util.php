<?php

namespace UTIL;
    /**
     * retrives data from request body.
     */
    function getRequestData() {
        return json_decode(file_get_contents('php://input'), true);
    }


    function generateLimitFromPageNumber($pageNumber) {
        $mysqlRowStartIndex = (10 * $pageNumber) - 10;
        $mysqlRowEndIndex = 10 * $pageNumber;
        $limit = "limit {$mysqlRowStartIndex}, {$mysqlRowEndIndex}";
        return $limit;
    }


    function validatePageNumberURL() {
         /**
         * checks if country page is present in the request.
         */
        if(!isset($_GET['page'])) {
            //no page found in url
            sendResponseStatus(400);
            echo "No id found in URL.";
            exit();
        }

        /**
         * checks if the country page in the request is a number.
         */
        if(filter_var($_GET['page'], FILTER_VALIDATE_INT) === false) {
            sendResponseStatus(400);
            echo "Invalid page in URL.";
            exit();
        }

        /**
         * check valid values i.e negative values
         */
        if($_GET['page'] < 1) {
            sendResponseStatus(400);
            echo "Invalid page range.";
            exit();
        }
    }

?>