<?php
  // Load Config
  if(file_exists('../app/config/config.php')){
    require_once '../app/config/config.php';
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
  require_once 'helpers/url_helper.php';
  require_once 'helpers/session_helper.php';
  require_once 'helpers/csrf_helper.php';
  require_once 'helpers/mail_helper.php';

  // Load Libraries
  require_once 'libraries/Core.php';
  require_once 'libraries/Controller.php';
  require_once 'libraries/Database.php';

  // Autoload Core Libraries
  spl_autoload_register(function($className){
    require_once 'libraries/' . $className . '.php';
  });
