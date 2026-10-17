
# BrandEve Solutions — Digital Marketing Website

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-in%20development-yellow)

A modern, responsive digital marketing website for **BrandEve Solutions** — a
full-service brand activation, event management, and marketing agency.

---

## ✨ Features

### Public Website
- 🎨 Modern hero section with animated gradient text
- 🏢 Trust bar with client logos (auto-scrolling marquee)
- 🧩 Services bento grid — Corporate Events, Branding, Marketing,
  Launches, Shows & Concerts, Weddings
- 💼 Portfolio showcase with interactive hover cards and lightbox
- 💬 Testimonials section
- 📞 Contact form with database storage and email notifications
- 📱 Fully responsive layout (mobile, tablet, desktop)

### Admin Panel
- 🔐 Session-based admin authentication
- 📊 Dashboard with enquiry statistics
- 📬 Enquiry management — mark as read, soft-delete, restore
- 👥 Multi-admin support — add and remove admins
- 🔑 Password change and notification email settings
- 🗑️ Deleted enquiries recovery

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.x |
| Database | MySQL 8.x |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Icons | Font Awesome 6.5 |
| Email | Brevo (Sendinblue) SMTP + API |
| Fonts | System font stack (Segoe UI, Tahoma, Verdana) |

---

## 📦 Dependencies

This project uses **Composer** to manage PHP dependencies (like the Brevo SDK,
PHPMailer, etc.).

The `vendor/` folder is **not included** in this repository because:

- It can be several hundred MB
- It's auto-generated from `composer.json`
- It's platform-dependent (different PHP versions may need different builds)

You must install dependencies yourself after cloning — see the
**Installation** section below.

> **Note:** If you don't have Composer installed, get it here:
> https://getcomposer.org/download/

---

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/YOUR-USERNAME/brandeve-website.git
cd brandeve-website
```

### 2. Install PHP dependencies

```bash
composer install
```

This reads `composer.json` and `composer.lock`, downloads the exact package
versions, and generates the `vendor/` folder. Expected output:

```
Loading composer repositories with package information
Installing dependencies from lock file
Package operations: 12 installs, 0 updates, 0 removals
  - Installing guzzlehttp/guzzle (7.8.0): Extracting archive
  - Installing brevo/brevo-php (1.0.0): Extracting archive
  ...
Generating autoload files
```

### 3. Set up the database

- Open **phpMyAdmin** or MySQL CLI
- Create a new database (e.g. `brandeve_db`)
- Import `database/db.sql`

### 4. Configure the connection

Copy the sample config:

```bash
cp includes/config.sample.php includes/config.php
```

Then edit `includes/config.php` and fill in your own values:

```php
<?php
define('BASE_URL', '/');
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'your_db_name');
define('ADMIN_EMAIL', 'admin@example.com');
define('BREVO_SMTP_HOST', 'smtp-relay.brevo.com');
define('BREVO_SMTP_PORT', 587);
define('BREVO_SMTP_USER', 'your_brevo_login');
define('BREVO_SMTP_PASS', 'your_brevo_smtp_key');
define('BREVO_SMTP_SECURE', 'tls');
define('BREVO_API_KEY', 'your_brevo_api_key');
define('SITE_NAME', 'BrandEve Solutions');
define('SITE_URL', 'http://localhost/');
?>
```

### 5. Run locally

- Place the project inside your web server root
  (`htdocs/` for XAMPP, `www/` for WAMP)
- Visit: `http://localhost/brandeve-website/`
- Admin panel: `http://localhost/brandeve-website/admin/`

**Default admin credentials — change immediately after first login:**

| Username | Password |
|---|---|
| `admin` | `admin123` |

---

## ⚡ Quick Start

For those who just want the commands without the details:

```bash
# 1. Clone and enter the project
git clone https://github.com/YOUR-USERNAME/brandeve-website.git
cd brandeve-website

# 2. Install PHP dependencies
composer install

# 3. Create your config from the sample
cp includes/config.sample.php includes/config.php
# → open includes/config.php and fill in your DB credentials

# 4. Import the database
# → Open phpMyAdmin, create `brandeve_db`, import `database/db.sql`

# 5. Open in browser
# → http://localhost/brandeve-website/
```

