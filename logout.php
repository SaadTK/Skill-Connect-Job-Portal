<?php
// Start the session to access session variables
session_start();

// Remove all session variables
session_unset();

// Destroy the session entirely
session_destroy();

// Redirect the user to the login page
header("Location: login.php");

// Terminate the script to ensure no further code is executed
exit();
?>
