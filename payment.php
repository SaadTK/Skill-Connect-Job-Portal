<?php
session_start();
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51QMpJjJt6DcjymCdHM5eC1U2vI3xT48irVFuINBrV3s3vo8tol8w1S4ZXR3bZQGCxBDf2m0eLAiTkypwIUz6COqZ00bTkqbtI9');

// Check if job_id is in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $_SESSION['job_id'] = $job_id; // Store job_id in the session for the next page
} else {
    echo "Job ID is missing.";
    exit();
}

// Handle POST request to create a PaymentIntent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = 50 * 100; // 10 taka or 1000 poysha

    try {
        // Create a PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'description' => 'Job Post Payment',
            'metadata' => [
                'job_id' => $job_id, // Use the job_id from URL
                'user_id' => $_SESSION['user_id'] // Use user_id from the session if logged in
            ]
        ]);

        // Send the client secret to the frontend
        echo json_encode([
            'clientSecret' => $paymentIntent->client_secret
        ]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo json_encode([
            'error' => $e->getMessage()
        ]);
    }
    exit(); // Ensure script stops after handling POST
}

// Redirect to card_payment.php for GET requests
header("Location: card_payment.php");
exit();
?>