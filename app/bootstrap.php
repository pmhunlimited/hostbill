<?php
  // Require composer autoloader
  require_once dirname(__DIR__) . '/vendor/autoload.php';

  // Load Config
  $config_path = dirname(__DIR__) . '/config/config.php';

  // Set APPROOT
  define('APPROOT', __DIR__);

  if(file_exists($config_path)){
    require_once $config_path;
  } else {
    // If config.php does not exist, redirect to the installer
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script_path = dirname($_SERVER['SCRIPT_NAME']);

    // Remove /public from path if present
    if (substr($script_path, -7) === '/public') {
        $base_path = substr($script_path, 0, -7);
    } else {
        $base_path = $script_path;
    }

    // If we are at the root, base_path might be '/' or '\'. We want an empty string for that.
    if ($base_path === '/' || $base_path === '\\') {
        $base_path = '';
    }

    $url_root = rtrim($protocol . $host . $base_path, '/');
    header('Location: ' . $url_root . '/installer');
    exit();
  }

  // Load Helpers
  require_once __DIR__ . '/helpers/url_helper.php';
  require_once __DIR__ . '/helpers/session_helper.php';
  require_once __DIR__ . '/helpers/csrf_helper.php';
  require_once __DIR__ . '/helpers/mail_helper.php';

  // Load Libraries
  require_once __DIR__ . '/libraries/Core.php';
  require_once __DIR__ . '/libraries/Controller.php';
  require_once __DIR__ . '/libraries/Database.php';

  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once __DIR__ . '/libraries/' . $className . '.php';
  });
