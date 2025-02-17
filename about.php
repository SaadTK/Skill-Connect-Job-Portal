<?php
include 'header.php';
// Sample data for entrepreneurs
$entrepreneurs = [
    [
        "name" => "Masum Hasan",
        "role" => "CEO & Co-founder",
        "description" => "Handles database and backend operations.",
        "image" => "assets/img/photos/masum.jpeg"
    ],
    [
        "name" => "Tahmid Saad",
        "role" => "CTO and Co-founder",
        "description" => "Handles frontend, backend and database operations.",
        "image" => "assets/img/photos/tahmid.jpg"
    ],
    [
        "name" => "Others",
        "role" => "Cowrad and Rat",
        "description" => "They Left.",
        "image" => "assets/img/photos/coward.png"
    ],

];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <!-- OG Meta Tags -->
    <meta property="og:title" content="About Skill Connect - Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description"
        content="Learn more about Skill Connect's developers, the leading job portal in Bangladesh. Discover how we bridge the gap between job seekers and employers by providing seamless hiring solutions and career opportunities." />
    <meta property="og:image" content="/assets/img/seo/about_us.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property="og:url" content="<?= htmlspecialchars($baseUrl); ?>/about.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/about.css">
    <title>About Us - Job Portal</title>

</head>

<body style="padding-top: 70px;">
    <br>
    <br>
    <h1>About Us</h1>
    <div class="intro">
        <p>We are a team of passionate entrepreneurs and developers dedicated to connecting talented individuals
            with their dream jobs. Our online job portal is designed to make the job search process seamless and
            efficient for both job seekers and employers.</p>
    </div>
    <br>
    <div class="team-grid1">
        <?php foreach ($entrepreneurs as $member): ?>
            <div class="team-member">
                <img src="<?php echo htmlspecialchars($member['image']); ?>"
                    alt="<?php echo htmlspecialchars($member['name']); ?>">
                <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                <p><strong><?php echo htmlspecialchars($member['role']); ?></strong></p>
                <p><?php echo htmlspecialchars($member['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
<?php include "footer.php"; ?>

</html>