<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to perform this action.";
    exit;
}

$user_id = $_SESSION['user_id'];
$app_id = isset($_GET['app_id']) ? intval($_GET['app_id']) : 0;

try {
    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM application WHERE app_id = :app_id AND user_id = :user_id");
    $stmt->execute(['app_id' => $app_id, 'user_id' => $user_id]);

    // Redirect back to the applications page with a success message
    $_SESSION['message'] = "Application successfully dropped.";
    header("Location: dashboard.php"); // Change to your applications page
    exit;
} catch (PDOException $e) {
    echo "Error deleting application: " . $e->getMessage();
    exit;
}
?>