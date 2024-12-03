<?php
session_start(); // Started the session to get user_id after logging in

include "db_connect.php";

// Variable to store the application result
$applicationResult = '';

// Check if user is logged in or not
if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in to apply."); // kills the php page
}

$user_id = $_SESSION['user_id']; // Get the user_id from session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $job_id = isset($_POST['job_id']) ? intval($_POST['job_id']) : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $coverLetter = isset($_POST['coverLetter']) ? $_POST['coverLetter'] : '';
    $status = 'Pending'; // Default status for new applications

    // Check if a resume is uploaded
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $resumeData = file_get_contents($_FILES['resume']['tmp_name']);
        $resumeType = $_FILES['resume']['type'];
        $resumeName = $_FILES['resume']['name']; // Get original file name

        // Validate file types
        $allowedTypes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/msword',
        ];
        if (!in_array($resumeType, $allowedTypes)) {
            $applicationResult = 'Invalid file type for resume.';
        } else {
            // Check if signature data is submitted
            $signature = isset($_POST['signature']) ? $_POST['signature'] : '';

            // Validate the signature (make sure it's not empty)
            if (empty($signature)) {
                $applicationResult = 'Signature is required.';
            } else {
                // Update the SQL to store resume and signature data
                $sql = "INSERT INTO application (job_id, user_id, app_date, resume, resume_type, resume_name, cover_letter, status, signature) 
                    VALUES (:job_id, :user_id, NOW(), :resume, :resume_type, :resume_name, :cover_letter, :status, :signature)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':job_id', $job_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':resume', $resumeData, PDO::PARAM_LOB);
                $stmt->bindParam(':resume_type', $resumeType);
                $stmt->bindParam(':resume_name', $resumeName);
                $stmt->bindParam(':cover_letter', $coverLetter);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':signature', $signature);

                try {
                    $stmt->execute();
                    $applicationResult = 'Your application has been submitted successfully!';
                    $_SESSION['message'] = $applicationResult; // Set session message
                    header("Location: job_details.php?job_id=$job_id"); // Redirect after successful submission
                    exit;
                } catch (PDOException $e) {
                    $applicationResult = 'Error: ' . $e->getMessage();
                }
            }
        }
    } else {
        $applicationResult = 'Please upload a valid resume.';
    }
}

// Close the database connection
$conn = null;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Application Submission</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


</head>

<body>
    <script>
        $(document).ready(function () {
            let result = "<?php echo $applicationResult; ?>";

            if (result === 'success') {
                alert("Application submitted successfully.");
                window.location.href = 'job_listing.php'; // Redirect to job_listing.php on success
            } else if (result !== '') {
                alert("Failed to submit application: " + result);
                window.location.href = 'job_listing.php'; // Redirect to job_listing.php on failure as well
            }
        });
    </script>
</body>

</html>