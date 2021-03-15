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

?>