---

## 📂 Project Structure

```
brandeve-website/
│
├── admin/                      # Admin panel (login-protected)
│   ├── index.php               # Dashboard with enquiry statistics
│   ├── admins.php              # Manage admin accounts
│   ├── users.php               # Manage registered users
│   ├── deleted.php             # Restore or permanently delete enquiries
│   ├── settings.php            # Email, add admin, change password
│   ├── login.php               # Admin login page
│   └── logout.php              # Ends the admin session
│
├── includes/
│   ├── config.sample.php       # Template config — copy to config.php
│   ├── navbar.php              # Shared header / navigation
│   └── footer.php              # Shared footer
│
├── pages/
│   ├── home.php                # Homepage (main landing)
│   ├── about.php               # About the company
│   ├── contact.php             # Contact form (saves to DB + sends email)
│   ├── faq.php                 # Frequently asked questions
│   ├── portfolio.php           # Project showcase with lightbox
│   └── linkServices/           # Individual service detail pages
│       ├── branding.php
│       ├── digital-marketing.php
│       ├── events.php
│       ├── exhibition.php
│       ├── launch.php
│       ├── marketing.php
│       ├── promotion.php
│       ├── shows.php
│       └── wedding.php
│
├── assets/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── images/
│       ├── brands/             # Client / trust-bar logos
│       ├── portfolio/          # Portfolio project images
│       └── logos.png           # Site favicon
│
├── database/
│   └── db.sql                  # Database schema (tables + default admin)
│
├── .gitignore                  # Files Git should never track
├── README.md                   # This file
└── LICENSE                     # MIT License
```

### Folder Notes

| Folder / File | Purpose |
|---|---|
| `admin/` | Protected area — session-based login required |
| `includes/config.php` | **NOT committed** — holds real DB & Brevo credentials |
| `includes/config.sample.php` | Safe template — copy to `config.php` and fill in your own values |
| `pages/` | Public-facing pages that visitors browse |
| `pages/linkServices/` | Deep-dive pages for each individual service offered |
| `assets/images/brands/` | Trust-bar logos shown in the marquee |
| `assets/images/portfolio/` | Images for the portfolio grid |
| `database/db.sql` | Full SQL dump — import into MySQL to set up the DB |

---

## 🔒 Security Notes

- `includes/config.php` is **not committed** — secrets stay local
- SQL queries use **prepared statements** to prevent injection
- All user output is escaped with `htmlspecialchars()`
- Passwords are hashed with **`password_hash()`** (bcrypt)
- Admin area protected by session-based authentication
- Brevo API and SMTP keys kept out of version control

### What to Verify in `.gitignore`

Make sure your `.gitignore` contains these lines:

```gitignore
# Composer
/vendor/
composer.phar

# Secrets
includes/config.php
.env
.env.local

# Uploads
uploads/
assets/uploads/
```

---

## 🎨 Design Highlights

- Modern two-color alternation (cream + forest green theme)
- Aurora gradient backgrounds with drifting color blobs
- Glass-morphism cards with backdrop blur
- Scroll-triggered reveal animations (left / right / up)
- Smooth hover states using GPU-composited transforms
- Fully accessible — ARIA labels, keyboard navigation,
  reduced-motion support

---

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch:
   ```bash
   git checkout -b feature/new-feature
   ```
3. Commit your changes:
   ```bash
   git commit -m "Add new feature"
   ```
4. Push to the branch:
   ```bash
   git push origin feature/new-feature
   ```
5. Open a Pull Request

---

## 📄 License

This project is licensed under the **MIT License** — see the
[LICENSE](LICENSE) file for details.

---

## 📬 Contact

**BrandEve Solutions**

- 📧 Email: prakashselager@gmail.com
- 📞 Phone: +91 8310133631
- 📍 Location: Bangalore, India

---

Made with ❤️ by the BrandEve Team

