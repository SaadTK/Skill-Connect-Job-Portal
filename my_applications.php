<?php
include 'db_connect.php';




// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to view your applications.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch job applications
try {
    $stmt = $conn->prepare("
        SELECT a.app_id, j.job_title, a.status
        FROM application a
        JOIN job j ON a.job_id = j.job_id
        WHERE a.user_id = :user_id
    ");
    $stmt->execute(['user_id' => $user_id]);
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching applications: " . $e->getMessage();
    exit;
}

// Status badge colors
$status_badges = [
    "Applied" => "success",
    "Rejected" => "danger",
    "Interview Scheduled" => "warning text-dark",
    "pending" => "warning text-dark"
];
?>

<div class="card p-3 mx-auto application-status" style="max-width: 800px;">
    <div class="card-header">My Applications</div>
    <div class="card-body">
        <ul class="list-group">
            <?php if (!empty($applications)): ?>
                <?php foreach ($applications as $application): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($application['job_title']); ?>
                        <div>
                            <span class="badge bg-<?php echo $status_badges[$application['status']] ?? 'secondary'; ?>">
                                <?php echo htmlspecialchars($application['status']); ?>
                            </span>
                            <a href="drop_application.php?app_id=<?php echo htmlspecialchars($application['app_id']); ?>"
                                class="btn btn-danger btn-sm ms-2"
                                onclick="return confirm('Are you sure you want to drop this application?');">Drop</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No applications found.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>