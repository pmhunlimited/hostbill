<?php
// test_db.php

require_once 'app/db.php';

$conn = get_db_connection();

if ($conn) {
    echo "Database connection successful!\n";
} else {
    echo "Database connection failed.\n";
}
