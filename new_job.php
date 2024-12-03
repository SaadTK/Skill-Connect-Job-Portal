<?php
session_start();

include 'db_connect.php'; // Database connection

// Check if user is logged in and if the form is submitted
if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the logged-in user's user_id from the session
    $user_id = $_SESSION['user_id'];

    // Fetch all job details from the form
    $company_name = $_POST['company_name'];
    $job_title = $_POST['job_title'];
    $description = $_POST['description'];
    $skill = $_POST['skill'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $cat_id = $_POST['cat_name']; // Use cat_id instead of cat_name
    $timing = $_POST['timing'];
    $deadline = $_POST['deadline'];
    $date = date('Y-m-d'); // Automatically capture the current date

    // Insert job details into the jobs table, including the user_id as a foreign key
    $stmt_job = $conn->prepare("INSERT INTO job (company_name, job_title, description, skill, salary, location, cat_id, timing, deadline, date, user_id) 
                                VALUES (:company_name, :job_title, :description, :skill, :salary, :location, :cat_id, :timing, :deadline, :date, :user_id)");
    $result = $stmt_job->execute([
        'company_name' => $company_name,
        'job_title' => $job_title,
        'description' => $description,
        'skill' => $skill,
        'salary' => $salary,
        'location' => $location,
        'cat_id' => $cat_id, // Use the category ID from the dropdown
        'timing' => $timing,
        'deadline' => $deadline,
        'date' => $date,
        'user_id' => $user_id // Insert the user_id from the session
    ]);

    // If job posting was successful, redirect to payment.php
    if ($result) {
        $_SESSION['job_id'] = $conn->lastInsertId(); // Store the last inserted job_id in the session
        header("Location: payment.php?job_id=" . $_SESSION['job_id']); // Pass job_id to payment page
        exit();
    }

} else {
    echo " ";
}

// Fetch categories from the database
$stmt_cat = $conn->prepare("SELECT cat_id, cat_name FROM categories");
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post New Job</title>
    <link rel="stylesheet" href="assets/css/new_job.css">
</head>

<body>
    <div class="container">
        <h2>Post a New Job</h2>
        <form action="new_job.php" method="POST">
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" required>

            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" required>

            <label for="description">Job Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="responsibilities">Responsibilities:</label>
            <textarea id="responsibilities" name="responsibilities" required></textarea>

            <label for="skill">Skills Required:</label>
            <input type="text" id="skill" name="skill" required>

            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="cat_name">Job Category:</label>
            <select id="cat_name" name="cat_name" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['cat_id'] ?>"><?= htmlspecialchars($category['cat_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="timing">Job Timing:</label>
            <input type="text" id="timing" name="timing" required>

            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" required>

            <button type="submit">Proceed to Payment</button>
        </form>
    </div>
</body>

</html>