<?php
session_start();
include "db_connect.php";

// Check if user is logged in or not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
} else {
    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];
    // Get the job_id from the POST request
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;

    // Debug: Check if job_id is received correctly
    var_dump($_POST);  // Uncomment to debug POST data

    try {
        // Check if the job is already in the wishlist
        $check_stmt = $conn->prepare("SELECT * FROM job_wishlist WHERE user_id = :user_id AND job_id = :job_id");
        $check_stmt->execute(['user_id' => $user_id, 'job_id' => $job_id]);

        if ($check_stmt->rowCount() > 0) {
            // If the job is already in the wishlist
            $_SESSION['message'] = "Job is already in your wishlist.";
        } else {
            // Insert job into wishlist if not already added
            $stmt = $conn->prepare("INSERT INTO job_wishlist (user_id, job_id, date_added) VALUES (:user_id, :job_id, NOW())");
            $stmt->execute(['user_id' => $user_id, 'job_id' => $job_id]);

            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = "Job added to your wishlist successfully.";
            } else {
                $_SESSION['message'] = "Failed to add job to wishlist. Please try again.";
            }
        }

        // Redirect to the job details page with job_id
        header("Location: job_details.php?job_id=" . $job_id);
        exit;
    } catch (PDOException $e) {
        // Catch any SQL or connection errors
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header("Location: job_details.php?job_id=" . $job_id);  // Redirect back to the job page on error
        exit;
    }
}
?>