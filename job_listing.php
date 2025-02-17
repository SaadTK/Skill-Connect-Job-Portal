<?php
include 'header.php';
include 'db_connect.php';



include('header.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings - Skill Connect</title>

    <!-- OG Meta Tags -->
    <meta property="og:title" content="Job Listing - Skill Connect | Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description" content="Lists of jobs. Not categorized or anything. One can see all the jobs in a list. Start
    finding your next career opportunity today in Bangladesh." />
    <meta property="og:image" content="/assets/img/hero/apply.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/job_listing.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />





    <!-- Prefetch Job Details Page -->
    <link rel="prefetch" href="job_details.php">

    <!-- Prefetch Bootstrap CSS -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" as="style"
        onload="this.rel='stylesheet'">

    <!-- Google Fonts Prefetch -->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500&display=swap"
        as="style" onload="this.rel='stylesheet'">

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

        <h1 class="text-center mb-4">All the Latest Jobs</h1>

        <!-- Search Form -->
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
                    <button type="submit" class="btn btn-primary w-100">Search Jobs</button>
                </div>
            </div>
        </form>

        <!-- Job Listings Section -->
        <div id="job-results" class="row">
            <!-- Jobs will be loaded here via AJAX -->
        </div>

        <!-- Job Details Section -->
        <div id="job-details" style="display: none;">
            <!-- Job details will be loaded here when a job is selected -->
        </div>
    </main>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // Pagination variables
        let page = 1; // Start with the first page
        const limit = 8; // Number of jobs to load per page
        let loading = false; // Flag to prevent multiple loads

        // Function to load jobs with lazy loading
        function loadJobs() {
            if (loading) return; // Prevent multiple requests at once
            loading = true; // Set loading flag

            // Get filter values
            let keyword = document.getElementById('keyword').value;
            let location = document.getElementById('location').value;

            // AJAX request to fetch jobs
            let xhr = new XMLHttpRequest();
            xhr.open("GET", `search_jobs.php?keyword=${encodeURIComponent(keyword)}&location=${encodeURIComponent(location)}&page=${page}&limit=${limit}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    let jobs = JSON.parse(xhr.responseText);
                    let jobResults = document.getElementById('job-results');

                    // Append jobs to the job-results container
                    jobs.forEach(job => {
                        jobResults.innerHTML += `
                            <div class="col-md-6 mb-4 job-card">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title job-title">${job.job_title}</h5>
                                        <p class="card-text">${job.company_name} | ${job.location}</p>
                                        <p class="text-muted job-location">${job.location}</p>
                                        <p class="text-muted">৳${job.salary} | ${job.timing}</p>
                                        <a href="job_details.php?job_id=${job.job_id}" class="btn btn-primary">View Details</a>
                                    </div>
                                    <div class="card-footer text-muted">Posted on ${new Date(job.date).toLocaleDateString()}</div>
                                </div>
                            </div>`;
                    });

                    // Increment the page number for the next load
                    if (jobs.length > 0) {
                        page++;
                        loading = false; // Reset loading flag
                    } else {
                        // No more jobs to load
                        window.removeEventListener('scroll', handleScroll); // Remove scroll event listener
                    }
                }
            };
            xhr.send();
        }

        // Function to handle search form filter reset and lazy load jobs from page 1
        function filterJobs() {
            page = 1; // Reset to the first page
            document.getElementById('job-results').innerHTML = ''; // Clear previous results
            loadJobs(); // Load the first page with new filters applied
        }

        // Scroll event handler to trigger loadJobs when scrolled near the bottom
        function handleScroll() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight * 0.8) {
                loadJobs();
            }
        }

        // Load initial jobs on page load
        window.onload = loadJobs;

        // Attach scroll event for lazy loading
        window.addEventListener('scroll', handleScroll);
    </script>
</body>

</html>