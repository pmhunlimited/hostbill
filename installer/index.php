<?php
// A simple router for the installer steps
$step = $_GET['step'] ?? 1;

switch ($step) {
    case 1:
        include 'welcome.php';
        break;
    case 2:
        include 'database.php';
        break;
    case 3:
        include 'admin.php';
        break;
    case 4:
        include 'complete.php';
        break;
    default:
        include 'welcome.php';
        break;
}
