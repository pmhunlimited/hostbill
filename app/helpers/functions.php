<?php
// Function to show a 404 error
function show_404()
{
    header('HTTP/1.0 404 Not Found');
    include_once '../app/views/404.php';
    exit();
}

// Function to redirect to a new page
function redirect($page)
{
    header('Location: ' . URLROOT . '/' . $page);
    exit();
}
