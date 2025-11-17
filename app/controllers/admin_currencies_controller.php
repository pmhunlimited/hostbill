<?php
// app/controllers/admin_currencies_controller.php

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /index.php?page=login');
    exit;
}

// Include the database connection
require_once BASE_PATH . '/app/db.php';
$conn = get_db_connection();

// Handle form submission for updating currencies and settings
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['base_currency'])) {
        $base_currency = $_POST['base_currency'];
        $conn->query("UPDATE settings SET value = '{$conn->real_escape_string($base_currency)}' WHERE setting = 'base_currency'");
        $conn->query("UPDATE currencies SET is_base = 0");
        $conn->query("UPDATE currencies SET is_base = 1 WHERE code = '{$conn->real_escape_string($base_currency)}'");
    }

    if (isset($_POST['usd_conversion_rate'])) {
        $usd_conversion_rate = (float)$_POST['usd_conversion_rate'];
        $conn->query("UPDATE settings SET value = '{$usd_conversion_rate}' WHERE setting = 'usd_conversion_rate'");
    }

    // Redirect to avoid form resubmission
    header('Location: /index.php?page=admin_currencies&success=1');
    exit;
}

// Get all currencies
$currencies_result = $conn->query("SELECT * FROM currencies");
$currencies = [];
if ($currencies_result->num_rows > 0) {
    while($row = $currencies_result->fetch_assoc()) {
        $currencies[] = $row;
    }
}

// Get settings
$settings_result = $conn->query("SELECT * FROM settings");
$settings = [];
if ($settings_result->num_rows > 0) {
    while($row = $settings_result->fetch_assoc()) {
        $settings[$row['setting']] = $row['value'];
    }
}

// Include the view
include BASE_PATH . '/app/views/admin/manage_currencies.php';
