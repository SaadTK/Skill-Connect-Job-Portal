<?php


include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch company details
$stmt_company = $conn->prepare("SELECT company_name, company_information FROM job WHERE user_id = :user_id LIMIT 1");
$stmt_company->execute(['user_id' => $user_id]);
$company = $stmt_company->fetch(PDO::FETCH_ASSOC);

// Fetch user profile picture
$stmt_user = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = :user_id LIMIT 1");
$stmt_user->execute(['user_id' => $user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <?php if ($company): ?>
        <div class="card shadow-sm mt-4">
            <div class="card-body text-center">
                <?php if ($user && !empty($user['profile_picture'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['profile_picture']); ?>"
                        alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px;">
                <?php else: ?>
                    <img src="assets/img/factory.jpg" alt="Default Profile Picture" class="rounded-circle"
                        style="width: 100px; height: 100px;">
                <?php endif; ?>

                <h5 class="card-title mt-3">Company Information</h5>
                <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company['company_name']); ?></p>
                <p><strong>Company Information:</strong> <?php echo htmlspecialchars($company['company_information']); ?>
                </p>

                <!-- Add user_id as a query parameter -->
                <a href="edit_company.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary btn-sm">Edit Company
                    Information</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-4" role="alert">
            No company information found. You have to post a job first.
        </div>

        <!-- Add user_id as a query parameter -->
        <a href="edit_company.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary btn-sm mt-2">Add Company
            Information</a>
    <?php endif; ?>
</div>