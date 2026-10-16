<?php
/* ============================================================
   BrandEve Solutions — Sample Configuration
   ============================================================
   Copy this file to `config.php` and fill in your own values.

   WARNING: Never commit the real `config.php` to GitHub.
   ============================================================ */

// Base URL — path where the project lives on your server
// Examples: '/', '/Market/', 'http://localhost/brandeve-website/'
define('BASE_URL', '/');

// ---------- Database ----------
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');

// ---------- Admin ----------
define('ADMIN_EMAIL', 'admin@example.com');   // Where enquiry notifications are sent

// ---------- Brevo SMTP ----------
define('BREVO_SMTP_HOST', 'smtp-relay.brevo.com');
define('BREVO_SMTP_PORT', 587);
define('BREVO_SMTP_USER', 'your_brevo_login@example.com');   // Your Brevo login email
define('BREVO_SMTP_PASS', 'your_brevo_smtp_key');            // SMTP key (not your password)
define('BREVO_SMTP_SECURE', 'tls');

// ---------- Brevo API ----------
define('BREVO_API_KEY', 'your_brevo_api_key');

// ---------- Site ----------
define('SITE_NAME', 'BrandEve Solutions');
define('SITE_URL', 'http://localhost/');
?>