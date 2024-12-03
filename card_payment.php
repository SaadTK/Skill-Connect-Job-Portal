<?php
// Start the session to access session variables
session_start();

// Get job_id from session or redirect if it's missing
if (isset($_SESSION['job_id'])) {
    $job_id = $_SESSION['job_id'];
} else {
    header("Location: payment_failure.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Card Payment</title>
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Complete Your Payment</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Job Posting Payment</h5>
                        <p class="card-text">You're about to make a payment to post your job. Please enter your card
                            details below to proceed.</p>

                        <form id="payment-form">
                            <div id="card-element" class="form-control mb-3"></div>
                            <button type="submit" class="btn btn-success btn-block">Pay Now</button>
                            <div id="error-message" class="text-danger mt-3"></div>
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Secure payment powered by Stripe</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (CDN) -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>


    <script>
        // Initialize Stripe.js with your publishable key
        const stripe = Stripe('pk_test_51QMpJjJt6DcjymCd21dGFbDN2qxme6A3X6WAQq7n23zmj10Dvgv4FWKBfPY65ebzuI4MQh7a0WvhfuXmaRkYCKSu00xKvN5KJC');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        // Fetch the client secret from the backend (payment.php)
        fetch('payment.php?job_id=<?= $job_id ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.clientSecret) {
                    const form = document.getElementById('payment-form');
                    form.addEventListener('submit', async (event) => {
                        event.preventDefault();

                        const { paymentIntent, error } = await stripe.confirmCardPayment(data.clientSecret, {
                            payment_method: {
                                card: cardElement,
                            }
                        });

                        if (error) {
                            document.getElementById('error-message').textContent = `Error: ${error.message}`;
                        } else if (paymentIntent.status === 'succeeded') {
                            alert('Payment successful!');
                            // Pass the job_id to payment_success.php
                            window.location.href = `payment_success.php?job_id=${<?= $_SESSION['job_id'] ?>}`;
                        }
                    });
                } else if (data.error) {
                    alert('Error: ' + data.error); // Show server-side error
                } else {
                    alert('Unexpected response from server.');
                }
            })
            .catch(error => {
                alert('Error fetching client secret: ' + error);
            });
    </script>

</body>

</html>