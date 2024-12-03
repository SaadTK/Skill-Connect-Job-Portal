<?php
session_start();
include 'db_connect.php';

// Check if user_id is set in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id']; // Retrieve user_id from the URL
} else {
    header("Location: recruiter_dashboard.php"); // Redirect if user_id is not set
    exit;
}

// Check if the recruiter is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the existing company information and user profile details
$stmt_company = $conn->prepare("SELECT company_name, company_information FROM job WHERE user_id = :user_id LIMIT 1");
$stmt_company->execute(['user_id' => $user_id]);
$company = $stmt_company->fetch(PDO::FETCH_ASSOC);

$stmt_user = $conn->prepare("SELECT profile_picture, website_url FROM users WHERE user_id = :user_id LIMIT 1");
$stmt_user->execute(['user_id' => $user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle company information update
    if (isset($_POST['company_name']) && isset($_POST['company_information'])) {
        $company_name = $_POST['company_name'];
        $company_information = $_POST['company_information'];

        // Update the company information in the database
        $stmt_update = $conn->prepare("UPDATE job SET company_name = :company_name, company_information = :company_information WHERE user_id = :user_id");
        $stmt_update->execute([
            'company_name' => $company_name,
            'company_information' => $company_information,
            'user_id' => $user_id
        ]);
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $file = $_FILES['profile_picture'];
        $fileContent = file_get_contents($file['tmp_name']);

        // Update profile picture in the database
        $stmt_picture_update = $conn->prepare("UPDATE users SET profile_picture = :profile_picture WHERE user_id = :user_id");
        $stmt_picture_update->execute([
            'profile_picture' => $fileContent,
            'user_id' => $user_id
        ]);
    }

    // Handle website URL update
    if (isset($_POST['website_url'])) {
        $website_url = $_POST['website_url'];

        // Update website URL in the database
        $stmt_url_update = $conn->prepare("UPDATE users SET website_url = :website_url WHERE user_id = :user_id");
        $stmt_url_update->execute([
            'website_url' => $website_url,
            'user_id' => $user_id
        ]);
    }

    // Redirect back to the dashboard with a success message
    $_SESSION['message'] = "Information updated successfully.";
    header("Location: recruiter_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Company Information - Skill Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Company Information</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form action="edit_company.php?user_id=<?php echo $user_id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name"
                    value="<?php echo htmlspecialchars($company['company_name'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="company_information" class="form-label">Company Information</label>
                <textarea class="form-control" id="company_information" name="company_information" rows="4"
                    required><?php echo htmlspecialchars($company['company_information'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="website_url" class="form-label">Company Website URL</label>
                <input type="url" class="form-control" id="website_url" name="website_url"
                    value="<?php echo htmlspecialchars($user['website_url'] ?? ''); ?>"
                    placeholder="https://www.example.com">
            </div>

            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="recruiter_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>