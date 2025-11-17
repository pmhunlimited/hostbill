<?php
// app/cron/cron_invoice_generator.php

// This script should be executed by a cron job
// e.g., 0 1 * * * /usr/bin/php /path/to/hostbill/app/cron/cron_invoice_generator.php

// Define the base path if not already defined
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(dirname(__DIR__)));
}

// Include the database connection
require_once BASE_PATH . '/app/db.php';
$conn = get_db_connection();

echo "Cron job started: Generating invoices...\n";

// Get all active services that are due for renewal in the next 7 days
// and for which an invoice has not already been generated.
$sql = "SELECT s.*, p.name as product_name, p.price_monthly
        FROM services s
        JOIN products p ON s.product_id = p.id
        WHERE s.status = 'Active'
        AND s.next_due_date <= CURDATE() + INTERVAL 7 DAY
        AND NOT EXISTS (
            SELECT 1 FROM invoices i
            JOIN invoice_items ii ON i.id = ii.invoice_id
            WHERE i.user_id = s.user_id
            AND ii.description LIKE CONCAT('%', p.name, '%')
            AND i.due_date = s.next_due_date
        )";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($service = $result->fetch_assoc()) {
        $user_id = $service['user_id'];
        $due_date = $service['next_due_date'];
        $product_name = $service['product_name'];
        $price = $service['price_monthly'];

        // Create the invoice
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("INSERT INTO invoices (user_id, date_created, due_date, total, status) VALUES (?, NOW(), ?, ?, 'Unpaid')");
            $stmt->bind_param("isd", $user_id, $due_date, $price);
            $stmt->execute();
            $invoice_id = $stmt->insert_id;
            $stmt->close();

            // Create the invoice item
            $description = "Renewal - {$product_name}";
            $stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, description, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("isd", $invoice_id, $description, $price);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            echo "Generated invoice #{$invoice_id} for user #{$user_id} for service '{$product_name}'\n";

        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            echo "Error generating invoice for user #{$user_id}: " . $exception->getMessage() . "\n";
        }
    }
} else {
    echo "No services are due for renewal.\n";
}

echo "Cron job finished.\n";
