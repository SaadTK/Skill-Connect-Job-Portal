<?php
include "db_connect.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get user info from the database
$user_id = intval($_SESSION['user_id']);
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $about = trim($_POST['about']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $gender = trim($_POST['gender']);
    $website_url = trim($_POST['website_url']);

    // The new ones
    $work_experience = trim($_POST['work_experience']);
    $education = trim($_POST['education']);
    $skills = trim($_POST['skills']);
    $certifications = trim($_POST['certifications']);
    $salary_expectations = trim($_POST['salary_expectations']);
    $references = trim($_POST['references']);


    // Prepare the SQL update statement
    $sql = "UPDATE users SET 
first_name = :first_name, 
last_name = :last_name, 
about = :about, 
email = :email, 
phone_number = :phone_number, 
address = :address, 
gender = :gender,
website_url = :website_url,
work_experience = :work_experience,
education = :education,
skills = :skills,
certifications = :certifications,
salary_expectations = :salary_expectations,
`references` = :references
WHERE user_id = :user_id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'about' => $about,
            'email' => $email,
            'phone_number' => $phone_number,
            'address' => $address,
            'gender' => $gender,
            'website_url' => $website_url,
            'work_experience' => $work_experience,
            'education' => $education,
            'skills' => $skills,
            'certifications' => $certifications,
            'salary_expectations' => $salary_expectations,
            'references' => $references,
            'user_id' => $user_id
        ]);

        // Fetch updated user info after the update
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<script>alert('Profile updated successfully!');</script>";
    } catch (PDOException $e) {
        echo "<pre>Error: ";
        print_r($e->getMessage());
        echo "</pre>";
    }

}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Personal Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Personal Information</h2>
        <form method="POST" id="userInfoForm" onsubmit="return validateForm()">

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="<?php echo htmlspecialchars($userInfo['first_name'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="<?php echo htmlspecialchars($userInfo['last_name'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About Yourself</label>
                <textarea class="form-control" id="about" name="about"
                    rows="3"><?php echo htmlspecialchars($userInfo['about'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($userInfo['email'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number"
                    value="<?php echo htmlspecialchars($userInfo['phone_number'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?php echo htmlspecialchars($userInfo['address'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="website_url" class="form-label">Enter Your Portfolio Link</label>
                <input type="url" class="form-control" id="website_url" name="website_url"
                    value="<?php echo htmlspecialchars($userInfo['website_url'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="">Select...</option>
                    <option value="male" <?php echo (isset($userInfo['gender']) && $userInfo['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo (isset($userInfo['gender']) && $userInfo['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>

                </select>
            </div>

            <!-- The new ones -->
            <div class="mb-3">
                <label for="work_experience" class="form-label">Work Experience</label>
                <textarea class="form-control" id="work_experience" name="work_experience"
                    rows="3"><?php echo htmlspecialchars($userInfo['work_experience'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="education" class="form-label">Education</label>
                <textarea class="form-control" id="education" name="education"
                    rows="3"><?php echo htmlspecialchars($userInfo['education'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="skills" class="form-label">Skills</label>
                <input type="text" class="form-control" id="skills" name="skills"
                    value="<?php echo htmlspecialchars($userInfo['skills'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="certifications" class="form-label">Certifications</label>
                <textarea class="form-control" id="certifications" name="certifications"
                    rows="3"><?php echo htmlspecialchars($userInfo['certifications'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="salary_expectations" class="form-label">Salary Expectations</label>
                <input type="text" class="form-control" id="salary_expectations" name="salary_expectations"
                    value="<?php echo htmlspecialchars($userInfo['salary_expectations'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="references" class="form-label">References</label>
                <textarea class="form-control" id="references" name="references"
                    rows="3"><?php echo htmlspecialchars($userInfo['references'] ?? ''); ?></textarea>
            </div>



            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>

</html>