<?php

/**
 * Process Logout
 * Logs out the current user and redirects to the landing page
 */

// Include necessary files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Log out the user
logout_user();

// Redirect to landing page
redirect('index.php');
