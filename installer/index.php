<?php
// Start the session
session_start();

// Get the current stage
$stage = isset($_GET['stage']) ? (int)$_GET['stage'] : 1;

// Include the header
include_once 'header.php';

// Show the current stage
switch ($stage) {
    case 1:
        include_once 'stage1.php';
        break;
    case 2:
        include_once 'stage2.php';
        break;
    case 3:
        include_once 'stage3.php';
        break;
    case 4:
        include_once 'stage4.php';
        break;
    default:
        include_once 'stage1.php';
        break;
}

// Include the footer
include_once 'footer.php';
