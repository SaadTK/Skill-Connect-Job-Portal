<?php
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = md5($_POST['new_password']); // Hash the password

    // Update password in the users table
    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE email = :email");
    if ($stmt->execute(['password' => $new_password, 'email' => $email])) {
        echo "Your password has been reset successfully.";
    } else {
        echo "Failed to reset password. Please try again.";
    }

    // Clean up the reset token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = :email");
    $stmt->execute(['email' => $email]);
}
?>