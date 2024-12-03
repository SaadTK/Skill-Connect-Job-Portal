<?php
include 'db_connect.php'; // Database connection
include 'header.php'; // Include the header


// Check if job_id is set in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch job details from the database
    $stmt = $conn->prepare("SELECT * FROM job WHERE job_id = :job_id");
    $stmt->execute(['job_id' => $job_id]);
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$job) {
        echo "Job not found!";
        exit;
    }
}

// Fetch categories from the database
$cat_stmt = $conn->prepare("SELECT * FROM categories");
$cat_stmt->execute();
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// Update job details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated values from the form
    $job_title = $_POST['job_title'];
    $company_name = $_POST['company_name'];
    $company_information = $_POST['company_information'];
    $description = $_POST['description'];
    $responsibilities = $_POST['responsibilities'];

    $skill = $_POST['skill'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $cat_id = $_POST['cat_id'];
    $timing = $_POST['timing'];
    $deadline = $_POST['deadline'];

    // Update the job in the database
    $stmt = $conn->prepare("UPDATE job SET 
        job_title = :job_title,
        company_name = :company_name,
        company_information = :company_information,
        description = :description,
        responsibilities = :responsibilities,
        skill = :skill,
        salary = :salary,
        location = :location,
        cat_id = :cat_id,
        timing = :timing,
        deadline = :deadline
        WHERE job_id = :job_id");

    $stmt->execute([
        'job_title' => $job_title,
        'company_name' => $company_name,
        'company_information' => $company_information,
        'description' => $description,
        'responsibilities' => $responsibilities,
        'skill' => $skill,
        'salary' => $salary,
        'location' => $location,
        'cat_id' => $cat_id,
        'timing' => $timing,
        'deadline' => $deadline,
        'job_id' => $job_id
    ]);

    // Redirect back to dashboard or confirmation page
    header("Location: recruiter_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job - Skill Connect</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <br>
    <br>

    <main class="container mt-5">
        <h1 class="mb-4 text-center">Edit Job Posting</h1>

        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="job_title" class="form-label">Job Title</label>
                    <input type="text" class="form-control" id="job_title" name="job_title"
                        value="<?php echo $job['job_title']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name"
                        value="<?php echo $job['company_name']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="company_information" class="form-label">Company Information</label>
                <textarea class="form-control" id="company_information" name="company_information" rows="3"
                    required><?php echo $job['company_information']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    required><?php echo $job['description']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="responsibilities" class="form-label">Responsibilities</label>
                <textarea class="form-control" id="responsibilities" name="responsibilities" rows="3"
                    required><?php echo $job['responsibilities']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="skill" class="form-label">Skills Required</label>
                <textarea class="form-control" id="skill" name="skill" rows="3"
                    required><?php echo $job['skill']; ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cat_id" class="form-label">Category</label>
                    <select class="form-control" id="cat_id" name="cat_id" required>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['cat_id']; ?>" 
                                <?php if ($job['cat_id'] == $category['cat_id']) echo 'selected'; ?>>
                                <?php echo $category['cat_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="salary" class="form-label">Salary</label>
                <input type="text" class="form-control" id="salary" name="salary" value="<?php echo $job['salary']; ?>"
                    required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location"
                        value="<?php echo $job['location']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="timing" class="form-label">Timing</label>
                    <input type="text" class="form-control" id="timing" name="timing"
                        value="<?php echo $job['timing']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="deadline" class="form-label">Application Deadline</label>
                    <input type="date" class="form-control" id="deadline" name="deadline"
                        value="<?php echo $job['deadline']; ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-30">Update Job</button>
        </form>
        <br>
    </main>

    <?php include "footer.php"; ?>

</body>

</html>
