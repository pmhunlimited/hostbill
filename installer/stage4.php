<?php
// Get the database credentials from the session
$db_host = $_SESSION['db_host'];
$db_user = $_SESSION['db_user'];
$db_pass = $_SESSION['db_pass'];
$db_name = $_SESSION['db_name'];

// Create the config file
$config_file = dirname(__DIR__) . '/config/config.php';

// Calculate URLROOT
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script_path = dirname($_SERVER['SCRIPT_NAME']);

// Remove /installer from path if present
if (substr($script_path, -10) === '/installer') {
    $base_path = substr($script_path, 0, -10);
} else {
    $base_path = $script_path;
}

// If we are at the root, base_path might be '/' or '\'. We want an empty string for that.
if ($base_path === '/' || $base_path === '\\') {
    $base_path = '';
}

$url_root = rtrim($protocol . $host . $base_path, '/');

$config_data = "<?php
// Database credentials
define('DB_HOST', '$db_host');
define('DB_USER', '$db_user');
define('DB_PASS', '$db_pass');
define('DB_NAME', '$db_name');

// URL Root
define('URLROOT', '$url_root');

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
