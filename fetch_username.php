<?php
// Start the session
// session_start();

// Include the database connection
include "db_connect.php"; 

// Fetch user information
$userId = $_SESSION['user_id'];

// Prepare and execute the query
$sql = "SELECT first_name FROM users WHERE id = :id"; // Use a named parameter
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT); // Bind the user ID as an integer

try {
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $userName = $user['first_name']; // Get the user's real name
    } else {
        $userName = "User"; // Default name if no user is found
    }
} catch (PDOException $e) {
    // Handle error if the query fails
    $userName = "User"; // Default name in case of an error
}

// Close the database connection
$conn = null;

// Return the user's name
echo htmlspecialchars($userName); // Safely output the user's name
?>