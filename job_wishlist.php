<?php
include 'db_connect.php';

// Get the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch the wished jobs for this user
$stmt = $conn->prepare("
    SELECT j.job_id, j.job_title, j.company_name, j.location, j.salary
    FROM job_wishlist w
    JOIN job j ON w.job_id = j.job_id
    WHERE w.user_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$job_wishlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card p-3 mx-auto" style="max-width: 800px;">
    <div class="card-header">Wished Job Listings</div>
    <div class="card-body job-list">
        <ul class="list-group">
            <?php foreach ($job_wishlist as $job): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?php echo htmlspecialchars($job['job_title']); ?></strong><br>
                        <small><?php echo htmlspecialchars($job['company_name']); ?></small><br>
                        <small><?php echo htmlspecialchars($job['location']); ?></small>
                    </div>
                    <a href="job_details.php?job_id=<?php echo htmlspecialchars($job['job_id']); ?>"
                        class="btn btn-primary btn-sm">Apply</a>
                </li>
            <?php endforeach; ?>

            <?php if (empty($job_wishlist)): ?>
                <li class="list-group-item">No jobs in your wishlist yet.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>