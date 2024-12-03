<?php
session_start();
include "db_connect.php";
include "./header.php";
include "welcome.php";


//check remember_token for cookies
// Check if the user is already logged in
if (!isset($_SESSION['user_id'])) {

    //cookie
    // Check for the remember token for the cookie
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];

        // Query the database for the token
        $stmt = $conn->prepare("SELECT user_id FROM user_tokens WHERE token = :token");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If a user is found with the token, log them in
        if ($user) {
            // Fetch user details
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user['user_id']]);
            $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set session variables
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

// Continue with page logic
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if user is not logged in
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- OG Meta Tags -->
    <meta property="og:title" content="Job Seeker Dashboard - Skill Connect | Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description"
        content="Manage your job applications, save job listings, and update your profile on Skill Connect's Job Seeker Dashboard. Start finding your next career opportunity today in Bangladesh." />
    <meta property="og:image" content="/assets/img/seo/dashboard.php" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "http://skillconnect.webhop.me";
    }
    ?>
    <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/dahsboard.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />


    <title>Job Seeker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body style="padding-top: 70px;">

    <!-- Profile Section -->
    <div class="profile-header d-flex align-items-center">
        <?php
        // Fetch profile picture from the database
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT profile_picture FROM users WHERE user_id = :user_id"; // Use a prepared statement
        $stmt = $conn->prepare($sql); // Prepare the SQL statement
        $stmt->bindParam(':user_id', $user_id); // Bind the user_id parameter
        $stmt->execute(); // Execute the statement
        
        // Fetch the result as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display the image if it exists
        if ($user && $user['profile_picture']) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($user['profile_picture']) . '" alt="User Image" class="rounded-circle" width="150" >';
        } else {
            echo '<img src="assets/img/default_profile.png" alt="Default Image" class="rounded-circle" width="150">';
        }
        ?>
        <div class="ms-3">
            <h3 class="profile-name"><?php include "fetch_candidate_name.php"; ?></h3>
            <span class="badge bg-success">Job Seeker</span>
            <button class="btn btn-secondary mt-2" data-bs-toggle="modal"
                data-bs-target="#uploadProfilePictureModal">Edit Profile Picture</button>
        </div>
    </div>

    <!-- Modal for Uploading Profile Picture -->
    <div class="modal fade" id="uploadProfilePictureModal" tabindex="-1"
        aria-labelledby="uploadProfilePictureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadProfilePictureModalLabel">Upload Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="upload_profile_picture.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Choose Image</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3 border border-info">
        <div class="accordion" id="dashboardAccordion">
            <!-- Personal Information Section -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUserInfo">
                    <button class="accordion-button" style="background-color: #0056b3; color:white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseUserInfo" aria-expanded="false"
                        aria-controls="collapseUserInfo">
                        Personal Information
                    </button>
                </h2>
                <div id="collapseUserInfo" class="accordion-collapse collapse" aria-labelledby="headingUserInfo"
                    data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <?php include "candidate_info_update.php"; ?>
                    </div>
                </div>
            </div>

            <!-- Job Wish List Section -->
            <div class="accordion-item border border-warning">
                <h2 class="accordion-header" id="headingJobWishlist">
                    <button class="accordion-button" style="background-color: #0056b3; color:white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseJobWishlist" aria-expanded="true"
                        aria-controls="collapseJobWishlist">
                        Job Wish List
                    </button>
                </h2>
                <div id="collapseJobWishlist" class="accordion-collapse collapse show"
                    aria-labelledby="headingJobWishlist" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <?php include "job_wishlist.php"; ?>
                    </div>
                </div>
            </div>

            <!-- My Applications Section -->
            <div class="accordion-item border border-warning">
                <h2 class="accordion-header" id="headingMyApplications">
                    <button class="accordion-button" style="background-color: #0056b3; color:white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseMyApplications" aria-expanded="false"
                        aria-controls="collapseMyApplications">
                        My Applications
                    </button>
                </h2>
                <div id="collapseMyApplications" class="accordion-collapse collapse"
                    aria-labelledby="headingMyApplications" data-bs-parent="#dashboardAccordion">
                    <div class="accordion-body">
                        <?php include "my_applications.php"; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Share Your Experience (Testimonial) Form -->
        <div class="card mt-4 border border-warning">
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php include "footer.php"; ?>
</body>

</html>