<?php
// Include database connection
include 'db_connect.php';

// Get the job_id from the query string
$job_id = isset($_GET['job_id']) ? (int) $_GET['job_id'] : 0;

if ($job_id <= 0) {
    // Invalid job_id; serve a placeholder image
    header("Content-Type: image/png");
    readfile("default_profile.png");
    exit;
}

try {
    // Prepare SQL to fetch the image BLOB from the database
    $sql = "SELECT profile_picture FROM job WHERE job_id = :job_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the image data
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($image && !empty($image['profile_picture'])) {
        // Serve the image BLOB with the correct header
        header("Content-Type: image/jpeg"); // Adjust MIME type as needed
        echo $image['profile_picture'];
    } else {
        // No image found; serve a placeholder
        header("Content-Type: image/png");
        readfile("default_profile.png");
    }
} catch (PDOException $e) {
    // Log error and serve a placeholder image
    error_log("Database error: " . $e->getMessage());
    header("Content-Type: image/png");
    readfile("default_profile.png");
}
?>