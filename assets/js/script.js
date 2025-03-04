/**
 * Main JavaScript file for the website
 * Handles client-side validation and interactions
 */

$(document).ready(function () {
    /**
     * Form validation for email login form
     * Checks that email and password are provided
     */
    $('#email-form').submit(function (event) {
        var email = $('#email').val();
        var password = $('#password').val();
        var errorMessage = '';

        if (!email) {
            errorMessage = 'Please enter your email address.';
        } else if (!isValidEmail(email)) {
            errorMessage = 'Please enter a valid email address.';
        } else if (!password) {
            errorMessage = 'Please enter your password.';
        }

        if (errorMessage) {
            event.preventDefault();
            showErrorMessage(errorMessage);
        }
    });

    /**
     * Form validation for registration form
     * Checks email, name, password match and strength
     */
    $('#register-form').submit(function (event) {
        var email = $('#email').val();
        var fullName = $('#full_name').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        var errorMessage = '';

        if (!email) {
            errorMessage = 'Please enter your email address.';
        } else if (!isValidEmail(email)) {
            errorMessage = 'Please enter a valid email address.';
        } else if (!fullName) {
            errorMessage = 'Please enter your full name.';
        } else if (!password) {
            errorMessage = 'Please enter a password.';
        } else if (password.length < 8) {
            errorMessage = 'Password must be at least 8 characters long.';
        } else if (!isStrongPassword(password)) {
            errorMessage = 'Password must contain at least one uppercase letter, one lowercase letter, and one number.';
        } else if (password !== confirmPassword) {
            errorMessage = 'Passwords do not match.';
        }

        if (errorMessage) {
            event.preventDefault();
            showErrorMessage(errorMessage);
        }
    });

    /**
     * Form validation for Google and Apple login forms
     * Checks that email and name are provided
     */
    $('#google-form, #apple-form').submit(function (event) {
        var email = $('#email').val();
        var fullName = $('#full_name').val();
        var errorMessage = '';

        if (!email) {
            errorMessage = 'Please enter your email address.';
        } else if (!isValidEmail(email)) {
            errorMessage = 'Please enter a valid email address.';
        } else if (!fullName) {
            errorMessage = 'Please enter your full name.';
        }

        if (errorMessage) {
            event.preventDefault();
            showErrorMessage(errorMessage);
        }
    });

    /**
     * Real-time password confirmation validation
     * Checks if passwords match as user types
     */
    $('#confirm_password').on('input', function () {
        var password = $('#password').val();
        var confirmPassword = $(this).val();

        if (password && confirmPassword) {
            if (password !== confirmPassword) {
                $(this).css('border-color', '#f44336');
            } else {
                $(this).css('border-color', '#4caf50');
            }
        }
    });

    /**
     * Password strength indicator
     * Shows visual feedback as user types password
     */
    $('#password').on('input', function () {
        var password = $(this).val();
        var strength = getPasswordStrength(password);

        // You could add a visual indicator in the UI
        if (strength === 'weak') {
            $(this).css('border-color', '#f44336');
        } else if (strength === 'medium') {
            $(this).css('border-color', '#ff9800');
        } else if (strength === 'strong') {
            $(this).css('border-color', '#4caf50');
        } else {
            $(this).css('border-color', '#ddd');
        }
    });

    /**
     * Display error messages in the UI
     * @param {string} message - The error message to display
     */
    function showErrorMessage(message) {
        // Remove any existing error messages
        $('.error-message').remove();

        // Create and insert the error message
        var errorDiv = $('<div class="error-message"></div>').text(message);
        $('.auth-form').prepend(errorDiv);

        // Scroll to the error message
        $('html, body').animate({
            scrollTop: $('.error-message').offset().top - 20
        }, 500);
    }

    /**
     * Check if email is valid using regex
     * @param {string} email - The email to validate
     * @return {boolean} True if valid, false otherwise
     */
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Check if password meets strength requirements
     * @param {string} password - The password to check
     * @return {boolean} True if strong enough, false otherwise
     */
    function isStrongPassword(password) {
        // At least 1 uppercase, 1 lowercase, 1 number
        var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
        return strongRegex.test(password);
    }

    /**
     * Calculate password strength
     * @param {string} password - The password to evaluate
     * @return {string} 'weak', 'medium', or 'strong'
     */
    function getPasswordStrength(password) {
        if (!password) return 'none';

        var strength = 0;

        // Length check
        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;

        // Character type checks
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[a-z]/.test(password)) strength += 1;
        if (/\d/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;

        if (strength < 3) return 'weak';
        if (strength < 5) return 'medium';
        return 'strong';
    }

    /**
     * Check for success/error messages in the URL
     * and display them appropriately
     */
    function checkMessages() {
        // This would be implemented if using URL parameters for messages
        // For this demo, we're using session variables instead
    }

    // Run message check on page load
    checkMessages();
});