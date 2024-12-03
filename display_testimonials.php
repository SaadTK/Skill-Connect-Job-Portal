<?php
include 'db_connect.php'; // Database connection

// Fetch up to 4 users who have submitted testimonials
$stmt = $conn->prepare("SELECT first_name, testimonial FROM users WHERE testimonial IS NOT NULL LIMIT 4");
$stmt->execute();
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<style>
    .testimonial-card {
        border-radius: 10px;
        /* Rounded corners for the card */
        padding: 20px;
        background-color: #ffffff;
        /* White background for the card */
        transition: transform 0.2s ease-in-out;
        /* Smooth hover effect */
    }

    .testimonial-card:hover {
        transform: scale(1.05);
        /* Slightly enlarge on hover */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        /* Shadow on hover */
    }

    .testimonial-card .card-title {
        font-size: 1.2em;
        font-weight: 600;
        /* Bold font for user names */
    }

    .testimonial-card .card-text {
        font-style: italic;
        /* Italicize the testimonial text */
        color: #555;
        /* Softer color for the testimonial text */
    }
</style>

<!-- Testimonials Section -->
<section class="py-5">

    <h2 class="text-center mb-5 text-primary">What Our Users Say</h2>
    <div class="row justify-content-center mb-4">
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="col-md-3 mb-4">
                <div class="card testimonial-card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <!-- Display User's First Name -->
                        <h5 class="card-title text-dark font-weight-bold">
                            <?php echo htmlspecialchars($testimonial['first_name']); ?>
                        </h5>

                        <!-- Display User's Testimonial -->
                        <p class="card-text text-muted">"<?php echo htmlspecialchars($testimonial['testimonial']); ?>"</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>