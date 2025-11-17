<?php
// app/controllers/logout_controller.php

// Destroy the session
session_start();
session_unset();
session_destroy();

// Redirect to the login page
header('Location: ?page=login');
exit;
