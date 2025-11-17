<?php
// app/controllers/admin_gateways_controller.php

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /index.php?page=login');
    exit;
}

// Include the database connection
require_once BASE_PATH . '/app/db.php';
$conn = get_db_connection();

// Handle form submission for updating gateways
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_gateways'])) {
    if (isset($_POST['gateways']) && is_array($_POST['gateways'])) {
        foreach ($_POST['gateways'] as $id => $data) {
            $display_name = trim($data['display_name']);
            $instructions = trim($data['instructions']);
            $is_enabled = isset($data['is_enabled']) ? 1 : 0;
            $id = (int)$id;

            $stmt = $conn->prepare("UPDATE payment_gateways SET display_name = ?, instructions = ?, is_enabled = ? WHERE id = ?");
            $stmt->bind_param("ssii", $display_name, $instructions, $is_enabled, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Redirect to avoid form resubmission
    header('Location: /index.php?page=admin_gateways&success=1');
    exit;
}


// Get all payment gateways
$result = $conn->query("SELECT * FROM payment_gateways ORDER BY id ASC");

$gateways = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gateways[] = $row;
    }
}

// Include the view
include BASE_PATH . '/app/views/admin/manage_gateways.php';
