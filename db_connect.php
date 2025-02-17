<?php

// Database connection configuration
$host = 'localhost';          // Database host
$dbname = 'job_portal';       // Name of the database
$username = 'root';           // Database username
$password = '';               // Database password

try {
    // Create a new PDO (PHP Data Object) instance for database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If connection is successful, no output is shown
} catch (PDOException $e) {
    // Display an error message if the connection fails
    echo "Connection failed: " . $e->getMessage();
}

?>