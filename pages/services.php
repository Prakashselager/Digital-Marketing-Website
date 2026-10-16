<?php
include("../includes/config.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - BrandEve Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="../assets/images/favicon.ico">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* REQUIRED FOR SMOOTH ANGLE ANIMATION */
        @property --angle {
            syntax: "<angle>";
            initial-value: 0deg;
            inherits: false;
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/images/bg1.png') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
        }

        .page-title {
            padding: 100px 20px 40px;
            text-align: center;
            background: rgba(0, 0, 0, 0.30);
        }

        .page-title h1 {
            font-size: clamp(36px, 4.5vw, 56px);
            font-weight: 900;
            color: #ffffff;
        }

        .page-title h1 span {
            background: linear-gradient(135deg, #34D399, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-title p {
            max-width: 700px;
            margin: 8px auto 0;
            color: #f68b08;
            font-size: 18px;
            font-weight: 600;
        }

        .services-container {
            padding: 80px 20px 120px;
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 35px;
        }

        .service-card {
            display: flex;
            align-items: center;
            border-radius: 22px;
            min-height: 300px;
            position: relative;
            padding: 3px;
            background: transparent;
        }

        /* MOVING BORDER EFFECT */
        .service-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 24px;
            background: conic-gradient(
                from var(--angle), 
                #1E293B 0deg, 
                #1E293B 270deg, 
                #34D399 300deg, 
                #059669 360deg
            );
            z-index: -1;
            animation: rotateBorder 4s linear infinite;
        }

        @keyframes rotateBorder {
            to { --angle: 360deg; }
        }

        .service-card:hover::before {
            animation-duration: 2s;
        }

        /* MODERN DARK SLATE BACKGROUND */
        .service-card-inner {
            display: flex;
            align-items: center;
            width: 100%;
            background: #1E293B;
            border-radius: 20px;
            overflow: hidden;
            min-height: 260px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* NUMBER SECTION (Always on Left) */
        .service-no {
            flex: 0 0 160px;
            min-height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(52, 211, 153, 0.08);
            border-right: 1px solid rgba(52, 211, 153, 0.2);
        }

        .service-no .list {
            font-size: 64px;
            font-weight: 900;
            color: #34D399;
            line-height: 1;
            letter-spacing: -2px;
            text-shadow: 0 0 20px rgba(52, 211, 153, 0.4);
        }

        .service-content {
            flex: 1;
            padding: 35px 40px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .service-content .icon-wrapper {
            flex: 0 0 80px;
            width: 80px;
            height: 80px;
            border-radius: 18px;
            background: rgba(52, 211, 153, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .service-content .icon-wrapper:hover {
            background: rgba(52, 211, 153, 0.25);
            border-color: rgba(52, 211, 153, 0.5);
            transform: scale(1.08);
            box-shadow: 0 0 30px rgba(52, 211, 153, 0.3);
        }

        .service-content .icon-wrapper i {
            font-size: 36px;
            color: #34D399;
        }

        .service-content .info {
            flex: 1;
        }

        .service-content .info h3 {
            font-size: 24px;
            font-weight: 900;
            color: #34D399;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .service-content .info h3 span {
            color: #34D399;
        }

        .service-content .info p {
            color: #F8FAFC;
            font-size: 16px;
            line-height: 1.8;
            max-width: 600px;
            text-transform: uppercase;
        }

        .service-content .info .enquire-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding: 10px 28px;
            border-radius: 50px;
            background: linear-gradient(135deg, #34D399, #059669);
            color: #FFFFFF;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(52, 211, 153, 0.30);
        }

        .service-content .info .enquire-btn:hover {
            transform: translateX(6px);
            box-shadow: 0 12px 40px rgba(52, 211, 153, 0.50);
        }

        /* RESPONSIVE ADJUSTMENTS */
        @media screen and (max-width: 992px) {
            .service-no {
                flex: 0 0 100px;
                min-height: 220px;
            }
            .service-no .list {
                font-size: 44px;
            }
            .service-content {
                padding: 25px 30px;
                gap: 20px;
                flex-wrap: wrap;
            }
            .service-content .icon-wrapper {
                flex: 0 0 60px;
                width: 60px;
                height: 60px;
            }
            .service-content .icon-wrapper i {
                font-size: 26px;
            }
            .service-content .info h3 {
                font-size: 20px;
            }
            .service-content .info p {
                font-size: 15px;
            }
        }

        @media screen and (max-width: 768px) {
            .page-title {
                padding: 80px 16px 30px;
            }
            .page-title h1 {
                font-size: 28px;
            }
            .service-card {
                min-height: auto;
            }
            /* STACK EVERYTHING ON MOBILE */
            .service-card-inner {
                flex-direction: column;
                min-height: auto;
            }
            .service-no {
                flex: 0 0 auto;
                width: 100%;
                min-height: 80px;
                border-right: none;
                border-bottom: 1px solid rgba(52, 211, 153, 0.2);
                padding: 14px 0;
            }
            .service-no .list {
                font-size: 36px;
            }
            .service-content {
                padding: 25px 20px;
                flex-direction: column;
                text-align: center;
            }
            .service-content .info p {
                max-width: 100%;
            }
            .service-content .info .enquire-btn {
                margin: 12px auto 0;
            }
        }

        @media screen and (max-width: 480px) {
            .services-container {
                padding: 40px 12px 80px;
                gap: 25px;
            }
            .service-content {
                padding: 18px 16px;
            }
            .service-content .info h3 {
                font-size: 18px;
            }
            .service-content .info p {
                font-size: 14px;
            }
            .service-content .info .enquire-btn {
                padding: 8px 20px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <section class="page-title">
        <h1>Our <span>Services</span></h1>
        <p>BRANDEVE SOLUTIONS - United brands with people</p>
    </section>

    <section class="services-container">

        <!-- Service 1 -->
         <div class="service-card">
            <div class="service-card-inner">
                <div class="service-no">
                    <span class="list">1</span>
                </div>
                <div class="service-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="info">
                        <h3><span>Corporate</span> Events</h3>
                        <p>Professional corporate event planning tailored to your business goals.</p>
                        <a href="../pages/linkServices/events.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

<hr>
<hr>

        <div class="service-card">
            <div class="service-card-inner">
                <div class="service-no">
                    <span class="list">2</span>
                </div>
                <div class="service-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="info">
                        <h3><span>Branding</span> & Promotions</h3>
                        <p>Creative and impactful branding solutions to elevate your brand presence.</p>
                        <a href="../pages/linkServices/branding.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
<hr>
<hr>
        <!-- Service 3 -->
        <div class="service-card">
            <div class="service-card-inner">
                <div class="service-no">
                    <span class="list">3</span>
                </div>
                <div class="service-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="info">
                        <h3><span>Marketing</span> & Strategy</h3>
                        <p>Data-driven marketing strategies that drive growth and engagement.</p>
                        <a href="../pages/linkServices/marketing.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <hr>
<hr>
        <!-- Service 4 -->
        <div class="service-card">
            <div class="service-card-inner">
                <div class="service-no">
                    <span class="list">4</span>
                </div>
                <div class="service-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-music"></i>
                    </div>
                    <div class="info">
                        <h3><span>Shows</span> & Concerts</h3>
                        <p>High-energy shows and concerts managed with flawless production quality.</p>
                        <a href="../pages/linkServices/shows.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <hr>
<hr>
        <!-- Service 5 -->
        <div class="service-card">
            <div class="service-card-inner">
                <div class="service-no">
                    <span class="list">5</span>
                </div>
                <div class="service-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="info">
                        <h3><span>Launch</span> & Exhibitions</h3>
                        <p>Spectacular product launches and exhibitions designed to make a huge impact.</p>
                        <a href="../pages/linkServices/launch.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <hr>
<hr>
        <!-- Service 6 -->
        <div class="service-card">
            <div class="service-card-inner">
                <div class="service-no">
                    <span class="list">6</span>
                </div>
                <div class="service-content">
                    <div class="icon-wrapper">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="info">
                        <h3><span>Wedding</span> & Ceremonial</h3>
                        <p>Beautiful and stress-free wedding and ceremonial planning for your big day.</p>
                        <a href="../pages/linkServices/wedding.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== SERVICE 7: Digital Marketing ===== -->
<div class="service-card">
    <div class="service-card-inner">
        <div class="service-no">
            <span class="list">7</span>
        </div>
        <div class="service-content">
            <div class="icon-wrapper">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="info">
                <h3><span>Digital</span> Marketing</h3>
                <p>Social Media, SEO, PPC, content marketing, and more to grow your online presence and drive conversions.</p>
                <a href="linkServices/digital-marketing.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ===== SERVICE 8: BTL & Outdoor Marketing ===== -->
<div class="service-card">
    <div class="service-card-inner">
        <div class="service-no">
            <span class="list">8</span>
        </div>
        <div class="service-content">
            <div class="icon-wrapper">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="info">
                <h3><span>BTL</span> & Outdoor Marketing</h3>
                <p>Activation, branding, outdoor advertising, and street promotions for direct consumer engagement.</p>
                <a href="linkServices/btl-outdoor.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ===== SERVICE 9: Exhibition & Trade Show ===== -->
<div class="service-card">
    <div class="service-card-inner">
        <div class="service-no">
            <span class="list">9</span>
        </div>
        <div class="service-content">
            <div class="icon-wrapper">
                <i class="fas fa-store"></i>
            </div>
            <div class="info">
                <h3><span>Exhibition</span> & Trade Show</h3>
                <p>Stall design, fabrication, management, and visitor engagement for exhibitions and trade shows.</p>
                <a href="linkServices/exhibition.php" class="enquire-btn">Enquire <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

    </section>

</body>
</html>

<?php include("../includes/footer.php"); ?>