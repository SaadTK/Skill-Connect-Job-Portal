<?php
include 'header.php';
include 'db_connect.php';

// Get keyword and location from URL parameters
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Pagination variables (for lazy loading)
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 4; // Initially load 4 seekers per batch
$offset = ($page - 1) * $limit;

// Query to get seekers based on filter
$query = "SELECT * FROM users 
          WHERE role = 0 
          AND (first_name LIKE :keyword OR last_name LIKE :keyword OR skills LIKE :keyword) 
          AND address LIKE :location 
          LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($query);
$stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
$stmt->bindValue(':location', "%$location%", PDO::PARAM_STR);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$seekers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the request is made via AJAX (this is needed to return only seeker data)
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    // Display seekers from the database
    foreach ($seekers as $seeker) {
        echo "
            <div class='col-md-6 mb-4 seeker-card'>
                <div class='card shadow-sm'>
                    <div class='card-body'>
                        <h5 class='card-title seeker-name'>{$seeker['first_name']} {$seeker['last_name']}</h5>
                        <p class='card-text'>{$seeker['skills']}</p>
                        <p class='text-muted seeker-location'>{$seeker['address']}</p>
                        <a href='seeker_details.php?seeker_id={$seeker['user_id']}' class='btn btn-primary'>View Details</a>
                    </div>
                </div>
            </div>";
    }
    exit; // End execution for AJAX requests
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Seekers - Skill Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

</head>

<body style="padding-top: 70px;">
    <main class="container" style="padding-top: 70px;">


        <h1 class="text-center mb-4">All Job Seekers</h1>

        <!-- Search Form -->
        <form class="mb-4" onsubmit="event.preventDefault(); filterSeekers();">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" id="keyword" class="form-control" placeholder="Seeker Name or Skill"
                        onkeyup="filterSeekers()">
                </div>
                <div class="col-md-4">
                    <select id="location" class="form-select" onchange="filterSeekers()">
                        <option value="" selected>Location</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Chittagong">Chittagong</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Sylhet">Sylhet</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Search Seekers</button>
                </div>
            </div>
        </form>

        <!-- Seekers Section -->
        <div id="seeker-results" class="row">
            <!-- Initial seekers will be loaded here by AJAX -->
        </div>
    </main>


    <script>
        let currentPage = 1; // Start with the first batch of seekers
        let isLoading = false; // Flag to prevent multiple AJAX calls at the same time

        // Function to load seekers via AJAX
        function loadSeekers() {
            if (isLoading) return; // Prevent multiple calls
            isLoading = true; // Set loading to true

            const keyword = document.getElementById('keyword').value;
            const location = document.getElementById('location').value;
            const url = `seeker_listings.php?keyword=${encodeURIComponent(keyword)}&location=${encodeURIComponent(location)}&page=${currentPage}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(data => {
                    // Append the new seekers to the current list
                    document.getElementById('seeker-results').insertAdjacentHTML('beforeend', data);
                    isLoading = false; // Allow further AJAX calls once the current load is done
                    currentPage++; // Increment the page number for the next batch
                })
                .catch(err => {
                    console.error("Error loading seekers:", err);
                    isLoading = false;
                });
        }

        // Listen for scroll event to trigger loading more seekers
        window.addEventListener('scroll', function () {
            // Check if user has scrolled near the bottom of the page
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
                loadSeekers();
            }
        });

        // Function to filter seekers live as you type
        function filterSeekers() {
            currentPage = 1; // Reset page to 1 when the search is changed
            document.getElementById('seeker-results').innerHTML = ''; // Clear the previous results
            loadSeekers(); // Load the filtered results
        }

        // Initial load of seekers when the page is ready
        window.onload = loadSeekers;
    </script>


    <?php include 'footer.php'; ?>

</body>

</html>