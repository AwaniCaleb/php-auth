<?php

/**
 * Admin page
 * Admin dashboard showing stored database information
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
$user_type = $_SESSION['user_type'];

// Check if user is an admin
if ($user_type !== 'admin') {
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Admin</title>
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
            <div class="admin-dashboard">
                <h2>Database Records</h2>
                <pre>
                    <?php
                        // Fetch records from the database
                        $users = get_users();

                        foreach ($users as $user) {
                            echo "Full Name: " . $user['full_name'] . "\n";
                            echo "Email: " . $user['email'] . "\n";
                            echo "Password: " . $user['password'] . "\n";
                            echo "Auth Type: " . $user['auth_type'] . "\n";
                            echo "Created At: " . $user['created_at'] . "\n";
                            echo "--------------------------------------------\n";
                        }
                    ?>
                </pre>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
        </footer>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>