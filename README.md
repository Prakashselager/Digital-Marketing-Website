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

## 📂 Project Structure
brandeve-website/
│
├── admin/ # Admin panel (login-protected)
│ ├── index.php # Dashboard with enquiry statistics
│ ├── admins.php # Manage admin accounts
│ ├── users.php # Manage registered users
│ ├── deleted.php # Restore or permanently delete enquiries
│ ├── settings.php # Email, add admin, change password
│ ├── login.php # Admin login page
│ └── logout.php # Ends the admin session
│
├── includes/
│ ├── config.sample.php # Template config — copy to config.php
│ ├── navbar.php # Shared header / navigation
│ └── footer.php # Shared footer
│
├── pages/
│ ├── home.php # Homepage (main landing)
│ ├── about.php # About the company
│ ├── contact.php # Contact form (saves to DB + sends email)
│ ├── faq.php # Frequently asked questions
│ ├── portfolio.php # Project showcase with lightbox
│ └── linkServices/ # Individual service detail pages
│ ├── branding.php
│ ├── digital-marketing.php
│ ├── events.php
│ ├── exhibition.php
│ ├── launch.php
│ ├── marketing.php
│ ├── promotion.php
│ ├── shows.php
│ └── wedding.php
│
├── assets/
│ ├── css/ # Stylesheets
│ ├── js/ # JavaScript files
│ └── images/
│ ├── brands/ # Client / trust-bar logos
│ ├── portfolio/ # Portfolio project images
│ └── logos.png # Site favicon
│
├── database/
│ └── db.sql # Database schema (tables + default admin)
│
├── .gitignore # Files Git should never track
├── README.md # This file
└── LICENSE # MIT License
