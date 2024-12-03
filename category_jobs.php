<?php
session_start();
include 'db_connect.php';

// Get the category ID from the query string
$cat_id = isset($_GET['cat_id']) ? (int) $_GET['cat_id'] : 0;

// Fetch category name from the database
$sql_category = "SELECT cat_name FROM categories WHERE cat_id = :cat_id";
$stmt_category = $conn->prepare($sql_category);
$stmt_category->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
$stmt_category->execute();
$category = $stmt_category->fetch(PDO::FETCH_ASSOC);
$cat_name = $category ? $category['cat_name'] : null;

// Fetch total job count in the selected category
$sql_job_count = "SELECT COUNT(*) AS job_count FROM job WHERE cat_id = :cat_id";
$stmt_job_count = $conn->prepare($sql_job_count);
$stmt_job_count->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
$stmt_job_count->execute();
$job_count = $stmt_job_count->fetch(PDO::FETCH_ASSOC)['job_count'];

// Handle invalid category
if (!$category) {
    echo "<main class='container text-center mt-5'><h1>Category Not Found</h1><p>Sorry, the category you are looking for does not exist.</p></main>";
    include 'footer.php';
    exit();
}

// Include header file for common page elements
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- OG Meta Tags -->
    <meta property="og:title" content="Category Jobs - Skill Connect - Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description"
        content="Explore the latest job opportunities in various categories. Find your dream job in this category on Skill Connect, your trusted job portal." />
    <meta property="og:image" content="/assets/img/seo/category_jobs.php"" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/category_jobs.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />





    <title>Category Jobs - Skill Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
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

    <main class="container">


        <!-- Category Title with Job Count -->
        <h1 class="text-center mb-4"><?php echo htmlspecialchars($cat_name); ?> - <?php echo $job_count; ?> Jobs</h1>

        <!-- Search Form with Filters -->
        <form class="mb-4" onsubmit="event.preventDefault(); filterJobs();">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" id="keyword" class="form-control" placeholder="Job Title or Keyword"
                        onkeyup="filterJobs()">
                </div>
                <div class="col-md-4">
                    <select id="location" class="form-select" onchange="filterJobs()">
                        <option value="" selected>Location</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chittagong">Chittagong</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Sylhet">Sylhet</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="job_type" class="form-select" onchange="filterJobs()">
                        <option value="" selected>Job Type</option>
                        <option value="full_time">Full-time</option>
                        <option value="part_time">Part-time</option>
                        <option value="freelance">Freelance</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Job Listings Section -->
        <div id="job-results" class="row">
            <!-- Jobs will be loaded here via AJAX -->
        </div>

        <!-- Load More Button -->
        <div class="d-flex justify-content-center align-items-center vh-10">
            <button id="load-more" class="btn btn-secondary" onclick="loadMoreJobs()">Load More</button>
        </div>

        <br>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        let page = 1; // Current page
        const limit = 2; // Number of jobs per page
        const cat_id = <?php echo $cat_id; ?>; // Category ID

        // Function to load jobs dynamically
        function loadJobs(reset = false) {
            if (reset) {
                document.getElementById('job-results').innerHTML = ''; // Clear existing jobs
                page = 1; // Reset to the first page
            }

            // Get filter values from the form
            const keyword = document.getElementById('keyword').value;
            const location = document.getElementById('location').value;
            const jobType = document.getElementById('job_type').value;

            // AJAX request to fetch jobs
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `fetch_jobs.php?cat_id=${cat_id}&page=${page}&limit=${limit}&keyword=${keyword}&location=${location}&job_type=${jobType}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const jobs = JSON.parse(xhr.responseText);
                    const jobResults = document.getElementById('job-results');

                    // Append new jobs to the job results section
                    jobs.forEach(job => {
                        jobResults.innerHTML += ` 
                            <div class="col-md-6 mb-4 job-card">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">${job.job_title}</h5>
                                        <p class="card-text text-muted">${job.description.substring(0, 150)}...</p>
                                        <ul class="list-unstyled mb-3">
                                            <li><strong>Location:</strong> ${job.location}</li>
                                            <li><strong>Salary:</strong> ${job.salary}</li>
                                            <li><strong>Timing:</strong> ${job.timing}</li>
                                            <li><strong>Deadline:</strong> ${job.deadline}</li>
                                        </ul>
                                    <a href="job_details.php?job_id=${job.job_id}" class="btn btn-outline-primary">Apply Now</a>
    
                                        </div>
                                </div>
                            </div>`;
                    });

                    page++; // Increment page for the next load

                    // Hide the "Load More" button if no more jobs are returned
                    if (jobs.length < limit) {
                        document.getElementById('load-more').style.display = 'none';
                    } else {
                        document.getElementById('load-more').style.display = 'block';
                    }
                }
            };
            xhr.send();
        }

        // Trigger load more jobs when the button is clicked
        function loadMoreJobs() {
            loadJobs(); // Load the next page of jobs
        }

        // Trigger filter jobs when filters are changed
        function filterJobs() {
            loadJobs(true); // Reset jobs and load with new filters
        }

        // Initial load of jobs when the page is loaded
        window.onload = function () {
            loadJobs();
        };
    </script>
</body>

</html>