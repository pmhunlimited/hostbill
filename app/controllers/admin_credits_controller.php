<?php
// app/controllers/admin_credits_controller.php

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /index.php?page=login');
    exit;
}

// Include the database connection
require_once BASE_PATH . '/app/db.php';
$conn = get_db_connection();

// Get all client credit balances
$sql = "SELECT u.email, cc.balance
        FROM users u
        LEFT JOIN client_credits cc ON u.id = cc.user_id
        ORDER BY u.email ASC";
$result = $conn->query($sql);

$clients = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Include the view
include BASE_PATH . '/app/views/admin/credit_balances.php';
