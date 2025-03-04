<?php
/**
 * Landing page with social login options
 * This is the entry point for users to sign in
 */

// Include necessary files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is already logged in
if (is_logged_in()) {
    redirect('success.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Welcome</title>
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
            <div class="auth-container">
                <h2>Welcome</h2>
                <p>Please choose a sign-in method to continue:</p>
                
                <div class="auth-options">
                    <!-- Google Sign In Button -->
                    <a href="auth.php?type=google" class="auth-button google">
                        <img src="assets/images/icons/google.png" alt="Google">
                        Sign in with Google
                    </a>
                    
                    <!-- Apple Sign In Button -->
                    <a href="auth.php?type=apple" class="auth-button apple">
                        <img src="assets/images/icons/apple.png" alt="Apple">
                        Sign in with Apple
                    </a>
                    
                    <!-- Email Sign In Button -->
                    <a href="auth.php?type=email" class="auth-button email">
                        <img src="assets/images/icons/email.png" alt="Email">
                        Sign in with Email
                    </a>
                    
                    <!-- Create Account Button -->
                    <a href="auth.php?type=register" class="auth-button register">
                        Create an Account
                    </a>
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