<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('isActive')) {
    function isActive($page) {
        return (basename($_SERVER['PHP_SELF']) == $page) ? 'active' : '';
    }
}
?>

<nav class="navbar">
    <div class="navbar-container">

        <div class="navbar-logo" onclick="openImageModal()">
            <a href="javascript:void(0);">
                <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="BrandEve Solutions Logo">
            </a>
        </div>

        <ul class="navbar-menu">
            <li><a href="<?php echo BASE_URL; ?>pages/home.php" class="<?php echo isActive('home.php'); ?>">HOME</a></li>
            <li><a href="<?php echo BASE_URL; ?>pages/about.php" class="<?php echo isActive('about.php'); ?>">ABOUT</a></li>
            <li><a href="<?php echo BASE_URL; ?>pages/services.php" class="<?php echo isActive('services.php'); ?>">SERVICES</a></li>
            <li><a href="<?php echo BASE_URL; ?>pages/portfolio.php" class="<?php echo isActive('portfolio.php'); ?>">PORTFOLIO</a></li>
            <li><a href="<?php echo BASE_URL; ?>pages/faq.php" class="<?php echo isActive('faq.php'); ?>">FAQ</a></li>
            <li><a href="<?php echo BASE_URL; ?>pages/contact.php" class="<?php echo isActive('contact.php'); ?>">CONTACT</a></li>
        </ul>

        <div class="navbar-login">
    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
        <a href="<?php echo BASE_URL; ?>auth/account.php" class="<?php echo isActive('account.php'); ?>">
            <i class="fas fa-user-circle" style="margin-right: 6px;"></i> Account
        </a>
    <?php else: ?>
        <a href="<?php echo BASE_URL; ?>auth/login.php" class="<?php echo isActive('login.php'); ?>">LOGIN</a>
    <?php endif; ?>
</div>

    </div>
</nav>

<!-- ===== IMAGE MODAL ===== -->
<div id="imageModal" class="image-modal">
    <div class="image-modal-content">
        <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
        <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Logo Large">
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        padding-top: 76px;
    }

   .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 50px;
    background: #0f0f5f;
    border-bottom: 3px solid #38bdf8; /* Solid sky blue border */
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    padding: 0 40px;
}
    .navbar-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar-logo {
        flex: 0 0 150px;
        cursor: pointer;
    }

    .navbar-logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .navbar-logo img {
        max-height: 60px;
        width: auto;
        display: block;
    }

    .navbar-menu {
        list-style: none;
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 0;
        flex: 1;
        justify-content: center;
    }

    .navbar-menu li {
        margin: 0;
        padding: 0;
    }

    .navbar-menu li a {
        display: block;
        padding: 8px 18px;
        text-decoration: none;
        color: #ffffff;
        font-weight: 650;
        font-size: 17px;
        letter-spacing: 0.8px;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 3px solid transparent;
        position: relative;
    }

    .navbar-menu li a:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.06);
        transform: translateY(-1px);
    }

    .navbar-menu li:nth-child(1) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }
    .navbar-menu li:nth-child(2) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }
    .navbar-menu li:nth-child(3) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }
    .navbar-menu li:nth-child(4) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }
    .navbar-menu li:nth-child(5) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }
    .navbar-menu li:nth-child(6) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }
    .navbar-menu li:nth-child(7) a.active {
        color: #38bdf8;
        border-bottom-color: #38bdf8;
        background: rgba(56, 189, 248, 0.08);
    }

    .navbar-login {
        flex: 0 0 120px;
        text-align: right;
    }

    .navbar-login a {
        display: inline-block;
        padding: 8px 14px;
        text-decoration: none;
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.8px;
        border: 2px solid rgba(23, 215, 237, 0.96);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.04);
        transition: all 0.3s ease;
    }

    .navbar-login a:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.10);
        border-color: rgba(206, 19, 223, 0.93);
        transform: translateY(-1px);
    }

    .navbar-login a.active {
        color: #f87171;
        border-color: #f87171;
        background: rgba(248, 113, 113, 0.08);
    }

    /* ===== IMAGE MODAL CSS ===== */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        overflow: auto;
    }

    .image-modal-content {
        position: relative;
        margin: 5% auto;
        padding: 20px;
        width: 90%;
        max-width: 700px;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: zoomIn 0.3s ease;
    }

    .image-modal-content img {
        width: 100%;
        height: auto;
        max-height: 80vh;
        border-radius: 12px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.7);
    }

    .image-modal-close {
        position: absolute;
        top: -10px;
        right: 0;
        font-size: 40px;
        color: #ffffff;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.1);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 300;
        border: 2px solid rgba(255, 255, 255, 0.15);
    }

    .image-modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
        border-color: #ffffff;
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.7);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media screen and (max-width: 1024px) {
        .navbar {
            padding: 0 20px;
        }
        .navbar-logo {
            flex: 0 0 100px;
        }
        .navbar-menu li a {
            padding: 6px 12px;
            font-size: 12px;
        }
        .navbar-logo img {
            max-height: 36px;
        }
        .navbar-login {
            flex: 0 0 90px;
        }
        .navbar-login a {
            padding: 6px 14px;
            font-size: 12px;
        }
    }

    @media screen and (max-width: 768px) {
        .navbar {
            height: auto;
            padding: 12px 16px;
            flex-wrap: wrap;
        }
        .navbar-container {
            flex-wrap: wrap;
            justify-content: center;
        }
        .navbar-logo {
            flex: 0 0 100%;
            text-align: center;
            margin-bottom: 6px;
        }
        .navbar-logo img {
            max-height: 38px;
            display: inline-block;
        }
        .navbar-menu {
            flex: 0 0 100%;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2px;
        }
        .navbar-menu li a {
            padding: 4px 10px;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        .navbar-login {
            flex: 0 0 100%;
            text-align: center;
            margin-top: 6px;
        }
        .navbar-login a {
            padding: 4px 18px;
            font-size: 11px;
        }
        body {
            padding-top: 110px;
        }
    }

    @media screen and (max-width: 480px) {
        .navbar-menu li a {
            font-size: 9px;
            padding: 3px 6px;
        }
        .navbar-login a {
            font-size: 10px;
            padding: 3px 12px;
        }
        body {
            padding-top: 120px;
        }
    }
</style>

<script>
    function openImageModal() {
        document.getElementById('imageModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>