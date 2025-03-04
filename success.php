<?php

/**
 * Success page
 * Displayed after successful authentication
 */

// Include necessary files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('index.php');
}

// Get user information from session
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$user_name = $_SESSION['user_name'];
$auth_type = $_SESSION['auth_type'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Login Success</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <!-- <img src="assets/images/logo.png" alt="Logo"> -->
                <h1><?php echo SITE_NAME; ?></h1>
            </div>
        </header>

        <main>
            <div class="success-container">
                <div class="success-icon">
                    <img src="assets/images/icons/success.png" alt="Success">
                </div>

                <h2>Login Successful!</h2>

                <div class="user-info">
                    <p>Welcome back, <strong><?php echo htmlspecialchars($user_name); ?></strong>!</p>
                    <p>You are signed in using: <strong><?php echo ucfirst(htmlspecialchars($auth_type)); ?></strong></p>
                    <p>Email: <strong><?php echo htmlspecialchars($user_email); ?></strong></p>
                </div>

                <div class="success-actions">
                    <a href="index.php" class="button">Go to Dashboard</a>
                    <a href="process-logout.php" class="button logout">Sign Out</a>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </footer>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>