<?php
// app/controllers/admin_approvals_controller.php

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /index.php?page=login');
    exit;
}

// Include the database connection
require_once BASE_PATH . '/app/db.php';
$conn = get_db_connection();

// For now, we will use a placeholder for pending transactions.
// In a future step, these will be actual transactions awaiting manual approval.
$pending_transactions = [
    ['id' => 1, 'username' => 'testuser', 'amount' => 50.00, 'gateway' => 'Bank Transfer', 'date' => '2023-10-27 10:00:00'],
    ['id' => 2, 'username' => 'anotheruser', 'amount' => 25.00, 'gateway' => 'Cryptocurrency', 'date' => '2023-10-27 11:30:00'],
];

// Include the view
include BASE_PATH . '/app/views/admin/manual_approvals.php';
