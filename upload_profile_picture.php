<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $user_id = $_SESSION['user_id'];

    // Ensure file is uploaded
    if (is_uploaded_file($_FILES['profile_picture']['tmp_name'])) {
        $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);

        // Update profile picture in the database
        $sql = "UPDATE users SET profile_picture = :profile_picture WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':profile_picture', $profile_picture, PDO::PARAM_LOB);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile picture updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to upload the profile picture.";
        }
    } else {
        $_SESSION['error'] = "No file uploaded.";
    }

    header("Location: dashboard.php");
    exit();
}
?>