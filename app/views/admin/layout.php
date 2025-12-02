<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <h3>Admin Panel</h3>
            <ul>
                <li><a href="<?php echo URLROOT; ?>/admin">Dashboard</a></li>
                <li><a href="<?php echo URLROOT; ?>/admin/users">Users</a></li>
                <li><a href="<?php echo URLROOT; ?>/admin/manual_deposits">Manual Deposits</a></li>
                <li><a href="<?php echo URLROOT; ?>/admin/settings">Settings</a></li>
                <li><a href="<?php echo URLROOT; ?>/users/logout">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <?php require_once '../app/views/' . $view . '.php'; ?>
        </div>
    </div>
</body>
</html>
