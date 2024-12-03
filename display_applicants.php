<?php
// Ensure database connection is included and session is started
include 'db_connect.php';

// Get the logged-in recruiter's user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch all job postings for this recruiter
$stmt_jobs = $conn->prepare("SELECT * FROM job WHERE user_id = :user_id");
$stmt_jobs->execute(['user_id' => $user_id]);
$jobs = $stmt_jobs->fetchAll(PDO::FETCH_ASSOC);

// Fetch applicants for each job posted by the recruiter
$job_applicants = [];
foreach ($jobs as $job) {
    $stmt_applicants = $conn->prepare("SELECT a.app_id, a.app_date, a.resume, a.signature, u.first_name, u.last_name, u.email, u.website_url, a.status 
                                   FROM application a 
                                   JOIN users u ON a.user_id = u.user_id
                                   WHERE a.job_id = :job_id");

    $stmt_applicants->execute(['job_id' => $job['job_id']]);
    $job_applicants[$job['job_id']] = $stmt_applicants->fetchAll(PDO::FETCH_ASSOC);
}




?>
<div class="col-md-9">
    <!-- Display Job Postings -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Applicants for Your Jobs</h5>
            <?php foreach ($jobs as $job): ?>
                <div class="job-section mb-4">
                    <h6 class="text-primary mb-3">
                        Job Title: <?php echo htmlspecialchars($job['job_title']); ?>
                        <small class="text-muted">(Job ID: <?php echo htmlspecialchars($job['job_id']); ?>)</small>
                    </h6>
                    <?php if (isset($job_applicants[$job['job_id']]) && count($job_applicants[$job['job_id']]) > 0): ?>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <?php foreach ($job_applicants[$job['job_id']] as $applicant): ?>
                                <div class="col">
                                    <div class="card border-secondary h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-dark mb-2">
                                                <?php echo htmlspecialchars($applicant['first_name'] . ' ' . $applicant['last_name']); ?>
                                            </h6>
                                            <p><strong>Email:</strong> <a
                                                    href="mailto:<?php echo htmlspecialchars($applicant['email']); ?>"><?php echo htmlspecialchars($applicant['email']); ?></a>
                                            </p>
                                            <p><strong>Application Date:</strong>
                                                <?php echo htmlspecialchars($applicant['app_date']); ?></p>
                                            <p><strong>Portfolio:</strong>
                                                <?php if (!empty($applicant['website_url'])): ?>
                                                    <a href="<?php echo htmlspecialchars($applicant['website_url']); ?>"
                                                        target="_blank">View</a>
                                                <?php else: ?>
                                                    <span class="text-muted">Not provided</span>
                                                <?php endif; ?>
                                            </p>
                                            <p><strong>Resume:</strong> <a
                                                    href="download_resume.php?app_id=<?php echo htmlspecialchars($applicant['app_id']); ?>">Download</a>
                                            </p>
                                            <p><strong>Signature:</strong>
                                                <?php if (!empty($applicant['signature'])): ?>
                                                    <img src="<?php echo htmlspecialchars($applicant['signature']); ?>" alt="Signature"
                                                        width="100">
                                                <?php else: ?>
                                                    <span class="text-muted">No signature</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-light">
                                            <form method="POST" action="update_status.php" class="d-flex align-items-center">
                                                <input type="hidden" name="app_id"
                                                    value="<?php echo htmlspecialchars($applicant['app_id']); ?>">
                                                <select name="status" class="form-select me-2" required>
                                                    <option value="pending" <?php echo ($applicant['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="applied" <?php echo ($applicant['status'] === 'applied') ? 'selected' : ''; ?>>Applied</option>
                                                    <option value="rejected" <?php echo ($applicant['status'] === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                    <option value="interview scheduled" <?php echo ($applicant['status'] === 'interview scheduled') ? 'selected' : ''; ?>>
                                                        Interview Scheduled</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">No applicants for this job yet.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


</div>