<?php
include 'db_connect.php';

// Get the search filters and pagination details
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 4;

// Calculate the offset for pagination
$offset = ($page - 1) * $limit;

// Query to fetch seekers based on filters
$sql = "SELECT * FROM seekers WHERE name LIKE :keyword AND location LIKE :location LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
$stmt->bindValue(':location', "%$location%", PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Fetch seekers
$seekers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total number of seekers for pagination
$totalSql = "SELECT COUNT(*) FROM seekers WHERE name LIKE :keyword AND location LIKE :location";
$totalStmt = $conn->prepare($totalSql);
$totalStmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
$totalStmt->bindValue(':location', "%$location%", PDO::PARAM_STR);
$totalStmt->execute();
$totalSeekers = $totalStmt->fetchColumn();

// Calculate total pages
$totalPages = ceil($totalSeekers / $limit);

// Return seekers and pagination details as JSON
echo json_encode([
    'data' => $seekers,
    'totalPages' => $totalPages
]);
?>