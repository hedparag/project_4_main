<?php
session_start(); // Start the session if not already started

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page (or any page)
header("Location: login.php");
exit;
?>
