<?php
require 'db_connect.php';
require 'vendor/autoload.php'; // Include PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Generate reset code (4-digit random number) and expiry time (15 minutes from now)
    $reset_code = random_int(1000, 9999); // 4-digit reset code
    $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes")); // Expiry set to 15 minutes from now

    // Check if email exists in the `users` table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Email not found in our records.");
    }

    // Delete any existing reset code for this email (ensure one code per email at a time)
    $stmt = $conn->prepare("DELETE FROM reset_password WHERE email = ?");
    $stmt->execute([$email]);

    // Insert the new reset code and expiry into `reset_password` table
    $stmt = $conn->prepare("INSERT INTO reset_password (email, reset_code, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $reset_code, $expiry]);

    // Send the reset code to the user's email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configure SMTP settings for PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server (Gmail)
        $mail->SMTPAuth = true;
        $mail->Username = 'saadlaptopmail@gmail.com'; // Sender Gmail address
        $mail->Password = 'bgyf whmw rdpx xfsw'; // Sender Gmail App Password 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set the sender and recipient for the email
        $mail->setFrom('saadlaptopmail@gmail.com', 'Skill Connect');
        $mail->addAddress($email); // Send to the email the user entered

        // Set email format to HTML and include the reset code in the body
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Code';
        $mail->Body = "<p>Hi,</p><p>Your password reset code is: <strong>$reset_code</strong></p><p>This code is valid for 15 minutes.</p>";

        // Send the email
        $mail->send();
        echo "Reset code sent to your email. Please check your inbox.";

        // Redirect to the verification page
        header("Location: verify_reset_code.php?email=" . urlencode($email)); // Pass email to verification page
        exit();
    } catch (Exception $e) {
        echo "Failed to send reset code. Please try again. Error: " . $mail->ErrorInfo;
    }
}
?>

<!-- HTML Form for entering the email to request a password reset -->
<form action="send_reset_code.php" method="post">
    <label for="email">Enter your email address:</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Request Reset Code</button>
</form>