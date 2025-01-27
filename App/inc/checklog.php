<?php
// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to index if not logged in
    header("Location: index.php");
    exit();
}

function check_login() {
    // Additional checks if needed
}
