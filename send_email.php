<?php
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $seeker_id = $_POST['seeker_id'];
    $employer_id = $_POST['employer_id'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    try {
        // Insert email details into the database
        $stmt = $conn->prepare("INSERT INTO email_communications (seeker_id, employer_id, subject, body) 
                               VALUES (:seeker_id, :employer_id, :subject, :body)");
        $stmt->bindParam(':seeker_id', $seeker_id);
        $stmt->bindParam(':employer_id', $employer_id);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':body', $body);
        $stmt->execute();

        // Success message with a "Go Back" button
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Email Sent</title>
            <style>
                
                .go-back-btn {
                    padding: 10px 20px;
                    font-size: 16px;
                    font-weight: bold;
                    color: white;
                    background-color: #007bff; 
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s, transform 0.3s;
                }

                .go-back-btn:hover {
                    background-color: #0056b3; 
                    transform: translateY(-2px); 
                }

                .go-back-btn:active {
                    background-color: #004085; 
                    transform: translateY(0);
                }

                .go-back-btn:focus {
                    outline: none;
                }
            </style>
        </head>
        <body>
            <div>
                <h2>Email sent successfully!</h2>
                <button onclick='history.back()' class='go-back-btn'>Go Back</button>
            </div>
        </body>
        </html>";
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>