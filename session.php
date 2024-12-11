<?php
// Check if the user is logged in
session_start();
if (!isset($_SESSION['userID'])) {
    // Redirect to the login page if not logged in
    header('Location: login.html');
    exit;
}

// Display user session info or handle other tasks as needed
$userID = $_SESSION['userID'];
$username = $_SESSION['username'];
// Get user info from database or perform other tasks
?>
