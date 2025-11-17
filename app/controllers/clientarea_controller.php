<?php
// app/controllers/clientarea_controller.php

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ?page=login');
    exit;
}

$page_title = 'Client Dashboard';
include BASE_PATH . '/templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">Client Dashboard</h1>
        <p class="lead">Welcome to your dashboard!</p>
        <p>You can manage your account and services from here.</p>

        <!-- Client Navigation -->
        <div class="my-4">
            <a href="?page=order" class="btn btn-success">Order New Service</a>
        </div>

        <!-- Example Stat Cards -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">2</h5>
                        <p class="card-text">Active Services</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">1</h5>
                        <p class="card-text">Unpaid Invoices</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">3</h5>
                        <p class="card-text">Support Tickets</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include BASE_PATH . '/templates/footer.php';
