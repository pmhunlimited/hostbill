<?php
// Start the session
session_start();

// Include the configuration file
require_once '../config/config.php';

// Include the functions file
require_once '../app/helpers/functions.php';

// Include the session helper file
require_once '../app/helpers/session_helper.php';

// Include the CSRF helper file
require_once '../app/helpers/csrf_helper.php';

// Include the Mail helper file
require_once '../app/helpers/mail_helper.php';

// Include the Database file
require_once '../app/Database.php';

// Get the requested URL
$request_uri = $_SERVER['REQUEST_URI'];

// Remove the query string from the URL
$request_uri = strtok($request_uri, '?');

// Remove the base directory from the URL
$base_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$request_uri = str_replace($base_dir, '', $request_uri);

// Remove the leading and trailing slashes from the URL
$request_uri = trim($request_uri, '/');

// If the URL is empty, set it to 'home'
if (empty($request_uri)) {
    $request_uri = 'home';
}

// Split the URL into parts
$url_parts = explode('/', $request_uri);

// Get the controller and method from the URL
$controller = !empty($url_parts[0]) ? $url_parts[0] : 'home';
$method = !empty($url_parts[1]) ? $url_parts[1] : 'index';

// Check if the controller file exists
if (file_exists('../app/controllers/' . $controller . '.php')) {
    // Include the controller file
    require_once '../app/controllers/' . $controller . '.php';

    // Create a new instance of the controller
    $controller = new $controller();

    // Check if the method exists in the controller
    if (method_exists($controller, $method)) {
        // Call the method
        $controller->$method();
    } else {
        // Show a 404 error
        show_404();
    }
} else {
    // Show a 404 error
    show_404();
}
