<?php
include("../includes/config.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - BrandEve Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">
    <style>
        /* ================= RESET & BASE ================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent: #38bdf8;
            --accent-2: #22d3ee;
            --accent-deep: #0ea5e9;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.78);
            --text-muted: rgba(255, 255, 255, 0.58);

            --card-bg: rgba(255, 255, 255, 0.06);
            --card-bg-hover: rgba(255, 255, 255, 0.10);
            --card-border: rgba(255, 255, 255, 0.12);
            --card-border-hover: rgba(56, 189, 248, 0.55);

            --glow: 0 0 45px -10px rgba(56, 189, 248, 0.55);
        }

        html {
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-primary);
            background-color: #06102a;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Fixed background via pseudo-element — smoother than background-attachment: fixed */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            background-image:
                url('../assets/images/bg1.png');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            pointer-events: none;
        }

        ::selection {
            background: var(--accent);
            color: #06102a;
        }

        /* ================= HERO / HEADING SECTION ================= */
        .portfolio-hero {
            padding: 60px 24px 20px;
            max-width: 1280px;
            margin: 0 auto;
        }

        .hero-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            flex-wrap: wrap;
        }

        .hero-left {
            flex: 1 1 380px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 20px;
        }

        .hero-eyebrow .line {
            display: inline-block;
            width: 48px;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            border-radius: 2px;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.7);
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin-bottom: 18px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #7dd3fc 0%, #38bdf8 50%, #22d3ee 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .hero-subtitle {
            font-size: clamp(0.92rem, 1.5vw, 1.02rem);
            line-height: 1.75;
            color: var(--text-secondary);
            max-width: 520px;
            text-align: justify;
        }

        /* --- stats --- */
        .hero-stats {
            display: flex;
            gap: 36px;
            flex-wrap: wrap;
            padding-top: 12px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: rgba(56, 189, 248, 0.14);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: var(--accent);
            font-size: 1.15rem;
            flex-shrink: 0;
            transition: transform 0.35s ease, box-shadow 0.35s ease;
        }

        .stat-item:hover .stat-icon {
            transform: translateY(-4px) scale(1.06);
            box-shadow: 0 0 26px -4px rgba(56, 189, 248, 0.75);
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-info strong {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .stat-info span {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.02em;
        }

        /* ================= PORTFOLIO GRID ================= */
        .portfolio-grid {
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px 24px 110px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 28px;
        }

        /* ================= CARD ================= */
        .portfolio-card {
            position: relative;
            display: flex;
            flex-direction: column;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 18px;
            overflow: hidden;
            cursor: zoom-in;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 10px 30px -18px rgba(0, 0, 0, 0.8);
            /* Simple, snappy transition for hover only */
            transition:
                transform 0.35s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.35s ease,
                border-color 0.35s ease,
                background 0.35s ease;
            /* Smooth rendering during transform */
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        .portfolio-card:hover {
            transform: translateY(-8px);
            background: var(--card-bg-hover);
            border-color: var(--card-border-hover);
            box-shadow:
                0 28px 55px -20px rgba(0, 0, 0, 0.85),
                0 0 0 1px rgba(56, 189, 248, 0.18),
                var(--glow);
        }

        .portfolio-card:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 3px;
        }

        /* --- image --- */
        .portfolio-image {
            position: relative;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            background: #0a142e;
        }

        .portfolio-image img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            transform: translateZ(0);
        }

        .portfolio-card:hover .portfolio-image img {
            transform: scale(1.08);
        }

        /* bottom fade */
        .portfolio-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(6, 15, 40, 0) 45%, rgba(6, 15, 40, 0.60) 100%);
            pointer-events: none;
        }

        /* magnifier icon on hover */
        .portfolio-image::before {
            content: '\f00e';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 54px;
            height: 54px;
            display: grid;
            place-items: center;
            font-size: 1.05rem;
            color: #ffffff;
            border-radius: 50%;
            background: rgba(56, 189, 248, 0.25);
            border: 1px solid rgba(56, 189, 248, 0.55);
            box-shadow: 0 0 30px -4px rgba(56, 189, 248, 0.85);
            transform: translate(-50%, -50%) scale(0.6);
            opacity: 0;
            z-index: 2;
            transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .portfolio-card:hover .portfolio-image::before {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* --- body --- */
        .portfolio-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px 22px 24px;
        }

        .tag {
            display: inline-block;
            padding: 5px 13px;
            margin-bottom: 12px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: #7dd3fc;
            background: rgba(56, 189, 248, 0.13);
            border: 1px solid rgba(56, 189, 248, 0.32);
            border-radius: 999px;
            transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .portfolio-card:hover .tag {
            background: var(--accent);
            color: #06102a;
            border-color: var(--accent);
        }

        .portfolio-body h3 {
            font-size: 1.08rem;
            font-weight: 650;
            line-height: 1.35;
            letter-spacing: -0.01em;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .portfolio-body p {
            font-size: 0.88rem;
            line-height: 1.65;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .portfolio-card:hover .portfolio-body p {
            color: var(--text-secondary);
        }

        /* ================= SCROLL REVEAL — using animation, not transition ================= */
        /* Before reveal: hidden state (set by JS) */
        .portfolio-card.pre-reveal {
            opacity: 0;
        }

        /* Reveal animations — removed after they complete (via JS), so hover
           always uses the card's clean base transition and no "shape morph" happens */
        .portfolio-card.animate-left {
            animation: slideInLeft 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .portfolio-card.animate-right {
            animation: slideInRight 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-60px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(60px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ================= LIGHTBOX ================= */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            padding: 70px 20px 30px;
            overflow: auto;
            background: rgba(4, 10, 28, 0.92);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: fadeIn 0.25s ease;
        }

        .lightbox-content {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 110px);
            max-width: 1100px;
            margin: 0 auto;
        }

        #lightboxImage {
            max-width: 100%;
            max-height: calc(100vh - 130px);
            object-fit: contain;
            border-radius: 16px;
            border: 1px solid rgba(56, 189, 248, 0.25);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.75), 0 0 60px -20px rgba(56, 189, 248, 0.6);
            animation: zoomIn 0.32s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .lightbox-close {
            position: fixed;
            top: 22px;
            right: 26px;
            z-index: 10000;
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            font-size: 1.85rem;
            line-height: 1;
            color: #ffffff;
            cursor: pointer;
            user-select: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.20);
            transition: background 0.28s ease, transform 0.28s ease, border-color 0.28s ease;
        }

        .lightbox-close:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #06102a;
            transform: rotate(90deg);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.94); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 900px) {
            .portfolio-hero { padding: 40px 20px 10px; }
            .hero-container { gap: 30px; }
            .hero-stats { gap: 24px; }
            .portfolio-grid { gap: 22px; padding-bottom: 90px; }
        }

        @media (max-width: 640px) {
            .portfolio-hero { padding: 30px 18px 10px; }
            .hero-stats { gap: 18px; width: 100%; }
            .stat-item { flex: 0 0 auto; }
            .stat-icon { width: 44px; height: 44px; font-size: 1rem; }
            .stat-info strong { font-size: 1.15rem; }
            .portfolio-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 18px;
                padding: 24px 16px 70px;
            }
            .portfolio-body { padding: 16px 16px 20px; }
            .portfolio-body h3 { font-size: 1rem; }
            .portfolio-body p { font-size: 0.84rem; }
            .lightbox { padding: 70px 14px 24px; }
            .lightbox-close { top: 16px; right: 16px; width: 42px; height: 42px; }

            /* Reduce slide distance on smaller screens */
            @keyframes slideInLeft {
                from { opacity: 0; transform: translateX(-30px); }
                to   { opacity: 1; transform: translateX(0); }
            }
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(30px); }
                to   { opacity: 1; transform: translateX(0); }
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
            .portfolio-card.pre-reveal { opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- ===================== HERO / HEADING SECTION ===================== -->
    <section class="portfolio-hero">
        <div class="hero-container">
            <div class="hero-left">
                <span class="hero-eyebrow">
                    OUR PORTFOLIO <span class="line"></span>
                </span>
                <h1 class="hero-title">
                    Explore Our <span>Creative Work</span>
                </h1>
                <p class="hero-subtitle">
                    We pride in delivering results-driven digital solutions.
                    Here are some of our recent projects that showcase our creativity,
                    strategy and technical expertise.
                </p>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-rocket"></i></div>
                    <div class="stat-info">
                        <strong>50+</strong>
                        <span>Projects Completed</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                    <div class="stat-info">
                        <strong>50+</strong>
                        <span>Happy Clients</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
                    <div class="stat-info">
                        <strong>100%</strong>
                        <span>Client Satisfaction</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== PORTFOLIO GRID ===================== -->
    <section class="portfolio-grid" id="portfolioGrid">

        <!-- ===== CARD 1 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/myglamm.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/myglamm.jpg" alt="MyGlamm RWA Activation" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>MyGlamm - RWA Activation</h3>
                <p>Successful residential welfare association activation for the beauty brand.</p>
            </div>
        </div>

        <!-- ===== CARD 2 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/nature.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/nature.jpg" alt="Nature's Basket RWA Activation" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>Nature's Basket - RWA Activation</h3>
                <p>Engaging community activation for the premium grocery brand.</p>
            </div>
        </div>

        <!-- ===== CARD 3 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/easy-tazaa.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/easy-tazaa.jpg" alt="Easy Tazaa RWA Activation" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>Easy Tazaa - RWA Activation</h3>
                <p>Community activation for the online grocery delivery brand.</p>
            </div>
        </div>

        <!-- ===== CARD 4 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/mfine.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/mfine.jpg" alt="Mfine RWA Activation" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>Mfine - RWA Activation</h3>
                <p>Healthcare brand activation across residential communities.</p>
            </div>
        </div>

        <!-- ===== CARD 5 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/health.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/health.jpg" alt="Orange Health RWA Activity" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Health Activation</span>
                <h3>Orange Health - RWA Activity</h3>
                <p>Health awareness and brand activation campaign.</p>
            </div>
        </div>

        <!-- ===== CARD 6 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/zepto.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/zepto.jpg" alt="Zepto RWA Activity" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>Zepto - RWA Activity</h3>
                <p>Quick commerce brand activation across residential communities.</p>
            </div>
        </div>

        <!-- ===== CARD 7 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/sugar.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/sugar.jpg" alt="Sugar Store Launch" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Store Launch</span>
                <h3>Sugar - Store Launch</h3>
                <p>Successful store launch event for the beauty brand.</p>
            </div>
        </div>

        <!-- ===== CARD 8 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/simon.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/simon.jpg" alt="Simon Carter D2D" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Door-to-Door</span>
                <h3>Simon Carter - D2D Bangalore</h3>
                <p>Door-to-door brand activation campaign in Bangalore.</p>
            </div>
        </div>

        <!-- ===== CARD 9 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/d2d.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/d2d.jpg" alt="D2D Campaign" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Door-to-Door</span>
                <h3>Vanheusen - D2D Bangalore</h3>
                <p>Door-to-door brand activation for the premium apparel brand.</p>
            </div>
        </div>

        <!-- ===== CARD 10 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/rapido.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/rapido.jpg" alt="Rapido Auto Look Walker" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>Rapido Auto - Look Walker Activity</h3>
                <p>Innovative brand activation using look walkers.</p>
            </div>
        </div>

        <!-- ===== CARD 11 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/zomato.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/zomato.jpg" alt="Zomato Lollipop Board" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Installation</span>
                <h3>Zomato - Lollipop Board Installation</h3>
                <p>Creative outdoor brand installation for the food delivery giant.</p>
            </div>
        </div>

        <!-- ===== CARD 12 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/crismas.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/crismas.jpg" alt="Nature's Basket Christmas" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Event Activation</span>
                <h3>Nature's Basket Christmas - RWA Activation</h3>
                <p>Festive community activation with a Christmas theme.</p>
            </div>
        </div>

        <!-- ===== CARD 13 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/sumadhura.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/sumadhura.jpg" alt="Sumadhura Properties" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">RWA Activity</span>
                <h3>Sumadhura Properties - RWA Activity</h3>
                <p>Residential welfare association activity for the real estate brand.</p>
            </div>
        </div>

        <!-- ===== CARD 14 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/brandexpo.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/brandexpo.jpg" alt="Brand Expo ITPL" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Tech Park Activation</span>
                <h3>Brand Expo ITPL - Tech Park Activation</h3>
                <p>Brand activation at ITPL tech park.</p>
            </div>
        </div>

        <!-- ===== CARD 15 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/tact.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/tact.jpg" alt="Collabera TACT" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Tech Park Activation</span>
                <h3>Collabera TACT - Tech Park Activation</h3>
                <p>Tech park activation for the IT company.</p>
            </div>
        </div>

        <!-- ===== CARD 16 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/edureka.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/edureka.jpg" alt="Edureka" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Tech Park Activation</span>
                <h3>Edureka - Tech Park Activation</h3>
                <p>Tech park activation for the online education platform.</p>
            </div>
        </div>

        <!-- ===== CARD 17 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/iconhomz.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/iconhomz.jpg" alt="Icon Homz" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Tech Park Activation</span>
                <h3>Icon Homz - Tech Park Activation</h3>
                <p>Tech park activation for the real estate brand.</p>
            </div>
        </div>

        <!-- ===== CARD 18 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/jupitar.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/jupitar.jpg" alt="Jupiter" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Tech Park Activation</span>
                <h3>Jupiter - Tech Park Activation</h3>
                <p>Tech park activation for the fintech brand.</p>
            </div>
        </div>

        <!-- ===== CARD 19 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/nex.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/nex.jpg" alt="Nexa Kalyani Motors" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Tech Park Activation</span>
                <h3>Nexa Kalyani Motors - Tech Park Activation</h3>
                <p>Tech park activation for the automobile brand.</p>
            </div>
        </div>

        <!-- ===== CARD 20 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/toyoto.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/toyoto.jpg" alt="Toyota Car Branding" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Car Branding</span>
                <h3>Toyota - Car Branding - Tech Park Activation</h3>
                <p>Car branding activation at a tech park.</p>
            </div>
        </div>

        <!-- ===== CARD 21 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/idp.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/idp.jpg" alt="IDP Mall" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Mall Activation</span>
                <h3>IDP - Mall Activation</h3>
                <p>Brand activation at a shopping mall.</p>
            </div>
        </div>

        <!-- ===== CARD 22 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/curaden.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/curaden.jpg" alt="Curaden" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Brand Activation</span>
                <h3>Curaden - Brand Activation</h3>
                <p>Brand activation for the oral care brand.</p>
            </div>
        </div>

        <!-- ===== CARD 23 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/kaya.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/kaya.jpg" alt="Kaya Skincare" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Promotion</span>
                <h3>Kaya Skincare - Brand Promotion at College</h3>
                <p>Brand promotion campaign at a college campus.</p>
            </div>
        </div>

        <!-- ===== CARD 24 ===== -->
        <div class="portfolio-card" data-image="<?php echo BASE_URL; ?>assets/images/portfolio/book.jpg">
            <div class="portfolio-image">
                <img src="<?php echo BASE_URL; ?>assets/images/portfolio/book.jpg" alt="Book Launch" loading="lazy">
            </div>
            <div class="portfolio-body">
                <span class="tag">Event</span>
                <h3>Book Launch</h3>
                <p>Successful book launch event with media coverage.</p>
            </div>
        </div>

    </section>

    <!-- ===== LIGHTBOX MODAL ===== -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox(event)">
        <div class="lightbox-content">
            <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
            <img id="lightboxImage" src="" alt="Enlarged Portfolio Image">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ============ LIGHTBOX ============ */
            const cards = document.querySelectorAll('.portfolio-card');
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightboxImage');

            cards.forEach(card => {
                card.addEventListener('click', function () {
                    const imageSrc = this.getAttribute('data-image');
                    if (imageSrc) {
                        lightboxImage.src = imageSrc;
                        lightbox.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    }
                });
            });

            /* ============ SCROLL REVEAL ============ */
            if ('IntersectionObserver' in window) {

                // 1) Hide all cards first (progressive enhancement — only if JS runs)
                cards.forEach(card => card.classList.add('pre-reveal'));

                // 2) Observe and animate when a card enters the viewport
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;

                        const el = entry.target;
                        const index = Array.from(cards).indexOf(el);
                        const direction = index % 2 === 0 ? 'animate-left' : 'animate-right';
                        const delay = (index % 3) * 70;

                        setTimeout(function () {
                            el.classList.remove('pre-reveal');
                            el.classList.add(direction);

                            // IMPORTANT: remove the animation class once it finishes,
                            // so the card returns to its clean base transition and
                            // hovering never causes a slow "shape morph" effect.
                            el.addEventListener('animationend', function () {
                                el.classList.remove('animate-left', 'animate-right');
                            }, { once: true });

                        }, delay);

                        observer.unobserve(el);
                    });
                }, {
                    threshold: 0.10,
                    rootMargin: '0px 0px -30px 0px'
                });

                cards.forEach(card => observer.observe(card));
            }
        });

        function closeLightbox(event) {
            const lightbox = document.getElementById('lightbox');
            if (event && event.target !== event.currentTarget) return;
            lightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('lightboxImage').src = '';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const lightbox = document.getElementById('lightbox');
                if (lightbox.style.display === 'block') {
                    closeLightbox();
                }
            }
        });
    </script>

</body>
</html>

<?php include("../includes/footer.php"); ?>