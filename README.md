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
- 📞 Contact form with database storage
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
| Fonts | System font stack (Segoe UI, Tahoma, Verdana) |

---
---

## 📦 Dependencies

This project uses **Composer** to manage PHP dependencies (like Brevo SDK,
PHPMailer, etc.).

The `vendor/` folder is **not included** in this repository because:
- It can be several hundred MB
- It's auto-generated from `composer.json`
- It's platform-dependent (different PHP versions may need different builds)

You must install dependencies yourself after cloning — see the next section.

---

## 🚀 Installation

### 1. Clone the repository
```bash
git clone https://github.com/YOUR-USERNAME/brandeve-website.git
cd brandeve-website


---

## 🧠 The Key Idea — Why This Is Needed

Think of `composer.json` as a **shopping list** and `composer install` as the **grocery run**:

| File/Folder | What it is | In repo? |
|---|---|---|
| `composer.json` | List of packages needed | ✅ Yes |
| `composer.lock` | Exact version pins | ✅ Yes |
| `vendor/` | The actual downloaded packages | ❌ No |
| `vendor/autoload.php` | Auto-loader that ties everything together | ❌ No |

When a user clones your repo, they get the **shopping list** but not the **groceries**. They run `composer install` to fill in the `vendor/` folder themselves.

---

## 📋 Make Sure `vendor/` Is in `.gitignore`

Open your `.gitignore` and confirm it contains:

```gitignore
# Composer
/vendor/
composer.phar

## ⚡ Quick Start

```bash
git clone https://github.com/YOUR-USERNAME/brandeve-website.git
cd brandeve-website
composer install               # install PHP dependencies
cp includes/config.sample.php includes/config.php   # create your config
# → edit includes/config.php with your DB credentials
# → import database/db.sql into MySQL
# → open in browser: http://localhost/brandeve-website/

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
