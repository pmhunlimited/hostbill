<?php
// HostBill - Main Application Entry Point

// Start a session
session_start();

// Basic routing logic
$page = $_GET['page'] ?? 'home';

// Define the base path
define('BASE_PATH', dirname(__DIR__));

// Route to the appropriate controller or view
switch ($page) {
    case 'login':
        include BASE_PATH . '/app/controllers/login_controller.php';
        break;
    case 'logout':
        include BASE_PATH . '/app/controllers/logout_controller.php';
        break;
    case 'clientarea':
        include BASE_PATH . '/app/controllers/clientarea_controller.php';
        break;
    case 'admin':
        include BASE_PATH . '/app/controllers/admin_controller.php';
        break;
    default:
        // For now, the home page will be the login page
        include BASE_PATH . '/app/controllers/login_controller.php';
        break;
}
