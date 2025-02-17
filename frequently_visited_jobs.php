<?php
require 'vendor/autoload.php';

$redis = new Predis\Client();

try {
    $cacheKey = 'frequently_visited_jobs';
    $cacheData = $redis->get($cacheKey);

    if ($cacheData) {
        header('Content-Type: application/json');
        echo $cacheData; // Return cached JSON data directly
    } else {
        http_response_code(404); // Not Found
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No frequently visited jobs found']);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Redis connection failed: ' . $e->getMessage()]);
}

?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        const jobsApiUrl = 'cache.php';

        // Fetch frequently visited jobs
        $.ajax({
            url: jobsApiUrl,
            method: 'GET',
            dataType: 'json', // Expect JSON from the server
            success: function (data) {
                if (Array.isArray(data)) {
                    displayJobs(data); // Pass array to display function
                } else if (data.error) {
                    $('#job-container').html(`<p class="text-center">${data.error}</p>`);
                } else {
                    $('#job-container').html("<p class='text-center'>No frequently visited jobs found.</p>");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
                $('#job-container').html("<p class='text-danger text-center'>Error fetching jobs from the server.</p>");
            }
        });

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