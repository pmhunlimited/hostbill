<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data and trim whitespace
    $db_host = trim($_POST['db_host']);
    $db_user = trim($_POST['db_user']);
    $db_pass = trim($_POST['db_pass']);
    $db_name = trim($_POST['db_name']);

    // Create a new MySQLi object
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check for connection errors
    if ($mysqli->connect_error) {
        $error = 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    } else {
        // Create tables
        $sql = "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `pin` varchar(255) NOT NULL,
            `wallet_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
            `bonus_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
            `is_admin` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `transactions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `service` varchar(255) NOT NULL,
            `amount` decimal(10,2) NOT NULL,
            `status` varchar(255) NOT NULL,
            `phone_number` varchar(255) DEFAULT NULL,
            `data_plan_id` int(11) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `data_plans` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `api_plan_id` varchar(255) NOT NULL,
            `price` decimal(10,2) NOT NULL,
            `cost_price` decimal(10,2) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `settings` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `value` text NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `name` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `manual_deposits` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `amount` decimal(10,2) NOT NULL,
            `proof` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL DEFAULT 'pending',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `password_resets` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `token` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
        $mysqli->multi_query($sql);

        // Wait for multi_query to finish
        while ($mysqli->next_result()) {
            if (!$mysqli->more_results()) break;
        }

        // Insert initial data
        $sql = "
        INSERT IGNORE INTO `settings` (`name`, `value`) VALUES
            ('flutterwave_public_key', ''),
            ('flutterwave_secret_key', ''),
            ('paystack_public_key', ''),
            ('paystack_secret_key', ''),
            ('api_key', ''),
            ('smtp_host', ''),
            ('smtp_user', ''),
            ('smtp_pass', ''),
            ('smtp_port', '');

        INSERT IGNORE INTO `data_plans` (`name`, `api_plan_id`, `price`, `cost_price`) VALUES
            ('1 GB', 'ME2U_NG_Data2Share_1621', 597.00, 597.00),
            ('2 GB (Good Offer)', 'ME2U_NG_Data2Share_1622', 1060.00, 1060.00),
            ('3 GB (Better Offer)', 'ME2U_NG_Data2Share_1623', 1365.00, 1365.00),
            ('5 GB (Best Offer)', 'ME2U_NG_Data2Share_2051', 1975.00, 1975.00);
        ";
        $mysqli->multi_query($sql);

        // Store the database credentials in the session
        $_SESSION['db_host'] = $db_host;
        $_SESSION['db_user'] = $db_user;
        $_SESSION['db_pass'] = $db_pass;
        $_SESSION['db_name'] = $db_name;

        // Redirect to the next stage
        header('Location: index.php?stage=3');
        exit();
    }
}
?>

<h1 class="mb-4">Database Setup</h1>
<p>Please enter your database credentials below.</p>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label for="db_host">Database Host</label>
        <input type="text" name="db_host" id="db_host" class="form-control" value="localhost" required>
    </div>
    <div class="form-group">
        <label for="db_user">Database User</label>
        <input type="text" name="db_user" id="db_user" class="form-control" value="hostbill_user" required>
    </div>
    <div class="form-group">
        <label for="db_pass">Database Password</label>
        <input type="password" name="db_pass" id="db_pass" class="form-control" value="password">
    </div>
    <div class="form-group">
        <label for="db_name">Database Name</label>
        <input type="text" name="db_name" id="db_name" class="form-control" value="hostbill" required>
    </div>
    <button type="submit" class="btn btn-primary">Next</button>
</form>
