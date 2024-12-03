<?php
// session_start(); 
include 'db_connect.php'; // database connection

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the user's name from the database
    try {
        $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE user_id = :user_id"); // Adjust table and column names as needed
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user data is retrieved
        if ($user) {
            echo htmlspecialchars($user['first_name']); // Display the user's name safely
        } else {
            echo "User not found."; // Fallback message
        }
    } catch (PDOException $e) {
        echo "Error fetching user: " . $e->getMessage();
    }
} else {
    echo "User not logged in."; // Fallback message if no user is logged in
}
?>