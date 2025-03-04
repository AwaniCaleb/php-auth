<?php

/**
 * Main configuration file for the website
 * Contains global configuration variables and settings
 */

define('MODE', 'development');

// Enable error reporting for development (disable in production)
if (MODE === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Session configuration
session_start();

// Site configuration
define('SITE_NAME', 'PHP Auth');
define('SITE_URL', 'http://localhost/php-auth'); // Change this to your actual URL in production

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Change to your database username
define('DB_PASS', '');              // Change to your database password
define('DB_NAME', 'phpauth');       // Change to your database name

// Email configuration (if you want to email login data)
define('ADMIN_EMAIL', 'your-email@example.com');

// For security - random token for form validation
define('CSRF_TOKEN_SECRET', 'change-this-to-a-random-string');
