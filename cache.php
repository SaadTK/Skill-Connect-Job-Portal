<?php
require 'vendor/autoload.php';

$redis = new Predis\Client();
$conn = 'mysql:host=localhost;dbname=job_portal';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($conn, $username, $password);

    if (isset($_GET['refresh']) && $_GET['refresh'] === 'true') {
        $stmt = $pdo->prepare("
            SELECT j.job_id, j.job_title, j.company_name, j.description, j.location, j.salary, j.timing, j.deadline
            FROM job j
            WHERE j.visits >= 5
            ORDER BY j.visits DESC
            LIMIT 5
        ");
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($jobs) {
            $redis->set('frequently_visited_jobs', json_encode($jobs));
            $redis->set('frequently_visited_jobs_timestamp', time());
            $redis->expire('frequently_visited_jobs', 24 * 3600);

            header('Content-Type: application/json');
            echo json_encode(['success' => 'Cache refreshed!', 'data' => $jobs]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No jobs found to cache']);
        }
    } else {
        $cacheData = $redis->get('frequently_visited_jobs');
        if ($cacheData) {
            header('Content-Type: application/json');
            echo $cacheData;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No data in Redis cache']);
        }
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Redis error: ' . $e->getMessage()]);
}
?>