<?php

namespace UTIL;
    /**
     * retrives data from request body.
     */
    function getRequestData() {
        return json_decode(file_get_contents('php://input'), true);
    }

?>