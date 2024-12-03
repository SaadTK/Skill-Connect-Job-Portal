<?php
include('header.php');
include 'db_connect.php';  // Database connection

// Initialize variables
$success_message = '';
$name = $email = $subject = $message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Insert into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);

        $success_message = "Thank you, $name! Your message has been sent successfully.";
        $name = $email = $subject = $message = ''; // Reset fields
    } catch (PDOException $e) {
        die("Error: Could not save the message. " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- OG Meta Tags -->
    <meta property="og:title" content="Contact Skill Connect - Reach Out to Us" />
    <meta property="og:description"
        content="Get in touch with the Skill Connect team. Share your queries, feedback, or suggestions. We're here to help and make your experience better!" />
    <meta property="og:image" content="/assets/img/seo/contact_us.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property="og:url" content="<?= htmlspecialchars($baseUrl); ?>/contact.php" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">


</head>

<body style="padding-top: 70px;">
    <div class="container1">
        <h1 class="text-center mb-4">Contact Us</h1>

        <!-- Success Message -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <p><?php echo $success_message; ?></p>
            </div>
        <?php endif; ?>

        <!-- Contact Form -->
        <form method="post" action="">
            <div class="form-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="Enter your name"
                    value="<?php echo $name; ?>" required pattern="[a-zA-Z\s]+"
                    title="Name should only contain letters and spaces.">
            </div>
            <div class="form-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>"
                    required>
            </div>
            <div class="form-group mb-3">
                <input type="text" name="subject" class="form-control" placeholder="Enter Subject"
                    value="<?php echo $subject; ?>" required minlength="3">
            </div>
            <div class="form-group mb-3">
                <textarea name="message" class="form-control" placeholder="Enter Message" rows="5" required
                    minlength="10"><?php echo $message; ?></textarea>
            </div>
            <button type="submit" class="send-button btn w-100">SEND</button>
        </form>

        <!-- Contact Information -->
        <div class="contact-info mt-4">
            <label><b>Contact Information:</b></label>
            <p><i class="fas fa-map-marker-alt"></i> Address: Dhaka, Bangladesh</p>
            <p><i class="fas fa-phone"></i> Call Us: +880123456789</p>
            <p><i class="fas fa-clock"></i> Hours: Sunday to Thursday, 9 AM - 6 PM</p>
            <p><i class="fas fa-envelope"></i> Email: support@skillconnect.com</p>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>