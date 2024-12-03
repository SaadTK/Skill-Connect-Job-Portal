<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- OG Meta Tags -->
    <meta property="og:title" content="Privacy Policy - Skill Connect | Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description"
        content="Policies for users privacy of data. Start finding your next career opportunity today in Bangladesh. Discover how we bridge the gap between job seekers and employers by providing seamless hiring solutions and career opportunities." />
    <meta property="og:image" content="/assets/img/seo/privacy policy.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property="og:url" content="<?= htmlspecialchars($baseUrl); ?>/privacy-policy.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />




    <title>Privacy Policy - Skill Connect</title>
    <link rel="stylesheet" href="assets/css/both.css">
</head>

<body>
    <main class="container">
        <h1>Privacy Policy</h1>
        <p>Last updated: 12th November 2024</p>

        <h2>1. Introduction</h2>
        <p>Welcome to Skill Connect. We are committed to protecting your personal data and ensuring your
            privacy when you use our website.</p>

        <h2>2. Information We Collect</h2>
        <p>We collect the following types of information:</p>
        <ul>
            <li><strong>Personal Information:</strong> Name, email address, phone number, and job-related data when you
                register or apply for jobs.</li>
            <li><strong>Usage Data:</strong> Information on how you interact with our website, including your IP
                address, browser type, and pages visited.</li>
        </ul>

        <h2>3. How We Use Your Information</h2>
        <p>We use your information to:</p>
        <ul>
            <li>Process job applications and facilitate communication between job seekers and employers.</li>
            <li>Improve our website functionality and user experience.</li>
            <li>Send notifications about new job listings, updates, and other relevant information.</li>
        </ul>

        <h2>4. Data Sharing and Disclosure</h2>
        <p>We do not share your personal information with third parties except when:</p>
        <ul>
            <li>Required by law or to respond to legal requests.</li>
            <li>Necessary to complete job applications and connect candidates with employers.</li>
            <li>We have your explicit consent to share your information.</li>
        </ul>

        <h2>5. Data Security</h2>
        <p>We employ reasonable security measures to protect your data. However, no internet transmission is 100%
            secure, and we cannot guarantee absolute security.</p>

        <h2>6. Your Rights</h2>
        <p>You have the right to access, update, or delete your personal information. Contact us at [Your Contact Email]
            to make requests regarding your data.</p>

        <h2>7. Changes to This Privacy Policy</h2>
        <p>We may update our Privacy Policy from time to time. Changes will be posted on this page, so please review it
            periodically.</p>

        <p>If you have questions about this policy, contact us at <a href="mailto:skilluconnectus@gmail.com"
                class="text-light footer-link" style="text-decoration: none;">skilluconnectus@gmail.com</a>.</p>
    </main>
</body>


</html>