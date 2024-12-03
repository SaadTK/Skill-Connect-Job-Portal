<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $app_id = $_POST['app_id'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("UPDATE application SET status = :status WHERE app_id = :app_id");
        $stmt->execute(['status' => $status, 'app_id' => $app_id]);

        // Redirect back to the previous page
        header("Location: recruiter_dashboard.php"); // Change this to the appropriate page
        exit;
    } catch (PDOException $e) {
        echo "Error updating status: " . $e->getMessage();
        exit;
    }
}
?>