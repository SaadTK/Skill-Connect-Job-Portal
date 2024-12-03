<?php

session_start();

// Get job_id from the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id']; // Get job_id from URL
} else {
    echo "Invalid job ID.";
    exit();
}

// Connect to the database and update the payment status
include 'db_connect.php';

try {
    // Update the job's payment status to 'paid'
    $stmt = $conn->prepare("UPDATE job SET payment_status = 'paid' WHERE job_id = :job_id");
    $stmt->execute(['job_id' => $job_id]);

    echo "<h2>Payment Successful</h2>";
    echo "<p>Your job has been successfully posted and is now live!</p>";

    // Redirect to recruiter_dashboard.php after 2 seconds
    echo '<meta http-equiv="refresh" content="1;url=recruiter_dashboard.php">';

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>