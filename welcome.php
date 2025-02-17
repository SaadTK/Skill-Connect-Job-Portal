<?php
// Check if session is already started before starting it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the first name is set in the session
if (isset($_SESSION['first_name']) && !empty($_SESSION['first_name'])) {
    // Store the first name in a variable for use
    $firstName = htmlspecialchars($_SESSION['first_name']);

    // Unset the first name from the session to avoid repeating the message
    unset($_SESSION['first_name']);
    ?>
    <div class="modal" style="display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center; animation: fadeIn 0.5s;">
        <div class="modal-content" style="background-color: #fff; padding: 20px; border-radius: 8px; width: 80%; max-width: 500px; text-align: center; animation: slideUp 0.5s;">
            <span class="close" onclick="document.querySelector('.modal').style.display='none'" style="position: absolute; top: 10px; right: 20px; font-size: 24px; font-weight: bold; cursor: pointer; color: #333;">&times;</span>
            <h2 style="font-size: 24px; font-weight: 600; color: #333; margin-bottom: 10px;"><b>Welcome, <?php echo $firstName; ?></b></h2>
            <h4 style="font-size: 18px; color: #777;">We're glad to have you here.</h4>
        </div>
    </div>

    <script>
        // Close the modal when the user clicks outside of it
        window.onclick = function (event) {
            if (event.target.className === 'modal') {
                document.querySelector('.modal').style.display = 'none';
            }
        }
    </script>

    <style>
        /* Animation for modal fade-in */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Animation for modal sliding up */
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>

    <?php
}
?>
