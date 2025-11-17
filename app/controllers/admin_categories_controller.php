<?php
// app/controllers/admin_categories_controller.php

require_once BASE_PATH . '/app/db.php';

// Ensure user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: ?page=login');
    exit;
}

$action = $_GET['action'] ?? 'list';
$page_title = 'Manage Product Categories';

switch ($action) {
    case 'add':
        // Handle form submission for adding a new category
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if (!empty($name)) {
                $conn = get_db_connection();
                $stmt = $conn->prepare("INSERT INTO product_categories (name, description) VALUES (?, ?)");
                $stmt->bind_param("ss", $name, $description);
                $stmt->execute();
                header('Location: ?page=admin_categories');
                exit;
            }
        }
        break;

    case 'edit':
        // Handle form submission for editing a category
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if (!empty($name) && $id > 0) {
                $conn = get_db_connection();
                $stmt = $conn->prepare("UPDATE product_categories SET name = ?, description = ? WHERE id = ?");
                $stmt->bind_param("ssi", $name, $description, $id);
                $stmt->execute();
                header('Location: ?page=admin_categories');
                exit;
            }
        }
        break;

    case 'delete':
        // Handle category deletion
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $conn = get_db_connection();
            $stmt = $conn->prepare("DELETE FROM product_categories WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header('Location: ?page=admin_categories');
            exit;
        }
        break;
}

// Default action: list categories
$conn = get_db_connection();
$result = $conn->query("SELECT * FROM product_categories ORDER BY name");
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Include the view
include BASE_PATH . '/app/views/admin/categories.php';
