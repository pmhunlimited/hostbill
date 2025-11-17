<?php
// app/controllers/admin_controller.php

// Ensure user is logged in and is an administrator (user_id 1 for now)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: ?page=login');
    exit;
}

$page_title = 'Admin Dashboard';
include BASE_PATH . '/templates/header.php';
?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title">Admin Dashboard</h1>
        <p class="lead">Welcome, Administrator!</p>
        <p>This is the secure admin area. You can manage the application from here.</p>

        <!-- Admin Navigation -->
        <div class="my-4">
            <a href="?page=admin_categories" class="btn btn-primary">Manage Product Categories</a>
            <a href="?page=admin_products" class="btn btn-primary">Manage Products</a>
        </div>

        <!-- Example Stat Cards -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">150</h5>
                        <p class="card-text">Active Clients</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 class="card-title">$1,234</h5>
                        <p class="card-text">Monthly Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3" style="border-radius: 15px;">
                    <div classs="card-body">
                        <h5 class="card-title">5</h5>
                        <p class="card-text">Open Tickets</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include BASE_PATH . '/templates/footer.php';
