<?php
// Get the database credentials from the session
$db_host = $_SESSION['db_host'];
$db_user = $_SESSION['db_user'];
$db_pass = $_SESSION['db_pass'];
$db_name = $_SESSION['db_name'];

// Create the config file
$config_file = "../app/config/config.php";
$config_data = "<?php
// Database credentials
define('DB_HOST', '$db_host');
define('DB_USER', '$db_user');
define('DB_PASS', '$db_pass');
define('DB_NAME', '$db_name');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// URL Root
define('URLROOT', ''); // This will be set dynamically

// Site Name
define('SITENAME', 'VTU');
";
file_put_contents($config_file, $config_data);
?>

<h1 class="mb-4">Installation Complete</h1>
<p>Congratulations! You have successfully installed the VTU script.</p>

<div class="alert alert-warning">
    <strong>Important:</strong> Please delete the 'installer' directory before you start using the script.
</div>

<a href="../public" class="btn btn-primary">Go to Login</a>
