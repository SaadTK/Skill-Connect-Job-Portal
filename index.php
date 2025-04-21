<?php
session_start();

// Check if user is logged in and if a role is set
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role']; // 0 for candidate, 1 for employer
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#007bff" />

    <meta property="og:title" content="Skill Connect - Find Your Dream Job in Bangladesh." />
    <meta property="og:description"
        content="Discover top job opportunities in Bangladesh. Skill Connect helps you find roles across IT, Healthcare, Marketing, and more. Start your career journey today!" />
    <meta property="og:image" content="/assets/img/hero/carousol1.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "http://skillconnect.webhop.me";
    }
    ?>
    <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/index.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />

    <title>Skill Connect - Find Your Dream Job in Bangladesh</title>

    <!-- Bootstrap from google-->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" as="style"
        onload="this.rel='stylesheet'"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS  -->
    <link rel="preload" href="assets/css/index.css" as="style" onload="this.rel='stylesheet'">

    <!-- Preload Hero Carousel Images -->
    <link rel="preload" href="assets/img/hero/carousol1.jpg" as="image">
    <link rel="preload" href="assets/img/hero/carousol3.jpg" as="image">

    <!-- Bootstrap JS (preload) -->
    <link rel="preload" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"
        as="script">

    <!-- Google Fonts (Preload) -->
    <link rel="preload"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500&display=swap"
        as="style" onload="this.rel='stylesheet'">

    <!-- jQuery (preload) from google -->
    <link rel="prefetch" href="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" as="script">

    <style>
        /* Styles for the weather widget */
        .weather-widget {
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            text-align: center;
            max-width: 250px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .weather-widget h4 {
            font-size: 16px;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .weather-widget p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>

<body style="padding-top: 70px;">

    <!-- Include Header of backend code -->
    <?php include 'header.php'; ?>

    <main class="container mt-4">

        <!-- Hero Section with Carousel -->
        <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- First Carousel Item -->
                <div class="carousel-item active" style="height: 500px;">
                    <picture>
                        <!-- For small screen image -->
                        <source srcset="assets/img/hero/carousol1.webp" media="(max-width: 768px)" type="image/webp">
                        <source srcset="assets/img/hero/carousol1.jpg" media="(max-width: 768px)" type="image/jpeg">
                        <!-- For large screen image -->
                        <source srcset="assets/img/hero/carousol1.webp" type="image/webp">
                        <img rel="prefetch" src="assets/img/hero/carousol1.jpg" alt="Find Your Dream Job in Bangladesh"
                            class="d-block w-100" style="height: 500px; object-fit: cover;">
                    </picture>
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-3 text-white">Find Your Dream Job in Bangladesh</h1>
                        <p class="lead text-white">Explore top opportunities across the country.</p>
                        <a href="job_listing.php" class="btn btn-primary btn-lg rounded-pill mt-3">Explore Jobs</a>
                    </div>
                </div>

                <!-- Second Carousel Item -->
                <div class="carousel-item" style="height: 500px;">
                    <picture>
                        <!-- For small screen image -->
                        <source srcset="assets/img/hero/carousol2.webp" media="(max-width: 768px)" type="image/webp">
                        <source srcset="assets/img/hero/carousol2.jpg" media="(max-width: 768px)" type="image/jpeg">
                        <!-- For large screen image -->
                        <source srcset="assets/img/hero/carousol2.webp" type="image/webp">
                        <img rel="prefetch" src="assets/img/hero/carousol2.jpg" alt="Find Your Favorite Job"
                            class="d-block w-100" style="height: 500px; object-fit: cover;">
                    </picture>
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-3 text-white">Find Your Favorite Job</h1>
                        <p class="lead text-white">Find a job you like.</p>
                        <a href="job_listing.php" class="btn btn-primary btn-lg mt-3">Check Jobs</a>
                    </div>
                </div>

                <!-- Third Carousel Item -->
                <div class="carousel-item" style="height: 500px;">
                    <picture>
                        <!-- For small screen image -->
                        <source srcset="assets/img/hero/carousol3.webp" media="(max-width: 768px)" type="image/webp">
                        <source srcset="assets/img/hero/carousol3.jpg" media="(max-width: 768px)" type="image/jpeg">
                        <!-- For large screen image -->
                        <source srcset="assets/img/hero/carousol3.webp" type="image/webp">
                        <img rel="prefetch" src="assets/img/hero/carousol3.jpg" alt="Boost Your Career"
                            class="d-block w-100" style="height: 500px; object-fit: cover;">
                    </picture>
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="display-3 text-white">Boost Your Career</h1>
                        <p class="lead text-white">Find roles in the fastest-growing industries.</p>
                        <a href="job_listing.php" class="btn btn-primary btn-lg mt-3">Discover Jobs</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>

        <!-- Categories Section -->
        <section class="py-5">
            <h2 class="text-center mb-5">Explore Job Categories</h2>
            <div class="row">
                <?php
                $categories = [
                    ["IT", "Information Technology", "it", 1],
                    ["Marketing", "Sales and Marketing", "marketing", 2],
                    ["Education", "Education", "education", 3],
                    ["Creative", "Creative and Design", "creative-design", 4],
                    ["Engineering", "Engineering", "engineering", 5],
                    ["Construction", "Construction", "construction", 6],
                    ["Trades", "Skilled Trades", "skilled-trades", 7],
                    ["Healthcare", "Healthcare", "healthcare", 8],

                    ["Law and Order", "Law and Order", "law", 9],
                    ["Science and Research", "Science and Research", "science-research", 10],
                    ["Agriculture and Environment", "Agriculture and Environment", "agriculture-environment", 11],
                    ["Public Relations and Communications", "Public Relations and Communications", "public-realtions", 12]
                ];
                foreach ($categories as $category) {
                    echo "
    <div class='col-md-3 mb-4'>
        <a href='category_jobs.php?cat_id={$category[3]}' class='text-decoration-none'>
            <div class='card h-100 shadow-sm border-0 category-card'>
                <picture>
                    <!--When the Screen is Small-->
                    <source srcset='assets/img/category/{$category[2]}.webp' media='(max-width: 768px)' type='image/webp'>
                    <source srcset='assets/img/category/{$category[2]}.svg' media='(max-width: 768px)' type='image/svg+xml'>
                    <!--When the Screen is Large-->
                    <source srcset='assets/img/category/{$category[2]}.webp' type='image/webp'>
                    <img src='assets/img/category/{$category[2]}.svg' class='card-img-top' alt='{$category[1]}'>
                </picture>
                <div class='card-body text-center'>
                    <h5 class='card-title text-dark'>{$category[1]}</h5>
                </div>
            </div>
        </a>
    </div>
    ";
                }
                ?>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-5 bg-light text-center">
            <div class="container">
                <h2 class="mb-4">Our Achievements</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-icon"><i class="bi bi-person-fill"></i></div>
                        <h3 id="jobsPosted">0+</h3>
                        <p>Jobs Posted</p>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-icon"><i class="bi bi-person-check-fill"></i></div>
                        <h3 id="candidatesPlaced">0+</h3>
                        <p>Candidates Placed</p>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                        <h3 id="companiesRegistered">0+</h3>
                        <p>Companies Registered</p>
                    </div>
                </div>
            </div>
        </section>

        <br>

        <!-- frequented jobs are cached and displayed here -->
        <div class="frequently-visited-jobs bg-light">
            <h2 style="text-align: center;">Top 5 Jobs</h2>
            <br>
            <div id="job-container" class="row">
                <!-- Job container will be populated with AJAX -->
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                const jobsApiUrl = 'cache.php';

                // Check if the jobs data is available in the browser cache (localStorage or sessionStorage)
                if (localStorage.getItem('frequently_visited_jobs')) {
                    // Retrieve jobs from the browser cache (localStorage)
                    const cachedJobs = JSON.parse(localStorage.getItem('frequently_visited_jobs'));
                    displayJobs(cachedJobs);
                } else {
                    // Fetch frequently visited jobs from the server
                    $.ajax({
                        url: jobsApiUrl,
                        method: 'GET',
                        dataType: 'json', // Expect JSON from the server
                        success: function(data) {
                            if (Array.isArray(data.data)) {
                                // Cache the jobs in localStorage for future use
                                localStorage.setItem('frequently_visited_jobs', JSON.stringify(data.data));
                                displayJobs(data.data); // Pass array to display function
                            } else if (data.error) {
                                $('#job-container').html(`<p class="text-center">${data.error}</p>`);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error, xhr.responseText);
                            $('#job-container').html("<p class='text-danger text-center'>Error fetching jobs from the server.</p>");
                        }
                    });
                }

                // Function to display jobs
                function displayJobs(jobs) {
                    $('#job-container').empty(); // Clear previous jobs
                    if (jobs.length > 0) {
                        jobs.forEach(job => {
                            const jobCard = `
                    <div class="col-md-6 mb-4 job-card">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">${job.job_title || 'No title available'}</h5>
                                <p class="card-text">${job.description || 'No description available'}</p>
                                <p class="text-muted">Location: ${job.location || 'N/A'}</p>
                                <p class="text-muted">Salary: ${job.salary || 'N/A'} | Timing: ${job.timing || 'N/A'} | Deadline: ${job.deadline || 'N/A'}</p>
                                <a href="job_details.php?job_id=${job.job_id}" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>`;
                            $('#job-container').append(jobCard);
                        });
                    } else {
                        $('#job-container').html("<p class='text-center'>No frequently visited jobs found.</p>");
                    }
                }
            });
        </script>


        <!-- Testimonials Section -->
        <?php include 'display_testimonials.php'; ?>

    </main>

    <!-- Include Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // Fetch and Display Statistics Data
        $.ajax({
            url: 'fetch_stats.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (!data.error) {
                    $('#jobsPosted').text(data.jobsPosted + '+');
                    $('#candidatesPlaced').text(data.candidatesPlaced + '+');
                    $('#companiesRegistered').text(data.companiesRegistered + '+');
                } else {
                    console.error(data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
            }
        });
    </script>
</body>

</html>