<?php
session_start();
include "db_connect.php";


include('header.php');

// GET job_id from URL 
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

// Get the user_id from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

try {
    // Fetch job details with company website URL
    $sql = "SELECT j.*, u.website_url FROM job j 
            JOIN users u ON j.user_id = u.user_id  
            WHERE j.job_id = :job_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Fetch the job details
        $job = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No job found.";
        exit; // Stop further processing if no job is found
    }

    // Increment visits count for the job
    $updateVisits = "UPDATE job SET visits = visits + 1 WHERE job_id = :job_id";
    $stmtVisits = $conn->prepare($updateVisits);
    $stmtVisits->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmtVisits->execute();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}


// Display session message after redirection
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']); // Clear the message after displaying
}



// Close the database connection
$conn = null;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- OG Meta Tags -->
    <meta property="og:title" content="Job Details - Skill Connect | Your Trusted Job Portal in Bangladesh." />
    <meta property="og:description" content="Detailed information about a job. A candidate can apply directly from here. Start finding
    your next career opportunity today in Bangladesh." />
    <meta property="og:image" content="/assets/img/seo/apply.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/job_details.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />





    <title>Job Details - Skill Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/job_details.css">

    <style>
        body {
            padding-top: 76px;
        }

        main {
            padding-top: 2rem;
        }
    </style>
</head>

<body style="padding-top: 70px;">
    <?php include 'header.php'; ?>

    <main class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="mb-4"><?php echo htmlspecialchars($job['job_title']); ?></h1>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Job Overview</h5>
                        <p><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                        <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                        <p><strong>Job Type:</strong> <?php echo htmlspecialchars($job['timing']); ?></p>
                        <p><strong>Posted:</strong> <?php echo htmlspecialchars($job['date']); ?></p>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Job Description</h5>
                        <p><?php echo htmlspecialchars($job['description']); ?></p>

                        <h6 class="mt-4">Responsibilities:</h6>
                        <ul>
                            <?php
                            $responsibilities = explode(',', $job['responsibilities']);
                            foreach ($responsibilities as $responsibility) {
                                echo "<li>" . htmlspecialchars(trim($responsibility)) . "</li>";
                            }
                            ?>
                        </ul>

                        <h6 class="mt-4">Requirements:</h6>
                        <ul>
                            <?php
                            $skills = explode(',', $job['skill']);
                            foreach ($skills as $skill) {
                                echo "<li>" . htmlspecialchars(trim($skill)) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Apply for this job</h5>
                        <form method="POST" action="apply.php" enctype="multipart/form-data">
                            <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['job_id']); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="resume" class="form-label fw-bold">Upload Resume</label>
                                <input type="file" class="form-control" id="resume" name="resume" required>
                            </div>
                            <div class="mb-3">
                                <label for="coverLetter" class="form-label fw-bold">Cover Letter</label>
                                <textarea class="form-control" id="coverLetter" name="coverLetter" rows="4"
                                    required></textarea>
                            </div>

                            <!-- Take signature -->
                            <div class="mb-4">
                                <label for="signature" class="form-label fw-bold">Signature</label>
                                <div class="border p-3 rounded bg-light">
                                    <canvas id="signatureCanvas" width="300" height="100" class="border"
                                        style="border-radius: 8px;"></canvas>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <button type="button" id="clearSignature"
                                        class="btn btn-outline-danger btn-sm">Clear Signature</button>
                                    <small class="text-muted">Draw your signature here</small>
                                </div>


                                <input type="hidden" name="signature" id="signatureInput">
                            </div>


                            <button type="submit" class="btn btn-primary w-100">Submit Application</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Company Information</h5>
                        <p><strong><?php echo htmlspecialchars($job['company_name']); ?></strong>
                            <?php echo htmlspecialchars($job['company_information']); ?>
                        </p>
                        <a href="<?php echo htmlspecialchars($job['website_url']); ?>"
                            class="btn btn-outline-primary w-100" target="_blank">Visit Company Page</a>

                        <!-- Wishlist Button -->
                        <?php if ($user_id): ?>
                            <form method="POST" action="add_to_wishlist.php">
                                <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job['job_id']); ?>">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                                <button type="submit" class="btn btn-outline-success w-100 mt-3">Add to Wishlist</button>
                            </form>
                        <?php else: ?>
                            <p class="text-danger">You must be logged in to add to wishlist.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Initialize canvas
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        // Start drawing
        canvas.addEventListener('mousedown', (e) => {
            drawing = true;
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        });

        // Draw on canvas
        canvas.addEventListener('mousemove', (e) => {
            if (drawing) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            }
        });

        // Stop drawing
        canvas.addEventListener('mouseup', () => {
            drawing = false;
        });

        // Clear the canvas
        document.getElementById('clearSignature').addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('signatureInput').value = ''; // Reset signature input
        });

        // Convert signature to base64 when form is submitted
        document.querySelector('form').addEventListener('submit', (e) => {
            const signatureData = canvas.toDataURL(); // Get signature as base64 string
            document.getElementById('signatureInput').value = signatureData; // Store it in hidden input
        });
    </script>



    <?php include 'footer.php'; ?>
</body>

</html>