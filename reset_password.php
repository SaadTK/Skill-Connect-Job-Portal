<?php
include "db_connect.php";
session_start();

// Check if the email session is set (to ensure the user has passed the reset code verification)
if (!isset($_SESSION['email'])) {
    die("Unauthorized access.");
}

// Process the password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $email = $_SESSION['email'];

    // Hash the new password using MD5
    $hashed_password = md5($new_password); // MD5 hash the password (not secure)

    // Update the password in the users table
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    if ($stmt->execute([$hashed_password, $email])) {
        echo "Your password has been reset successfully.";

        // Optionally, delete the reset code from the reset_password table
        $stmt = $conn->prepare("DELETE FROM reset_password WHERE email = ?");
        $stmt->execute([$email]);

        // Redirect to login page after a second
        header("Refresh: 1; url=login.php");
        exit();
    } else {
        echo "Failed to reset the password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }

        .message a {
            color: #4CAF50;
            text-decoration: none;
        }

        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Your Password</h2>
        <form method="POST" action="reset_password.php">
            <label for="new_password">Enter your new password:</label>
            <input type="password" name="new_password" required>
            <button type="submit">Reset Password</button>
        </form>
        <div class="message">
            <p>If you remember your password, <a href="login.php">login here</a>.</p>
        </div>
    </div>
</body>

</html>