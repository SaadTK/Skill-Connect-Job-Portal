<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$testimonial = trim($_POST['testimonial']);

$stmt = $conn->prepare("UPDATE users SET testimonial = :testimonial WHERE user_id = :user_id");
$stmt->execute(['testimonial' => $testimonial, 'user_id' => $user_id]);

$role = $_SESSION['role'];


if ($role == 0) {
    header("Location: dashboard.php?testimonial_success=1");
} elseif ($role == 1) {

    header("Location: recruiter_dashboard.php?testimonial_success=1");
} else {

    header("Location: login.php");
}

exit;
?>