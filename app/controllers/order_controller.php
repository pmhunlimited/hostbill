<?php
// app/controllers/order_controller.php

require_once BASE_PATH . '/app/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ?page=login');
    exit;
}

$page_title = 'Order New Service';

$conn = get_db_connection();

// Fetch all categories
$category_result = $conn->query("SELECT * FROM product_categories ORDER BY name");
$categories = $category_result->fetch_all(MYSQLI_ASSOC);

// Fetch all products and group them by category
$product_result = $conn->query("SELECT * FROM products ORDER BY name");
$products_by_category = [];
while ($product = $product_result->fetch_assoc()) {
    $products_by_category[$product['category_id']][] = $product;
}

// Include the view
include BASE_PATH . '/app/views/client/order.php';
