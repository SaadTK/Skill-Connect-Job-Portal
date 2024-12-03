<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the base URL
$baseUrl = ($_SERVER['HTTP_HOST'] === 'localhost')
    ? "http://localhost/Skill_Connect_Project"
    : "https://skillconnect.webhop.me";

// Suppress error reporting in production
if ($_SERVER['HTTP_HOST'] !== 'localhost') {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Redirect employer to dashboard if on index.php
if (isset($_SESSION['role']) && $_SESSION['role'] == 1 && strpos($_SERVER['SCRIPT_NAME'], 'index.php') !== false) {
    header("Location: recruiter_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
            <div class="container d-flex justify-content-between align-items-center">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                    <img src="assets/img/icon/logo.png" alt="Skill Connect" height="40" class="me-2">
                    <span class="fw-bold text-primary">Skill Connect</span>
                </a>

                <!-- Weather Widget -->
                <div id="weather-widget" class="d-none d-lg-block ms-3">
                    <p id="weather" class="mb-0 text-secondary small">Loading...</p>
                </div>

                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <!-- Public Links -->
                            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="job_listing.php">Find Jobs</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                            <li class="nav-item"><a class="btn btn-primary btn-sm rounded-pill ms-2"
                                    href="register.php">Register</a></li>


                            <li class="nav-item"><a class="btn btn-primary btn-sm rounded-pill ms-2"
                                    href="login.php">Login</a></li>
                        <?php elseif ($_SESSION['role'] == 1): ?>
                            <!-- Employer Links -->
                            <li class="nav-item"><a class="nav-link" href="seeker_listings.php">Find Employee</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="recruiter_dashboard.php"><b>Dashboard</b></a>
                            </li>
                            <li class="nav-item"><a class="btn btn-danger btn-sm rounded-pill ms-2"
                                    href="logout.php">Logout</a></li>
                        <?php elseif ($_SESSION['role'] == 0): ?>
                            <!-- Candidate Links -->
                            <li class="nav-item"><a class="nav-link" href="job_listing.php">Find Jobs</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="dashboard.php"><b>Dashboard</b></a></li>
                            <li class="nav-item"><a class="btn btn-danger btn-sm rounded-pill ms-2"
                                    href="logout.php">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- jQuery (for fetching weather data) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script to Fetch and Display Weather Data -->
    <script>
        $(document).ready(function () {
            $.ajax({
                url: 'fetch_weather.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (!data.error) {
                        $('#weather').html(`Dhaka: ${data.temperature}°C, ${data.description}`);
                    } else {
                        $('#weather').text(data.error);
                    }
                },
                error: function () {
                    $('#weather').text("Error fetching weather data.");
                }
            });
        });
    </script>

    <style>
        /* Styling for the weather widget */
        #weather-widget {
            padding: 5px 15px;
            background-color: #f8f9fa;
            border-radius: 20px;
            font-size: 0.9em;
            color: #6c757d;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>