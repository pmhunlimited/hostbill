<?php
// app/db.php

// Include the database configuration
require_once dirname(__DIR__) . '/config/config.php';

function get_db_connection() {
    static $conn;

    if ($conn === null) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            // In a real application, you'd want to handle this more gracefully
            die("Connection failed: " . $conn->connect_error);
        }
    }

    return $conn;
}
