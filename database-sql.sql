-- Create the database
CREATE DATABASE IF NOT EXISTS phpauth;
USE phpauth;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    auth_type VARCHAR(50) NOT NULL,  -- 'google', 'apple', 'email', etc.
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    password VARCHAR(255),           -- Will be hashed if direct login
    profile_image VARCHAR(255),      -- URL to profile image
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create login_attempts table to track login history
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    auth_type VARCHAR(50) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    status VARCHAR(20),              -- 'success', 'failed'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
