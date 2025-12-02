<?php
  // Forward all requests to the public directory's front controller.
  // This ensures that the application's bootstrap and routing are always engaged.
  require_once __DIR__ . '/public/index.php';
