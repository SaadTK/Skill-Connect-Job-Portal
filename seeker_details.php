<?php
session_start();
include "db_connect.php";
include('header.php');

// GET seeker_id from URL 
$seeker_id = isset($_GET['seeker_id']) ? intval($_GET['seeker_id']) : 0;

try {
    // Fetch seeker details
    $sql = "SELECT * FROM users WHERE user_id = :seeker_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':seeker_id', $seeker_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Fetch the seeker details
        $seeker = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No seeker found.";
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeker Details - Skill Connect</title>

    <!-- OG Meta Tags -->
    <meta property="og:title" content="Seeker Details - Skill Connect | Your Trusted Job Portal in Bangladesh" />
    <meta property="og:description"
        content="Detailed information about a job seeker. Learn more about their experience, skills, and contact information." />
    <meta property="og:image" content="/assets/img/hero/seekers.jpg" />

    <?php
    if ($_SERVER['HTTP_HOST'] === 'localhost') {
        $baseUrl = "http://localhost/Skill_Connect_Project";
    } else {
        $baseUrl = "https://skillconnect.webhop.me";
    }
    ?>
    <meta property="og:url"
        content="<?= htmlspecialchars($baseUrl); ?>/seeker_details.php?seeker_id=<?= $seeker_id; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Skill Connect" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@500&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 76px;
            font-family: 'Roboto', sans-serif;
        }

        main {
            padding-top: 3rem;
        }

        .seeker-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .seeker-card-header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            border-radius: 8px 8px 0 0;
        }

        .seeker-card-header h5 {
            margin: 0;
        }

        .seeker-card-body {
            padding: 1.5rem;
        }

        .contact-btn {
            background-color: #007bff;
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 5px;
            text-decoration: none;
        }

        .contact-btn:hover {
            background-color: #0056b3;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 2rem;
            color: #007bff;
        }

        .seeker-info p {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .seeker-info strong {
            color: #007bff;
        }
    </style>
</head>

<body style="padding-top: 70px;">
    <?php include 'header.php'; ?>

    <main class="container">
        <!-- Seeker Details -->
        <div class="seeker-card mb-4">
            <div class="seeker-card-header">
                <h5 class="text-center"><?= htmlspecialchars($seeker['first_name'] . ' ' . $seeker['last_name']); ?>
                </h5>
            </div>
            <div class="seeker-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="section-title">Overview</h5>
                        <div class="seeker-info">
                            <p><strong>Location:</strong> <?= htmlspecialchars($seeker['address']); ?></p>
                            <p><strong>Skills:</strong> <?= htmlspecialchars($seeker['skills']); ?></p>
                            <p><strong>Experience:</strong> <?= htmlspecialchars($seeker['work_experience']); ?></p>
                            <p><strong>Education:</strong> <?= htmlspecialchars($seeker['education']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="section-title">Contact Details</h5>
                        <div class="seeker-info">
                            <p><strong>Email:</strong> <?= htmlspecialchars($seeker['email']); ?></p>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($seeker['phone_number']); ?></p>
                        </div>
                        <!-- Contact Button -->
                        <button type="button" class="btn btn-primary contact-btn" data-bs-toggle="modal"
                            data-bs-target="#contactModal">
                            Contact Seeker
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Contact Seeker Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Contact Seeker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="send_email.php" method="POST">
                    <div class="modal-body">
                        <!-- Hidden fields for seeker and employer info -->
                        <input type="hidden" name="seeker_id" value="<?= $seeker['user_id']; ?>">
                        <input type="hidden" name="employer_id" value="<?= $_SESSION['user_id']; ?>">
                        <!-- Assuming employer is logged in -->

                        <!-- To email (Seeker's Email) -->
                        <div class="mb-3">
                            <label for="toEmail" class="form-label">To</label>
                            <input type="email" class="form-control" id="toEmail" name="toEmail"
                                value="<?= $seeker['email']; ?>" readonly>
                        </div>

                        <!-- From email (Employer's Email) -->
                        <div class="mb-3">
                            <label for="fromEmail" class="form-label">From</label>
                            <input type="email" class="form-control" id="fromEmail" name="fromEmail"
                                value="<?= $_SESSION['email']; ?>" readonly>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label for="body" class="form-label">Message</label>
                            <textarea class="form-control" id="body" name="body" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>