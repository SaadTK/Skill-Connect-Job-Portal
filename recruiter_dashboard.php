<?php
session_start();
include 'db_connect.php';
include 'header.php';
include 'welcome.php';

// Check if the user is logged in via session or remember me cookie
if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];

        $stmt = $conn->prepare("SELECT user_id FROM user_tokens WHERE token = :token");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user['user_id']]);
            $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user_id'] = $userDetails['user_id'];
            $_SESSION['email'] = $userDetails['email'];
            $_SESSION['role'] = $userDetails['role'];
            $_SESSION['first_name'] = $userDetails['first_name'];
        } else {
            // If token is invalid, clear the cookie
            setcookie("remember_token", "", time() - 3600, "/", "", true, true);
        }
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in recruiter's user_id from the session
$user_id = $_SESSION['user_id'];

// Fetch all job postings for this recruiter (user_id matches)
$stmt_jobs = $conn->prepare("SELECT * FROM job WHERE user_id = :user_id");
$stmt_jobs->execute(['user_id' => $user_id]);
$jobs = $stmt_jobs->fetchAll(PDO::FETCH_ASSOC);

// Fetch applicants for each job posted by the recruiter
$job_applicants = [];
foreach ($jobs as $job) {
    $stmt_applicants = $conn->prepare("SELECT a.*, u.first_name, u.last_name, u.email FROM application a JOIN users u ON a.user_id = u.user_id WHERE a.job_id = :job_id");
    $stmt_applicants->execute(['job_id' => $job['job_id']]);
    $job_applicants[$job['job_id']] = $stmt_applicants->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- OG Meta Tags -->
    <meta property="og:title" content="Recruiter Dashboard - Skill Connect | Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description"
        content="Dashboard of the job employer. You can check what jobs you have posted, how many and who applied for the jobs. Start finding your next career opportunity today in Bangladesh." />
    <meta property="og:image" content="/assets/img/hero/dashboard2.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property="og:url" content="<?= htmlspecialchars($baseUrl); ?>/recruiter_dashboard.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />

    <title>Recruiter Dashboard - Skill Connect</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/recruiter_dashboard.css">

</head>

<body style="padding-top: 70px;">

    <main class="container">
        <h1 class="mb-4">Recruiter Dashboard</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">Dashboard</a>

                    <!-- Add a new job -->
                    <a href="new_job.php" class="btn btn-success mt-3 w-100"><i class="fas fa-plus-circle"></i> Post A
                        New Job</a>

                    <!-- Display and edit info about the recruiter -->
                    <?php include "recruiter_display.php"; ?>
                </div>

                <!-- Share Your Experience (Testimonial) Form -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Share Your Experience</h5>
                        <form action="save_testimonial.php" method="POST">
                            <div class="mb-3">
                                <textarea name="testimonial" class="form-control" rows="5"
                                    placeholder="Write about your experience with our platform..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Testimonial</button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <!-- Display posted jobs -->
            <div class="col-md-9">
                <h2>Your Posted Jobs</h2>

                <?php if (count($jobs) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jobs as $job): ?>
                                <tr>
                                    <td><?= htmlspecialchars($job['job_title']) ?></td>
                                    <td><?= htmlspecialchars($job['company_name']) ?></td>
                                    <td><?= htmlspecialchars($job['location']) ?></td>
                                    <td><?= htmlspecialchars($job['salary']) ?></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="edit_job.php?job_id=<?= $job['job_id'] ?>"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <!-- Delete Button -->
                                        <a href="delete_job.php?job_id=<?= $job['job_id'] ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You have not posted any jobs yet.</p>
                <?php endif; ?>
                <br>
                <!-- Display who applied for your job -->
                <?php include "display_applicants.php"; ?>
            </div>

        </div>



    </main>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>