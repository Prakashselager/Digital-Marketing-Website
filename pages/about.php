<?php
include("../includes/config.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - BrandEve Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">

    <style>
        /* ================================================================
                   RESET & BASE
                   ================================================================ */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/images/about.png') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ================================================================
                   SECTION 1: HERO / ABOUT HEADER
                   ================================================================ */
        .about-hero {
            min-height: 70vh;
            display: flex;
            align-items: center;
            padding: 70px 20px 60px;
            position: relative;
        }

        .about-hero-container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-hero-left .label {
            display: inline-block;
            color: #e1e6ec;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-weight: bold;
            font-size: 60px;
            font-weight: 1200;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 12px;
            margin-left: 0;
            border-left: 3px solid #38BDF8;
            padding-left: 16px;
        }

        .about-hero-left h1 {
            font-size: clamp(42px, 5.5vw, 72px);
            font-weight: 1000;
            color: #FF6B00;
            line-height: 1.08;
            margin-bottom: 16px;
            margin-left: 20px;
            text-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
            white-space: nowrap;
        }

        .about-hero-left h1 span {
            background: linear-gradient(135deg, #FF6B00, #FF6B00, #FF6B00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-hero-left p {
            font-size: 20px;
            text-align: justify;
            color: #ffffff;
            line-height: 1.8;
            max-width: 540px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }

        .about-hero-left .tagline {
            margin-top: 24px;
            font-size: 16px;
            color: #93C5FD;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .about-hero-left .tagline i {
            color: #38BDF8;
            margin-right: 8px;
        }

        .about-hero-right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .about-hero-right .image-placeholder {
            width: 100%;
            max-width: 500px;
            height: 500px;
            border-radius: 20px;
           
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: rgba(255, 255, 255, 0.25);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .about-hero-right .image-placeholder:hover {
            border-color: rgba(56, 189, 248, 0.25);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .about-hero-right .image-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .about-hero-right .image-placeholder .icon-placeholder {
            font-size: 48px;
            color: rgba(56, 189, 248, 0.15);
            margin-bottom: 8px;
        }

        /* ================================================================
                   SECTION 2: STATS
                   ================================================================ */
        .about-stats {
            padding: 60px 20px;
            background: rgba(10, 10, 30, 0.60);
            backdrop-filter: blur(6px);
            border-top: 1px solid rgba(56, 189, 248, 0.06);
            border-bottom: 1px solid rgba(56, 189, 248, 0.06);
        }

        .stats-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .stat-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 16px;
            background: skyblue;
            border: 1px solid rgba(255, 255, 255, 0.04);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: white;
            border-color: rgba(56, 189, 248, 0.10);
            transform: translateY(-4px);
        }

        .stat-card .number {
            font-size: 43px;
            font-weight: 900;
            background: linear-gradient(135deg, #040699, #14048d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            line-height: 1.2;
        }

        .stat-card .label {
            color: #14036c;
            font-size: 15px;
            font-weight: 500;
            margin-top: 6px;
        }

        /* ================================================================
                   SECTION 3: "WE THINK DIFFERENT" CONTENT
                   ================================================================ */
        .about-mission {
            padding: 80px 20px;
            background: rgba(157, 143, 214, 0.5);
            backdrop-filter: blur(4px);
        }

        .mission-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .mission-image {
            border-radius: 20px;
            overflow: hidden;
            min-height: 350px;
            background: linear-gradient(135deg, #0B1A3A, #0D0D1A);
            border: 1px solid rgba(56, 189, 248, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.4s ease;
        }

        .mission-image:hover {
            border-color: rgba(56, 189, 248, 0.15);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .mission-image img {
            width: 100%;
            height: 100%;
            min-height: 350px;
            object-fit: cover;
        }

        .mission-content .label {
            display: inline-block;
            color: #3908cb;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 12px;
            border-left: 3px solid #38BDF8;
            padding-left: 16px;
        }

        .mission-content h2 {
            font-size: clamp(30px, 3.5vw, 44px);
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .mission-content h2 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mission-content p {
            color: #090a0bf9;
            font-size: 20px;
            line-height: 1.9;
            margin-bottom: 16px;
        }

        .mission-content .highlight {
            color: yellow;
            font-weight: 600;
            font-size: 18px;
            padding: 16px 20px;
            border-left: 3px solid #38BDF8;
            background: rgba(56, 189, 248, 0.04);
            border-radius: 0 8px 8px 0;
            margin-top: 8px;
        }

        .mission-content .highlight i {
            color: #38BDF8;
            margin-right: 8px;
        }

        /* ================================================================
                   SECTION 4: VALUES / WHY US
                   ================================================================ */
        .about-values {
            padding: 80px 20px;
            background: rgba(10, 10, 30, 0.40);
            backdrop-filter: blur(4px);
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section-header .subtitle {
            display: block;
            color: #93C5FD;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 6px;
        }

        .section-header h2 {
            font-size: clamp(32px, 4vw, 46px);
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
            position: relative;
            display: inline-block;
            padding-bottom: 6px;
        }

        .section-header h2 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #38BDF8, #60A5FA);
            border-radius: 2px;
            transition: width 0.4s ease;
        }

        .section-header h2:hover::after {
            width: 80px;
        }

        .section-header p {
            color: #d1d5db;
            font-size: 17px;
            margin-top: 16px;
        }

        .values-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .value-card {
            text-align: center;
            padding: 35px 25px;
            border-radius: 18px;
            background: skyblue;
            border: 1px solid rgba(255, 255, 255, 0.04);
            transition: all 0.3s ease;
        }

        .value-card:hover {
            background: white;
            border-color: rgba(56, 189, 248, 0.10);
            transform: translateY(-6px);
        }

        .value-card .icon {
            font-size: 38px;
            color: #2e025e;
            margin-bottom: 14px;
            display: block;
        }

        .value-card h4 {
            color: #19025f;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .value-card p {
            color: #120260;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ================================================================
                   BRANDS SHOW SECTION
                   ================================================================ */
        .brands-show {
            width: 100%;
            padding: 80px 7%;
            text-align: center;
        }

        .main-head {
            margin-bottom: 45px;
            color: #ffffff;
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .company-logos {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .company-logos img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            padding: 18px 25px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 16px;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .company-logos img:hover {
            transform: translateY(-7px);
            border-color: #ffe66d;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        /* ================================================================
                   RESPONSIVE
                   ================================================================ */
        @media screen and (max-width: 1024px) {
            .about-hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .about-hero-left p {
                max-width: 100%;
            }
            .about-hero-left .label {
                border-left: none;
                border-bottom: 3px solid #38BDF8;
                padding-left: 0;
                padding-bottom: 6px;
            }
            .about-hero-right .image-placeholder {
                max-width: 100%;
                height: 250px;
            }
            .mission-container {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .mission-content .label {
                border-left: none;
                border-bottom: 3px solid #38BDF8;
                padding-left: 0;
                padding-bottom: 6px;
            }
            .mission-content .highlight {
                border-left: none;
                border-top: 3px solid #38BDF8;
                padding: 16px 20px;
                border-radius: 8px;
            }
            .values-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .company-logos {
                grid-template-columns: repeat(3, 1fr);
                gap: 25px;
            }
        }

        @media screen and (max-width: 900px) {
            .company-logos {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media screen and (max-width: 768px) {
            .about-hero {
                min-height: auto;
                padding: 80px 16px 40px;
            }
            .about-hero-left h1 {
                font-size: 32px;
            }
            .about-hero-left p {
                font-size: 16px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .values-grid {
                grid-template-columns: 1fr;
            }
            .brands-show {
                padding: 60px 16px;
            }
            .company-logos {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .company-logos img {
                height: 100px;
            }
        }

        @media screen and (max-width: 500px) {
            .brands-show {
                padding: 60px 5%;
            }
            .main-head {
                font-size: 30px;
            }
            .company-logos {
                grid-template-columns: 1fr;
            }
            .company-logos img {
                height: 100px;
            }
        }

        @media screen and (max-width: 480px) {
            .about-hero-left h1 {
                font-size: 26px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .stat-card .number {
                font-size: 32px;
            }
            .mission-image {
                min-height: 200px;
            }
            .mission-image img {
                min-height: 200px;
            }
            .brands-show {
                padding: 40px 12px;
            }
            .company-logos {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            .company-logos img {
                max-width: 100px;
                height: 80px;
            }
        }
    </style>
</head>

<body>

    <!-- ================================================================ -->
    <!-- SECTION 1: HERO / ABOUT HEADER                                  -->
    <!-- ================================================================ -->
    <section class="about-hero">
        <div class="about-hero-container">

            <div class="about-hero-left">
                <span class="label">About Us</span>
                <h1><span>BrandEve</span> Solutions</h1>
                <p>United brands with people through simple, insightful, and creative events. We deliver seamless corporate events, marketing, BTL activations, promotions, conferences, exhibitions, concerts, and integrated digital marketing services.</p>
                <div class="tagline">
                    <i class="fas fa-quote-left"></i> BrandEve Solutions – United brands with people
                </div>
            </div>

            <div class="about-hero-right">
                <div class="image-placeholder">
                    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="About BrandEve">
                </div>
            </div>

        </div>
    </section>

    <!-- ================================================================ -->
    <!-- SECTION 2: STATS                                                -->
    <!-- ================================================================ -->
    <section class="about-stats">
        <div class="stats-grid">
            <div class="stat-card">
                <span class="number">120+</span>
                <span class="label">Events Delivered</span>
            </div>
            <div class="stat-card">
                <span class="number">20+</span>
                <span class="label">Clients Served</span>
            </div>
            <div class="stat-card">
                <span class="number">22+</span>
                <span class="label">Years of Experience</span>
            </div>
            <div class="stat-card">
                <span class="number">70+</span>
                <span class="label">Team Members</span>
            </div>
        </div>
    </section>

    <!-- ================================================================ -->
    <!-- SECTION 3: "WE THINK DIFFERENT" CONTENT                         -->
    <!-- ================================================================ -->
    <section class="about-mission">
        <div class="mission-container">

            <div class="mission-image">
                <img src="<?php echo BASE_URL; ?>assets/images/about1.jpg" alt="We Think Different">
            </div>

            <div class="mission-content">
                <span class="label">We Think Different</span>
                <h2>We Think <span>Different...</span></h2>
                <p>
                    At BrandEve Solutions, we believe that true brand success comes from thinking beyond
                    conventional marketing approaches. We don't just follow trends – we create them. Every
                    event, campaign, and strategy we design is built on a foundation of creativity, insight,
                    and a deep understanding of what truly connects brands with people.
                </p>
                <p>
                    We challenge the ordinary. Whether it's a corporate event, a brand activation, or a
                    digital marketing campaign, we approach every project with fresh eyes and a relentless
                    drive to deliver exceptional results. Our team combines strategic thinking with creative
                    execution to create experiences that are not only memorable but also drive real business
                    growth for our clients.
                </p>
               
                <div class="highlight">
                    <i class="fas fa-quote-left"></i> We believe that every brand has a unique story to tell,
                    and we're here to help you tell it in the most impactful way possible.
                </div>
            </div>

        </div>
    </section>

    <!-- ================================================================ -->
    <!-- SECTION 4: OUR VALUES                                           -->
    <!-- ================================================================ -->
    <section class="about-values">
        <div class="section-header">
            <span class="subtitle">Our Core Values</span>
            <h2>What <span>Drives Us</span></h2>
            <p>The principles that guide everything we do</p>
        </div>

        <div class="values-grid">

            <div class="value-card">
                <span class="icon"><i class="fas fa-lightbulb"></i></span>
                <h4>Creativity</h4>
                <p>We bring fresh, innovative ideas to every project, ensuring memorable and impactful experiences.</p>
            </div>

            <div class="value-card">
                <span class="icon"><i class="fas fa-handshake"></i></span>
                <h4>Integrity</h4>
                <p>We operate with honesty, transparency, and a commitment to delivering on our promises.</p>
            </div>

            <div class="value-card">
                <span class="icon"><i class="fas fa-users"></i></span>
                <h4>Collaboration</h4>
                <p>We work closely with our clients, partners, and team to achieve shared goals and success.</p>
            </div>

        </div>
    </section>

    <!-- ================================================================ -->
    <!-- SECTION 5: BRANDS SHOW                                          -->
    <!-- ================================================================ -->
    <section class="brands-show">
        <h1 class="main-head">Trusted by leading Companies</h1>

        <div class="company-logos">
            <img src="<?php echo BASE_URL; ?>assets/images/about/eduraka.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/jupiter.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/kaya.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/myglamma.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/nature.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/rapido.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/sugar.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/tact.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/zepto.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/zomato.jpg" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/orenge" alt="logo">
            <img src="<?php echo BASE_URL; ?>assets/images/about/toyota.jpg" alt="logo">
        </div>
    </section>

</body>
</html>

<?php include("../includes/footer.php"); ?>