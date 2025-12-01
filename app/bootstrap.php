<?php
  // Load Config
  if(file_exists('../app/config/config.php')){
    require_once '../app/config/config.php';
  } else {
    // Define fallback constants if config doesn't exist
    define('APPROOT', dirname(dirname(__FILE__)));
    // Dynamically determine URL Root
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://www." : "http://www.";
    $host = $_SERVER['HTTP_HOST'];
    $script_name = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    define('URLROOT', $protocol . $host . $script_name);
    define('SITENAME', 'VTU Platform');
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
