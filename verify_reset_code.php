<?php
require 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $reset_code = $_POST['reset_code'];

    // Query the reset_password table to fetch the stored reset code for the given email
    $stmt = $conn->prepare("SELECT * FROM reset_password WHERE email = ? AND reset_code = ?");
    $stmt->execute([$email, $reset_code]);

    // Check if a matching reset code is found
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Code is valid; proceed to the password reset page
        $_SESSION['email'] = $email; // Store email in session for resetting password
        header("Location: reset_password.php");
        exit();
    } else {
        // Invalid reset code
        echo "Invalid or expired reset code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Reset Code</title>

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

        input[type="text"] {
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
        <h2>Verify Reset Code</h2>
        <form action="verify_reset_code.php" method="post">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <label for="reset_code">Enter the reset code:</label>
            <input type="text" name="reset_code" id="reset_code" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>

</html>