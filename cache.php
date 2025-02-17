<?php
$conn = 'mysql:host=localhost;dbname=job_portal';
$username = 'root';
$password = '';

try {
    // Establish database connection
    $pdo = new PDO($conn, $username, $password);

    // Check if the refresh parameter is set to true
    if (isset($_GET['refresh']) && $_GET['refresh'] === 'true') {
        // Prepare the SQL query to fetch frequently visited jobs
        $stmt = $pdo->prepare("
            SELECT j.job_id, j.job_title, j.company_name, j.description, j.location, j.salary, j.timing, j.deadline
            FROM job j
            WHERE j.visits >= 5
            ORDER BY j.visits DESC
            LIMIT 5
        ");
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if jobs are found
        if ($jobs) {
            // Return success response with the jobs (No caching in Redis, cache will happen in browser)
            header('Content-Type: application/json');
            echo json_encode(['success' => 'Cache refreshed!', 'data' => $jobs]);
        } else {
            // If no jobs found, return an error message
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No jobs found to cache']);
        }
    } else {
        // If the refresh parameter is not set, return the data to be cached in the browser
        $stmt = $pdo->prepare("
            SELECT j.job_id, j.job_title, j.company_name, j.description, j.location, j.salary, j.timing, j.deadline
            FROM job j
            WHERE j.visits >= 5
            ORDER BY j.visits DESC
            LIMIT 5
        ");
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the fetched jobs
        header('Content-Type: application/json');
        echo json_encode(['data' => $jobs]);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>