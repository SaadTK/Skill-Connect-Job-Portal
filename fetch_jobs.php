<?php
include 'db_connect.php';

// Get query parameters
$cat_id = isset($_GET['cat_id']) ? (int) $_GET['cat_id'] : 0; //if we GET cat_id then we include it in $cat_id or we include 0
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '%';
$location = isset($_GET['location']) ? '%' . $_GET['location'] . '%' : '%';
$offset = ($page - 1) * $limit;

// SQL query with filters, pagination
$sql = "SELECT job_id, job_title, description, location, salary, timing, deadline
        FROM job
        WHERE cat_id = :cat_id
        AND (job_title LIKE :keyword OR :keyword = '')
        AND (location LIKE :location OR :location = '')
        LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
$stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$stmt->bindParam(':location', $location, PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output JSON data
echo json_encode($jobs);
?>