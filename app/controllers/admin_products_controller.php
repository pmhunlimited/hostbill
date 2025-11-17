<?php
// app/controllers/admin_products_controller.php

require_once BASE_PATH . '/app/db.php';

// Ensure user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: ?page=login');
    exit;
}

$action = $_GET['action'] ?? 'list';
$page_title = 'Manage Products';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price_monthly = $_POST['price_monthly'];
            $price_annually = $_POST['price_annually'];

            $conn = get_db_connection();
            $stmt = $conn->prepare("INSERT INTO products (category_id, name, description, price_monthly, price_annually) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssd", $category_id, $name, $description, $price_monthly, $price_annually);
            $stmt->execute();
            header('Location: ?page=admin_products');
            exit;
        }
        break;

    case 'edit':
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price_monthly = $_POST['price_monthly'];
            $price_annually = $_POST['price_annually'];

            $conn = get_db_connection();
            $stmt = $conn->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price_monthly = ?, price_annually = ? WHERE id = ?");
            $stmt->bind_param("isssdi", $category_id, $name, $description, $price_monthly, $price_annually, $id);
            $stmt->execute();
            header('Location: ?page=admin_products');
            exit;
        }
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $conn = get_db_connection();
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header('Location: ?page=admin_products');
            exit;
        }
        break;
}

// Default action: list products
$conn = get_db_connection();
$result = $conn->query("SELECT p.*, c.name as category_name FROM products p JOIN product_categories c ON p.category_id = c.id ORDER BY c.name, p.name");
$products = $result->fetch_all(MYSQLI_ASSOC);

$category_result = $conn->query("SELECT * FROM product_categories ORDER BY name");
$categories = $category_result->fetch_all(MYSQLI_ASSOC);

// Include the view
include BASE_PATH . '/app/views/admin/products.php';
