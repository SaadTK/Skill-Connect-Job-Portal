<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- OG Meta Tags -->
    <meta property="og:title" content="Terms of Services - Skill Connect | Your Trusted Job Portal in Bangladesh." />
    <meta property="og:description"
        content="Our terms that you have to follow to get services. Please don't break any rules. Start finding your next career opportunity today in Bangladesh." />
    <meta property="og:image" content="/assets/img/hero/terms_of_service.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property=" og:url" content="<?= htmlspecialchars($baseUrl); ?>/terms-of-service.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />







    <title>Terms of Service - Skill Connect</title>
    <link rel="stylesheet" href="assets/css/both.css">
</head>

<body style="padding-top: 70px;">
    <main class="container">
        <h1>Terms of Service</h1>
        <p>Last updated: 13th November 2024</p>

        <h2>1. Acceptance of Terms</h2>
        <p>By using our Skill Connect, you agree to these Terms of Service. If you do not
            agree, please do not use our services.</p>

        <h2>2. User Accounts</h2>
        <p>To access certain features, you may need to create an account. You are responsible for maintaining the
            confidentiality of your account and for all activities that occur under it.</p>

        <h2>3. Job Postings and Applications</h2>
        <p>We provide a platform for job seekers to apply for job listings and for employers to post job openings. We
            are not responsible for the content of job postings, and we do not guarantee employment or the quality of
            applicants.</p>

        <h2>4. Prohibited Conduct</h2>
        <p>Users agree not to:</p>
        <ul>
            <li>Use the site to post false, misleading, or inappropriate job listings.</li>
            <li>Distribute harmful software or attempt to gain unauthorized access to the site.</li>
            <li>Engage in activities that violate local, state, or national laws.</li>
        </ul>

        <h2>5. Content Ownership</h2>
        <p>All content on this site, including text, graphics, and logos, is the property of [Your Job Portal Name] or
            its licensors and is protected by copyright laws.</p>

        <h2>6. Limitation of Liability</h2>
        <p>[Your Job Portal Name] is not liable for any damages or losses resulting from your use of the site or your
            inability to use the site, including but not limited to loss of data or employment opportunities.</p>

        <h2>7. Modifications to Terms</h2>
        <p>We may revise these Terms of Service at any time. Any changes will be posted on this page, and continued use
            of the site constitutes acceptance of the revised terms.</p>

        <h2>8. Contact Us</h2>
        <p>If you have questions about these Terms of Service, please contact us at
            <a href="mailto:skilluconnectus@gmail.com" class="text-light footer-link"
                style="text-decoration: none;">skilluconnectus@gmail.com</a>.
        </p>
    </main>
</body>

</html>