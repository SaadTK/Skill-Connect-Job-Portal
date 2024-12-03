<?php
session_start();
include "db_connect.php";

$client_id = 'Ov23liOnO6vm8ZU69Rh8';
$client_secret = 'bbd2a227bfec2751a6e810125aa409919d5ad970';
$code = $_GET['code'];

// Step 1: Get access token
$token_url = "https://github.com/login/oauth/access_token";
$data = [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'code' => $code,
];

$options = [
    'http' => [
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($data),
    ],
];
$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);
parse_str($response, $output);

if (!isset($output['access_token'])) {
    die("Error obtaining GitHub access token.");
}

$access_token = $output['access_token'];

// Step 2: Get user details from GitHub
$user_url = "https://api.github.com/user";
$options = [
    'http' => [
        'header' => "Authorization: token $access_token\r\nUser-Agent: SkillConnect\r\n",
    ],
];
$context = stream_context_create($options);
$user_info = file_get_contents($user_url, false, $context);
$user = json_decode($user_info, true);

if (!isset($user['id'])) {
    die("Error fetching GitHub user information.");
}

$github_id = $user['id'];
$first_name = $user['name'] ? explode(" ", $user['name'])[0] : $user['login']; // First part of the name or GitHub username
$last_name = isset($user['name']) && strpos($user['name'], ' ') !== false ? explode(" ", $user['name'], 2)[1] : ""; // Last name

// Fetch emails from the GitHub API
$email = null;
$email_url = "https://api.github.com/user/emails"; // Requesting emails
$options = [
    'http' => [
        'header' => "Authorization: token $access_token\r\nUser-Agent: SkillConnect\r\n",
    ],
];
$context = stream_context_create($options);
$email_info = file_get_contents($email_url, false, $context);
$emails = json_decode($email_info, true);

// Loop through emails to find a verified primary email
foreach ($emails as $email_data) {
    if ($email_data['primary'] && $email_data['verified']) {
        $email = $email_data['email'];
        break;
    }
}

if (!$email) {
    die("GitHub did not return a verified email address. Please ensure your email is public or try logging in again.");
}

// Step 3: Check if a user exists by github_id or email
$stmt = $conn->prepare("SELECT * FROM users WHERE github_id = :github_id OR email = :email");
$stmt->execute([
    'github_id' => $github_id,
    'email' => $email,
]);
$existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_user) {
    // Update existing user
    $update_stmt = $conn->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name WHERE user_id = :user_id");
    $update_stmt->execute([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'user_id' => $existing_user['user_id'],
    ]);
    $_SESSION['user_id'] = $existing_user['user_id'];
    $_SESSION['email'] = $existing_user['email'];
    $_SESSION['first_name'] = $existing_user['first_name'];
    $_SESSION['role'] = $existing_user['role'];
} else {
    // Insert new user
    $insert_stmt = $conn->prepare("INSERT INTO users (github_id, first_name, last_name, email, role) VALUES (:github_id, :first_name, :last_name, :email, :role)");
    $insert_stmt->execute([
        'github_id' => $github_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'role' => 0, // Default role is candidate
    ]);

    $user_id = $conn->lastInsertId();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['role'] = 0; // Default role is candidate
}

// Redirect to dashboard based on role
header("Location: " . ($_SESSION['role'] == 1 ? "recruiter_dashboard.php" : "dashboard.php"));
exit();
?>