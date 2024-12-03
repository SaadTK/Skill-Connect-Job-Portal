<?php
session_start();

include "db_connect.php";

if (isset($_GET['app_id'])) {
    $app_id = intval($_GET['app_id']);

    // Fetch resume data, type, and name from the database
    $sql = "SELECT resume, resume_type, resume_name FROM application WHERE app_id = :app_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':app_id', $app_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $resumeData = $result['resume'];
        $resumeType = $result['resume_type'];
        $resumeName = $result['resume_name'];

        // Set headers to download the file
        header("Content-Type: $resumeType");
        header("Content-Disposition: attachment; filename=\"$resumeName\"");
        echo $resumeData;
    } else {
        echo "No resume found.";
    }
} else {
    echo "Invalid application ID.";
}
?>