<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the job_id from the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Start a transaction
    $conn->beginTransaction();

    try {
        // Delete all applications associated with the job
        $stmt_delete_applications = $conn->prepare("DELETE FROM application WHERE job_id = :job_id");
        $stmt_delete_applications->execute(['job_id' => $job_id]);

        // Now delete the job
        $stmt_delete_job = $conn->prepare("DELETE FROM job WHERE job_id = :job_id AND user_id = :user_id");
        $stmt_delete_job->execute([
            'job_id' => $job_id,
            'user_id' => $_SESSION['user_id']
        ]);

        // Commit the transaction
        $conn->commit();

        // Redirect back with a success message
        $_SESSION['message'] = "Job and associated applications deleted successfully.";
        header("Location: recruiter_dashboard.php");
        exit;
    } catch (Exception $e) {
        // Roll back the transaction in case of error
        $conn->rollBack();
        $_SESSION['error'] = "An error occurred while deleting the job: " . $e->getMessage();
        header("Location: recruiter_dashboard.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid job ID.";
    header("Location: recruiter_dashboard.php");
    exit;
}
?>