-- ============================================================
-- BrandEve Solutions — Database Schema
-- ============================================================
-- Import this file into MySQL to set up the entire database.
--
--   1. Open phpMyAdmin or MySQL CLI
--   2. Import this file (no need to pre-create the database)
--   3. Change the default admin password immediately after first login
-- ============================================================


-- ------------------------------------------------------------
-- Create database (if it doesn't already exist)
-- ------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `brandeve_db`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;

USE `brandeve_db`;


-- ------------------------------------------------------------
-- Table: admin_users
-- Stores admin panel accounts.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- Table: enquiries
-- Stores contact form submissions from the website.
-- Soft-delete uses the `deleted_at` column.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT,
    status ENUM('unread', 'read') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- Table: password_resets
-- Stores password reset verification codes.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,        -- kept for compatibility (currently unused)
    code VARCHAR(10),                   -- 6-digit verification code
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_token (token),
    INDEX idx_code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- Table: users
-- Stores registered public users (website sign-ups).
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    mobile VARCHAR(20),
    is_verified BOOLEAN DEFAULT FALSE,
    verification_code VARCHAR(10),
    code_expires_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- Default admin account
-- ------------------------------------------------------------
-- Username: admin
-- Password: admin123   ← change this immediately after login
--
-- To generate your own password hash, run this in PHP:
--   <?php echo password_hash('your_new_password', PASSWORD_DEFAULT); ?>
-- Then paste the result in place of the string below.
-- ------------------------------------------------------------
INSERT INTO admin_users (username, email, password_hash)
VALUES (
    'admin',
    'admin@example.com',
    '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18JuywdBm0TQwKt5wJmO5S'
)
ON DUPLICATE KEY UPDATE
    email = VALUES(email),
    password_hash = VALUES(password_hash);