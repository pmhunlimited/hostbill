<?php
// app/controllers/add_funds_controller.php

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php?page=login');
    exit;
}

// Include the database connection
require_once BASE_PATH . '/app/db.php';
$conn = get_db_connection();

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $user_id = $_SESSION['user_id'];

    if ($amount && $amount > 0) {
        $conn->begin_transaction();
        try {
            // Check if user has a credit record
            $stmt = $conn->prepare("SELECT id, balance FROM client_credits WHERE user_id = ? FOR UPDATE");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $credit_record = $result->fetch_assoc();
            $stmt->close();

            if ($credit_record) {
                // Update existing balance
                $new_balance = $credit_record['balance'] + $amount;
                $stmt = $conn->prepare("UPDATE client_credits SET balance = ? WHERE user_id = ?");
                $stmt->bind_param("di", $new_balance, $user_id);
                $stmt->execute();
                $stmt->close();
            } else {
                // Create new credit record
                $stmt = $conn->prepare("INSERT INTO client_credits (user_id, balance) VALUES (?, ?)");
                $stmt->bind_param("id", $user_id, $amount);
                $stmt->execute();
                $stmt->close();
            }

            // Create a transaction record
            $description = "Added funds to account.";
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, date, description, amount, type) VALUES (?, NOW(), ?, ?, 'Credit')");
            $stmt->bind_param("isd", $user_id, $description, $amount);
            $stmt->execute();
            $stmt->close();

            $conn->commit();

            // Redirect to avoid form resubmission
            header('Location: /index.php?page=add_funds&success=1');
            exit;

        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            $error_message = "An error occurred. Please try again.";
        }
    } else {
        $error_message = "Please enter a valid amount.";
    }
}

// Get the user's current credit balance
$stmt = $conn->prepare("SELECT balance FROM client_credits WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$credit_balance = $result->fetch_assoc()['balance'] ?? 0.00;
$stmt->close();

// Get enabled payment gateways
$gateways_result = $conn->query("SELECT * FROM payment_gateways WHERE is_enabled = 1");
$gateways = [];
if ($gateways_result->num_rows > 0) {
    while($row = $gateways_result->fetch_assoc()) {
        $gateways[] = $row;
    }
}

// Include the view
include BASE_PATH . '/app/views/client/add_funds.php';
