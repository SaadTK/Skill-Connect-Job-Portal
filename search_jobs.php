<?php
include 'db_connect.php';

$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '';
$location = isset($_GET['location']) ? '%' . $_GET['location'] . '%' : '';

// Set default values for pagination
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;   // Current page number
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 8; // Number of jobs per page
$offset = ($page - 1) * $limit;  // Calculate offset

$sql = "SELECT job_id, company_name, job_title, salary, location, timing, deadline, date
        FROM job
        WHERE (job_title LIKE :keyword OR :keyword = '')  
          AND (location LIKE :location OR :location = '')  
        LIMIT :limit OFFSET :offset";  // Apply limit and offset for pagination

$stmt = $conn->prepare($sql);  // Prepare the SQL statement
$stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$stmt->bindParam(':location', $location, PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output as JSON
echo json_encode($jobs);
?>