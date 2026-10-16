<?php
include("../includes/config.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - BrandEve Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e0e7ff;
            min-height: 100vh;
            color: #1e1b4b;
            overflow-x: hidden;
            line-height: 1.6;
        }

        .faq-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background: linear-gradient(135deg, #356f8f 0%, #356f8f 35%, #356f8f 70%, #356f8f 100%);
        }

        .faq-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 15%, rgba(56,189,248,0.35), transparent 45%),
                radial-gradient(circle at 85% 25%, rgba(139,92,246,0.3), transparent 45%),
                radial-gradient(circle at 50% 90%, rgba(99,102,241,0.25), transparent 50%);
        }

        .faq-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 30px,
                    rgba(255,255,255,0.35) 30px,
                    rgba(255,255,255,0.35) 31px
                ),
                repeating-linear-gradient(
                    -45deg,
                    transparent,
                    transparent 30px,
                    rgba(255,255,255,0.2) 30px,
                    rgba(255,255,255,0.2) 31px
                );
            mask-image: radial-gradient(ellipse at center, #000 40%, transparent 85%);
            -webkit-mask-image: radial-gradient(ellipse at center, #000 40%, transparent 85%);
        }

        .page-header {
            padding: 50px 20px 40px;
            text-align: center;
            position: relative;
        }

        .page-header .ph-tag {
            display: inline-block;
            padding: 8px 24px;
            border-radius: 50px;
            background: #ffffff;
            border: 2px solid rgba(251,146,60,0.4);
            color: #4206f7;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 24px;
            box-shadow: 0 8px 25px rgba(251,146,60,0.25);
            animation: fadeDown 0.8s ease;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-header h1 {
            font-size: clamp(38px, 5.5vw, 74px);
            font-weight: 900;
            letter-spacing: -2.5px;
            line-height: 1.05;
            margin-bottom: 20px;
        }

        .page-header h1 .gh-1 {
            background: linear-gradient(120deg, #fbbf24, #f97316);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradShift 4s ease infinite;
        }

        .page-header h1 .gh-2 {
            background: linear-gradient(120deg, #f43f5e, #ec4899);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradShift 4s ease infinite;
        }

        @keyframes gradShift {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }

        .page-header p {
            max-width: 620px;
            margin: 0 auto;
            color: #ffffff;
            font-size: 17px;
            line-height: 1.8;
            font-weight: 500;
            text-shadow: 0 2px 15px rgba(0,0,0,0.3);
            animation: fadeDown 1s ease;
            animation-delay: 0.2s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .faq-container {
            max-width: 1000px;
            margin: 60px auto 100px;
            padding: 0 20px;
        }

        .faq-category {
            margin-bottom: 60px;
            position: relative;
        }

        .cat-head {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 30px;
            padding-left: 8px;
        }

        .cat-num {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .cat-num::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.3);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .cat-head:hover .cat-num::before {
            transform: translateX(0);
        }

        .cat-num i {
            position: relative;
            z-index: 2;
            color: #ffffff;
        }

        .faq-category:nth-child(1) .cat-num {
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            box-shadow: 0 12px 30px rgba(56,189,248,0.45);
        }

        .faq-category:nth-child(2) .cat-num {
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            box-shadow: 0 12px 30px rgba(167,139,250,0.45);
        }

        .faq-category:nth-child(3) .cat-num {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            box-shadow: 0 12px 30px rgba(99,102,241,0.45);
        }

        .faq-category:nth-child(4) .cat-num {
            background: linear-gradient(135deg, #22d3ee, #06b6d4);
            box-shadow: 0 12px 30px rgba(34,211,238,0.45);
        }

        .cat-title {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .cat-title h2 {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.5px;
            color: #ffffff;
            text-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }

        .cat-title span {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
        }

        .faq-item {
            position: relative;
            border-radius: 20px;
            margin-bottom: 16px;
            background: #ffffff;
            border: 2px solid rgba(139,92,246,0.12);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            opacity: 0;
            box-shadow: 0 6px 20px rgba(99,102,241,0.1);
        }

        .faq-item.reveal-left { transform: translateX(-100px); }
        .faq-item.reveal-right { transform: translateX(100px); }

        .faq-item.active {
            opacity: 1;
            transform: translateX(0);
        }

        .faq-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            background: linear-gradient(180deg, #38bdf8, #0ea5e9);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform 0.5s ease;
        }

        .faq-category:nth-child(2) .faq-item::before {
            background: linear-gradient(180deg, #a78bfa, #7c3aed);
        }

        .faq-category:nth-child(3) .faq-item::before {
            background: linear-gradient(180deg, #6366f1, #4f46e5);
        }

        .faq-category:nth-child(4) .faq-item::before {
            background: linear-gradient(180deg, #22d3ee, #06b6d4);
        }

        .faq-item:hover {
            transform: translateX(0) scale(1.02);
            border-color: rgba(56,189,248,0.4);
            box-shadow: 0 25px 50px rgba(99,102,241,0.22);
            background: linear-gradient(135deg, #ffffff, #f0f9ff);
        }

        .faq-category:nth-child(2) .faq-item:hover {
            border-color: rgba(139,92,246,0.4);
            background: linear-gradient(135deg, #ffffff, #f5f3ff);
        }

        .faq-category:nth-child(3) .faq-item:hover {
            border-color: rgba(99,102,241,0.4);
            background: linear-gradient(135deg, #ffffff, #eef2ff);
        }

        .faq-category:nth-child(4) .faq-item:hover {
            border-color: rgba(34,211,238,0.4);
            background: linear-gradient(135deg, #ffffff, #ecfeff);
        }

        .faq-item:hover::before { transform: scaleY(1); }

        .faq-question {
            width: 100%;
            padding: 24px 30px;
            background: transparent;
            border: none;
            color: #1e1b4b;
            font-size: 17px;
            font-weight: 700;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: inherit;
            line-height: 1.5;
            position: relative;
            z-index: 2;
            transition: color 0.3s ease;
            cursor: pointer;
            letter-spacing: -0.2px;
        }

        .faq-item:hover .faq-question {
            color: #0ea5e9;
        }

        .faq-category:nth-child(2) .faq-item:hover .faq-question { color: #7c3aed; }
        .faq-category:nth-child(3) .faq-item:hover .faq-question { color: #4f46e5; }
        .faq-category:nth-child(4) .faq-item:hover .faq-question { color: #06b6d4; }

        .q-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            margin-left: 20px;
            background: #eef2ff;
            border: 2px solid rgba(139,92,246,0.15);
            color: #6366f1;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .faq-item:hover .q-icon {
            transform: rotate(180deg) scale(1.1);
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 8px 25px rgba(56,189,248,0.5);
        }

        .faq-category:nth-child(2) .faq-item:hover .q-icon {
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            box-shadow: 0 8px 25px rgba(167,139,250,0.5);
        }

        .faq-category:nth-child(3) .faq-item:hover .q-icon {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            box-shadow: 0 8px 25px rgba(99,102,241,0.5);
        }

        .faq-category:nth-child(4) .faq-item:hover .q-icon {
            background: linear-gradient(135deg, #22d3ee, #06b6d4);
            box-shadow: 0 8px 25px rgba(34,211,238,0.5);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.6s cubic-bezier(0.4, 0, 0.2, 1), padding 0.4s ease, opacity 0.4s ease;
            padding: 0 30px;
            opacity: 0;
            position: relative;
            z-index: 2;
        }

        .faq-item:hover .faq-answer {
            max-height: 500px;
            padding: 0 30px 28px;
            opacity: 1;
        }

        .faq-answer-inner {
            padding-top: 20px;
            border-top: 1px dashed rgba(99,102,241,0.2);
        }

        .faq-answer p {
            color: #3730a3;
            font-size: 15px;
            line-height: 1.9;
            text-align: justify;
            font-weight: 500;
        }

        .faq-answer ul {
            list-style: none;
            padding: 0;
            margin: 14px 0 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }

        .faq-answer ul li {
            padding: 10px 14px;
            padding-left: 34px;
            position: relative;
            color: #3730a3;
            font-size: 14px;
            line-height: 1.6;
            background: #eef2ff;
            border-radius: 10px;
            border: 1px solid rgba(99,102,241,0.1);
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .faq-answer ul li:hover {
            background: #ffffff;
            transform: translateX(4px);
            color: #1e1b4b;
            border-color: rgba(56,189,248,0.4);
        }

        .faq-answer ul li::before {
            content: '›';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #0ea5e9;
            font-weight: 900;
            font-size: 20px;
            line-height: 1;
        }

        .faq-category:nth-child(2) .faq-answer ul li::before { color: #7c3aed; }
        .faq-category:nth-child(3) .faq-answer ul li::before { color: #4f46e5; }
        .faq-category:nth-child(4) .faq-answer ul li::before { color: #06b6d4; }

        .faq-answer strong {
            color: #0ea5e9;
            font-weight: 800;
        }

        .faq-category:nth-child(2) .faq-answer strong { color: #7c3aed; }
        .faq-category:nth-child(3) .faq-answer strong { color: #4f46e5; }
        .faq-category:nth-child(4) .faq-answer strong { color: #06b6d4; }

        .faq-answer a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 700;
            position: relative;
            transition: color 0.3s ease;
        }

        .faq-answer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #0ea5e9;
            transition: width 0.3s ease;
        }

        .faq-answer a:hover::after { width: 100%; }

        .faq-category:nth-child(2) .faq-answer a { color: #7c3aed; }
        .faq-category:nth-child(2) .faq-answer a::after { background: #7c3aed; }
        .faq-category:nth-child(3) .faq-answer a { color: #4f46e5; }
        .faq-category:nth-child(3) .faq-answer a::after { background: #4f46e5; }
        .faq-category:nth-child(4) .faq-answer a { color: #06b6d4; }
        .faq-category:nth-child(4) .faq-answer a::after { background: #06b6d4; }

        @media (max-width: 768px) {
            .page-header { padding: 100px 16px 40px; }
            .page-header h1 { letter-spacing: -1.5px; }
            .faq-container { margin: 40px auto 60px; }
            .cat-num { width: 46px; height: 46px; font-size: 17px; }
            .cat-title h2 { font-size: 20px; }
            .faq-question { padding: 20px 22px; font-size: 15px; }
            .q-icon { width: 34px; height: 34px; font-size: 13px; margin-left: 14px; }
            .faq-answer { padding: 0 22px; }
            .faq-item:hover .faq-answer { padding: 0 22px 22px; }
            .faq-answer ul { grid-template-columns: 1fr; }
            .faq-item.reveal-left { transform: translateX(-60px); }
            .faq-item.reveal-right { transform: translateX(60px); }
        }

        @media (max-width: 480px) {
            .page-header h1 { letter-spacing: -1px; }
            .cat-head { gap: 14px; }
            .cat-num { width: 40px; height: 40px; font-size: 15px; border-radius: 12px; }
            .cat-title h2 { font-size: 17px; }
            .cat-title span { font-size: 10px; letter-spacing: 2px; }
            .faq-question { padding: 18px 18px; font-size: 14px; }
            .faq-answer { padding: 0 18px; }
            .faq-item:hover .faq-answer { padding: 0 18px 20px; }
        }
    </style>
</head>
<body>

    <div class="faq-bg"></div>

    <section class="page-header">
        <div class="ph-tag">Help Center</div>
        
        <p>Find answers to the most common questions about our services, process, and support. Hover over any question to reveal the answer.</p>
    </section>

    <section class="faq-container">

        <div class="faq-category">
            <div class="cat-head">
                <div class="cat-num"><i class="fas fa-question-circle"></i></div>
                <div class="cat-title">
                    <h2>General</h2>
                    <span>Category 01</span>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    How long has BrandEve Solutions been in business?
                    <span class="q-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <p>BrandEve Solutions has been delivering exceptional events and marketing services for over 22 years. Our extensive experience allows us to handle projects of any scale with professionalism and creativity.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    What industries do you specialize in?
                    <span class="q-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <p>We work across a diverse range of industries including:</p>
                        <ul>
                            <li>FMCG & Retail</li>
                            <li>Technology & IT</li>
                            <li>Healthcare & Wellness</li>
                            <li>Real Estate & Construction</li>
                            <li>Automobile</li>
                            <li>Education & Training</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-category">
            <div class="cat-head">
                <div class="cat-num"><i class="fas fa-cogs"></i></div>
                <div class="cat-title">
                    <h2>Services</h2>
                    <span>Category 02</span>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    Do you offer customized event packages?
                    <span class="q-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <p>Yes! Every event is unique, and we work closely with our clients to design customized packages that fit their specific requirements, budget, and vision. Contact us to discuss your event needs.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    Can you handle both small and large-scale events?
                    <span class="q-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <p>Absolutely. We have experience managing everything from intimate corporate meetings of 20 people to large-scale conferences, exhibitions, and concerts with thousands of attendees.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-category">
            <div class="cat-head">
                <div class="cat-num"><i class="fas fa-sync-alt"></i></div>
                <div class="cat-title">
                    <h2>Process</h2>
                    <span>Category 03</span>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    How does the event planning process work?
                    <span class="q-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <p>Our process follows four simple steps:</p>
                        <ul>
                            <li><strong>Discovery:</strong> We learn about your goals, audience, and requirements.</li>
                            <li><strong>Strategy:</strong> We craft a tailored plan and present it to you.</li>
                            <li><strong>Execution:</strong> We manage all logistics and on-site coordination.</li>
                            <li><strong>Results:</strong> We deliver the event and provide post-event feedback.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    How far in advance should I book your services?
                    <span class="q-icon"><i class="fas fa-chevron-down"></i></span>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <p>We recommend booking at least <strong>4-6 weeks</strong> in advance for corporate events and <strong>2-3 months</strong> for weddings and large-scale events. However, we also accommodate last-minute requests whenever possible – contact us to check availability.</p>
                    </div>
                </div>
            </div>
        </div>

    

    </section>

    <script>
        (function() {
            const items = document.querySelectorAll('.faq-item');

            items.forEach(function(item, index) {
                const globalIndex = Array.from(items).indexOf(item);
                if (globalIndex % 2 === 0) {
                    item.classList.add('reveal-right');
                } else {
                    item.classList.add('reveal-left');
                }
            });

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -80px 0px'
            });

            items.forEach(function(item, i) {
                item.style.transitionDelay = (i * 0.08) + 's';
                observer.observe(item);
            });
        })();
    </script>

</body>
</html>

<?php include("../includes/footer.php"); ?>