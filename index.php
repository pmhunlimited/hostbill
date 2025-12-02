<?php
  // Load Config
  if(file_exists('app/config/config.php')){
    require_once 'app/config/config.php';
  } else {
    // Define fallback constants if config doesn't exist
    define('APPROOT', dirname(__FILE__) . '/app');
    // Dynamically determine URL Root
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://www." : "http://www.";
    $host = $_SERVER['HTTP_HOST'];
    $script_name = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    define('URLROOT', $protocol . $host . $script_name);
    define('SITENAME', 'VTU Platform');
  }

  // Load Helpers
  require_once 'app/helpers/url_helper.php';
  require_once 'app/helpers/session_helper.php';
  require_once 'app/helpers/csrf_helper.php';
  require_once 'app/helpers/mail_helper.php';

  // Load Libraries
  require_once 'app/libraries/Controller.php';
  require_once 'app/libraries/Database.php';

  // Check if installed, if not, redirect to installer
  if(!file_exists('app/config/config.php')){
    header('Location: ' . URLROOT . '/installer');
    exit;
  }

  // URL Routing
  $currentController = 'Pages';
  $currentMethod = 'index';
  $params = [];

  if(isset($_GET['url'])){
    $url = rtrim($_GET['url'], '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);
  } else {
    $url = [];
  }

  if(isset($url[0]) && file_exists('app/controllers/' . ucwords($url[0]). '.php')){
    $currentController = ucwords($url[0]);
    unset($url[0]);
  }

  require_once 'app/controllers/'. $currentController . '.php';
  $currentController = new $currentController;

  if(isset($url[1]) && method_exists($currentController, $url[1])){
    $currentMethod = $url[1];
    unset($url[1]);
  }

  $params = $url ? array_values($url) : [];
  call_user_func_array([$currentController, $currentMethod], $params);
