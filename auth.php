<?php

/**
 * Authentication page
 * Handles different authentication types and displays appropriate forms
 */

// Include necessary files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if user is already logged in
if (is_logged_in()) {
    redirect('success.php');
}

// Get authentication type from URL
$auth_type = isset($_GET['type']) ? sanitize_input($_GET['type']) : 'email';

// Validate the auth type
$valid_types = ['google', 'apple', 'email', 'register'];
if (!in_array($auth_type, $valid_types)) {
    $auth_type = 'email'; // Default to email if invalid type
}

// Set page title based on auth type
$page_title = 'Sign In';
if ($auth_type == 'register') {
    $page_title = 'Create Account';
}

// Generate CSRF token for form protection
$csrf_token = generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="index.php">
                    <!-- <img src="assets/images/logo.png" alt="Logo"> -->
                    <h1><?php echo SITE_NAME; ?></h1>
                </a>
            </div>
        </header>

        <main>
            <div class="auth-container">
                <h2><?php echo $page_title; ?></h2>

                <?php if ($auth_type == 'google'): ?>
                    <!-- Google Sign In Form -->
                    <div class="auth-form">
                        <p>To continue with Google, click the button below:</p>

                        <form action="process-auth.php" method="post" id="google-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="auth_type" value="google">

                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Google Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Google Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="submit-button google">Continue with Google</button>
                            </div>

                            <p class="form-note">
                                <small>Note: This is a simulation. In a real app, you would use Google OAuth.</small>
                            </p>
                        </form>
                    </div>

                <?php elseif ($auth_type == 'apple'): ?>
                    <!-- Apple Sign In Form -->
                    <div class="auth-form">
                        <p>To continue with Apple, click the button below:</p>

                        <form action="process-auth.php" method="post" id="apple-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="auth_type" value="apple">

                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Apple ID Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Apple ID Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="submit-button apple">Continue with Apple</button>
                            </div>

                            <p class="form-note">
                                <small>Note: This is a simulation. In a real app, you would use Apple Sign In.</small>
                            </p>
                        </form>
                    </div>

                <?php elseif ($auth_type == 'register'): ?>
                    <!-- Register Form -->
                    <div class="auth-form">
                        <p>Create a new account:</p>

                        <form action="process-auth.php" method="post" id="register-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="auth_type" value="register">

                            <div class="form-group">
                                <label for="email">Email Address:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="full_name">Full Name:</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="submit-button register">Create Account</button>
                            </div>

                            <p class="form-note">
                                Already have an account? <a href="auth.php?type=email">Sign in</a>
                            </p>
                        </form>
                    </div>

                <?php else: ?>
                    <!-- Email Sign In Form (Default) -->
                    <div class="auth-form">
                        <p>Sign in with your email and password:</p>

                        <form action="process-auth.php" method="post" id="email-form">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <input type="hidden" name="auth_type" value="email">

                            <div class="form-group">
                                <label for="email">Email Address:</label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="submit-button email">Sign In</button>
                            </div>

                            <p class="form-note">
                                Don't have an account? <a href="auth.php?type=register">Create one</a>
                            </p>
                        </form>
                    </div>
                <?php endif; ?>

                <div class="back-link">
                    <a href="index.php">Back to Sign In Options</a>
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