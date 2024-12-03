<?php
// Start session
session_start();

// Include database connection
include 'db_connect.php'; // Ensure this file sets up $conn as a PDO instance

// Initialize variables
$jobsPosted = 0;
$candidatesPlaced = 0;
$companiesRegistered = 0;

try {
    // Count jobs posted
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM job");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $jobsPosted = $row['count'];

    // Count candidates placed (users with role 0)
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 0");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $candidatesPlaced = $row['count'];

    // Count companies registered (users with role 1)
    $stmt = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $companiesRegistered = $row['count'];

    // Return results as an associative array
    $statistics = [
        'jobsPosted' => $jobsPosted,
        'candidatesPlaced' => $candidatesPlaced,
        'companiesRegistered' => $companiesRegistered,
    ];

    // Set the header to application/json
    header('Content-Type: application/json');
    echo json_encode($statistics);
} catch (PDOException $e) {
    // Handle exceptions
    echo json_encode(['error' => 'Error fetching statistics: ' . $e->getMessage()]);
}
?>