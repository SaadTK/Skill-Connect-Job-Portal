<?php
session_start();
include 'db_connect.php'; // Database connection

// Check if the user is logged in and the form is submitted
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$job_id = $_SESSION['job_id'];
$payment_method = $_POST['payment_method'];
$payment_status = 'Pending'; // Set the initial payment status to Pending
$date = date('Y-m-d H:i:s');

// Insert payment details into the payments table
$stmt = $conn->prepare("INSERT INTO payments (user_id, job_id, payment_method, payment_status, payment_date) 
                        VALUES (:user_id, :job_id, :payment_method, :payment_status, :payment_date)");
$result = $stmt->execute([
    'user_id' => $user_id,
    'job_id' => $job_id,
    'payment_method' => $payment_method,
    'payment_status' => $payment_status,
    'payment_date' => $date
]);

if ($result) {
    // Update job status to paid
    $stmt_update = $conn->prepare("UPDATE job SET payment_status = 'paid' WHERE job_id = :job_id");
    $stmt_update->execute(['job_id' => $_SESSION['job_id']]);

    echo "<p>Payment successful and job posted.</p>";
} else {
    echo "<p>Payment failed. Please try again.</p>";
}

?>