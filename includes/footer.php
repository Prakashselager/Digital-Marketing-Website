<?php

if (!function_exists('isActive')) {
    function isActive($page) {
        return (basename($_SERVER['PHP_SELF']) == $page) ? 'active' : '';
    }
}
?>

<footer class="footer">
    <div class="footer-container">

        <div class="footer-brand">
            <h2>BRANDEVE <span>SOLUTIONS</span></h2>
            <p>Data-driven marketing, creative branding, and high-performance websites designed to turn visitors into loyal customers.</p>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h4>QUICK LINKS</h4>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>pages/home.php" class="<?php echo isActive('home.php'); ?>">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/about.php" class="<?php echo isActive('about.php'); ?>">About</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/services.php" class="<?php echo isActive('services.php'); ?>">Services</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/portfolio.php" class="<?php echo isActive('portfolio.php'); ?>">Portfolio</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/faq.php" class="<?php echo isActive('faq.php'); ?>">FAQ</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/contact.php" class="<?php echo isActive('contact.php'); ?>">Contact</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>SERVICES</h4>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/events.php">Corporate Events</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/branding.php">Branding & Promotions</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/marketing.php">Marketing & Strategy</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/launch.php">Launch & Exhibitions</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/shows.php">Shows & Concerts</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/wedding.php">Wedding & Ceremonial</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/digital-marketing.php">Digital Marketing</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/btl-outdoor.php">BTL & Outdoor Marketing</a></li>
                <li><a href="<?php echo BASE_URL; ?>pages/linkServices/exhibition.php">Exhibition & Trade Show</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>CONTACT</h4>
            <div class="footer-contact">
                <p><i class="fas fa-map-marker-alt"></i> Kumbalgodu, Karnataka 560074</p>
                <p><i class="fas fa-envelope"></i> your_email@example.com</p>
                <p><i class="fas fa-phone"></i> +91 00000000000</p>
                <p><i class="fas fa-clock"></i> 24/7 Support</p>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 Your Marketing Agency. All rights reserved.</p>
    </div>
</footer>

<style>
    .footer {
        width: 100%;
        background: rgba(17, 17, 73, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 50px 40px 20px;
        border-top: 4px solid #38bdf8;
        box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.4);
        margin-top: 50px;
    }

    .footer-container {
        max-width: 1350px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2.2fr 1fr 1fr 1.2fr;
        gap: 40px;
    }

    .footer-brand h2 {
        font-size: 34px;
        font-weight: 800;
        color: #ef5908;
        margin-bottom: 14px;
        letter-spacing: -0.5px;
    }

    .footer-brand h2 span {
        background: linear-gradient(135deg, #ed4b05, #e54004);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .footer-brand p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 17px;
        line-height: 1.8;
        text-align: justify;
        max-width: 340px;
        margin-bottom: 18px;
    }

    .footer-social {
        display: flex;
        gap: 12px;
    }

    .footer-social a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.5);
        font-size: 16px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .footer-social a:hover {
        color: #ffffff;
        background: #38bdf8;
        border-color: #38bdf8;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(56, 189, 248, 0.35);
    }

    .footer-col h4 {
        color: #ffffff;
        font-size: 20px;
        font-weight: 700;
        font-family: Georgia, 'Times New Roman', Times, serif;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        border-bottom: 4px solid #38bdf8;
        padding-bottom: 8px;
        display: inline-block;
    }

    .footer-col ul {
        list-style: none;
    }

    .footer-col ul li {
        margin-bottom: 10px;
    }

    .footer-col ul li a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 18px;
        transition: all 0.3s ease;
        display: inline-block;
        font-weight: 600;
    }

    .footer-col ul li a:hover {
        color: #38bdf8;
        transform: translateX(4px);
    }

    .footer-col ul li a.active {
        color: #38bdf8;
        font-weight: 700;
    }

    .footer-contact {
        color: rgba(255, 255, 255, 0.5);
        font-size: 16px;
        line-height: 2.2;
        font-weight: 600;
    }

    .footer-contact i {
        color: #38bdf8;
        width: 26px;
        margin-right: 6px;
        font-size: 16px;
    }

    .footer-bottom {
        max-width: 1200px;
        margin: 30px auto 0;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .footer-bottom p {
        color: rgba(255, 255, 255, 0.3);
        font-size: 14px;
        font-weight: 600;
    }

    .footer-bottom-links {
        display: flex;
        gap: 20px;
    }

    .footer-bottom-links a {
        color: rgba(255, 255, 255, 0.3);
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .footer-bottom-links a:hover {
        color: #38bdf8;
    }

    @media screen and (max-width: 992px) {
        .footer {
            padding: 40px 20px 16px;
        }
        .footer-container {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        .footer-brand p {
            max-width: 100%;
        }
    }

    @media screen and (max-width: 600px) {
        .footer {
            padding: 30px 16px 12px;
            border-top-width: 3px;
        }
        .footer-container {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        .footer-brand h2 {
            font-size: 28px;
        }
        .footer-brand p {
            font-size: 15px;
        }
        .footer-col h4 {
            font-size: 17px;
        }
        .footer-col ul li a {
            font-size: 14px;
        }
        .footer-contact {
            font-size: 14px;
        }
        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }
        .footer-bottom-links {
            justify-content: center;
            flex-wrap: wrap;
        }
        .footer-bottom p,
        .footer-bottom-links a {
            font-size: 12px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">