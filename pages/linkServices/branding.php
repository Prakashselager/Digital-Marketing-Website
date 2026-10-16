<?php
include("../../includes/config.php");
include("../../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branding & Promotions - BrandEve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html {
            overflow-x: hidden;
            overscroll-behavior: none;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../../assets/images/bg1.png') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ===== SERVICE NUMBER WRAPPER ===== */
        .service-number-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid rgba(56, 189, 248, 0.08);
            padding-bottom: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .service-number {
            font-size: 48px;
            font-weight: 900;
            color: #38BDF8;
            text-shadow: 0 0 40px rgba(56, 189, 248, 0.15);
            letter-spacing: 2px;
            text-transform: uppercase;
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .service-number span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ===== BACK TO SERVICES BUTTON ===== */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            border-radius: 50px;
            background: rgba(56, 189, 248, 0.06);
            border: 1.5px solid rgba(56, 189, 248, 0.2);
            color: #93C5FD;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .back-btn:hover {
            background: rgba(56, 189, 248, 0.12);
            border-color: #38BDF8;
            color: #ffffff;
            transform: translateX(-4px);
        }

        .back-btn i {
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .back-btn:hover i {
            transform: translateX(-3px);
        }

        /* ===== SERVICE DETAIL ===== */
        .service-detail {
            background: rgba(10, 10, 30, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(56, 189, 248, 0.08);
            padding: 40px;
            margin-bottom: 40px;
        }

        .service-detail h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .service-detail h1 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .service-detail p {
            font-size: 16px;
            line-height: 1.8;
            color: #d1d5db;
            margin-bottom: 16px;
        }

        .service-detail ul {
            list-style: none;
            padding: 0;
            margin: 16px 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px 20px;
        }

        .service-detail ul li {
            padding: 6px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .service-detail ul li i {
            color: #38BDF8;
            width: 20px;
            font-size: 14px;
        }

        /* ===== ENQUIRY FORM ===== */
        .enquiry-form {
            background: rgba(64, 115, 116, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(56, 189, 248, 0.15);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 40px rgba(56, 189, 248, 0.05), inset 0 0 60px rgba(56, 189, 248, 0.03);
        }

        .enquiry-form h2 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #e6f10b;
        }

        .enquiry-form .sub {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .enquiry-form input,
        .enquiry-form textarea {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.85);
            color: #1a1a2e;
            font-size: 16px;
            margin-bottom: 16px;
            transition: 0.3s;
        }

        .enquiry-form input:focus,
        .enquiry-form textarea:focus {
            outline: none;
            border-color: #38BDF8;
            background: #ffffff;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.1);
        }

        .enquiry-form textarea {
            min-height: 100px;
            resize: vertical;
        }

        .enquiry-form button {
            padding: 12px 32px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 25px rgba(56, 189, 248, 0.2);
        }

        .enquiry-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56, 189, 248, 0.35);
        }

        .enquiry-form .success {
            background: rgba(52, 211, 153, 0.12);
            border: 2px solid #34d399;
            color: #6ee7b7;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 16px;
            display: none;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 0 30px rgba(52, 211, 153, 0.1);
        }

        .enquiry-form .error-msg {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            display: none;
        }

        /* ===== SUCCESS OVERLAY ===== */
        .success-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(6px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-overlay .success-box {
            background: rgba(10, 10, 30, 0.95);
            border: 4px solid #34d399;
            border-radius: 24px;
            padding: 50px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
            animation: fadeUp 0.4s ease;
        }

        .success-overlay .success-box .icon {
            font-size: 64px;
            color: #34d399;
            margin-bottom: 16px;
            display: block;
        }

        .success-overlay .success-box h2 {
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .success-overlay .success-box p {
            font-size: 18px;
            color: #d1d5db;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .success-overlay .success-box .btn-close {
            padding: 12px 36px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, #34d399, #10b981);
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 25px rgba(52, 211, 153, 0.2);
        }

        .success-overlay .success-box .btn-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(52, 211, 153, 0.35);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .service-number {
                font-size: 32px;
            }
            .service-detail {
                padding: 24px;
            }
            .enquiry-form {
                padding: 24px;
            }
            .service-detail ul {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .service-number-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }
            .service-number {
                font-size: 28px;
            }
            .back-btn {
                padding: 8px 16px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .service-number {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="service-number-wrapper">
            <div class="service-number">Service <span>Number 2</span></div>
            <a href="../services.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Services</a>
        </div>

        <div class="service-detail">
            <h1><span>Branding</span> & Promotions</h1>
            <p>
                Branding is more than just a logo – it's the identity and personality of your business. At BrandEve Solutions, we help you build a powerful brand that resonates with your target audience and differentiates you from competitors. Our branding services include logo design, visual identity development, brand strategy, and complete brand guidelines that ensure consistency across all touchpoints.
            </p>
            <p>
                Promotions are the bridge between your brand and your customers. We design and execute innovative promotional campaigns that create buzz, drive engagement, and increase brand visibility. From in‑store activations to digital campaigns, our promotions are tailored to your audience and business goals, ensuring maximum impact.
            </p>
            <p>
                We combine creative thinking with strategic planning to deliver branding and promotion solutions that not only look great but also deliver measurable results. Whether you're launching a new brand or refreshing an existing one, we help you stand out and stay memorable.
            </p>
            <ul>
                <li><i class="fas fa-check-circle"></i> Brand Strategy & Positioning</li>
                <li><i class="fas fa-check-circle"></i> Corporate Branding</li>
                <li><i class="fas fa-check-circle"></i> Logo & Brand Identity</li>
                <li><i class="fas fa-check-circle"></i> Marketing Strategy</li>
                <li><i class="fas fa-check-circle"></i> Campaign Planning</li>
                <li><i class="fas fa-check-circle"></i> Product Launch Marketing</li>
                <li><i class="fas fa-check-circle"></i> Retail Branding</li>
                <li><i class="fas fa-check-circle"></i> Corporate Gifting & Branding</li>
                <li><i class="fas fa-check-circle"></i> Promotional Merchandise</li>
                <li><i class="fas fa-check-circle"></i> Print Media Advertising</li>
                <li><i class="fas fa-check-circle"></i> Brochure & Catalogue Design</li>
                <li><i class="fas fa-check-circle"></i> Poster & Creative Design</li>
                <li><i class="fas fa-check-circle"></i> Packaging Branding</li>
                <li><i class="fas fa-check-circle"></i> In-store Branding</li>
                <li><i class="fas fa-check-circle"></i> Dealer & Distributor Branding</li>
                <li><i class="fas fa-check-circle"></i> Mall Branding</li>
                <li><i class="fas fa-check-circle"></i> Cinema Branding</li>
                <li><i class="fas fa-check-circle"></i> Brand Activation</li>
                <li><i class="fas fa-check-circle"></i> Direction Boards</li>
                <li><i class="fas fa-check-circle"></i> RWA Activities</li>
                <li><i class="fas fa-check-circle"></i> Promo Table & Leaflet Printing</li>
            </ul>
        </div>

        <div class="enquiry-form">
            <h2>Enquire Now</h2>
            <p class="sub">We're here to answer your questions. Reach out and let's start a conversation</p>
            <div class="success" id="successMsg">✅ Your enquiry has been sent successfully!</div>
            <div class="error-msg" id="errorMsg">❌ Something went wrong. Please try again.</div>

            <form id="enquiryForm" method="POST">
                <input type="hidden" name="service" value="Branding & Promotions">
                <input type="text" name="name" placeholder="Your Full Name" required>
                <input type="email" name="email" placeholder="Your Email Address" required>
                <input type="tel" name="phone" maxlength="10" minlength="10" pattern="[0-9]{10}" inputmode="numeric" placeholder="Your Phone Number" required>
                <textarea name="message" placeholder="Tell us about your branding requirements..." required></textarea>
                <button type="submit"><i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Enquiry</button>
            </form>
        </div>

    </div>

    <div class="success-overlay" id="successOverlay">
        <div class="success-box">
            <span class="icon"><i class="fas fa-check-circle"></i></span>
            <h2>Thank You!</h2>
            <p>Your enquiry has been sent successfully. We will get back to you shortly.</p>
            <button class="btn-close" id="closeSuccess">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('enquiryForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            const successOverlay = document.getElementById('successOverlay');
            const closeBtn = document.getElementById('closeSuccess');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

                const formData = new FormData(this);

                fetch('../../api/submit_enquiry.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Server error: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        successOverlay.style.display = 'flex';
                        form.reset();
                    } else {
                        alert('Error: ' + (data.error || 'Unknown error'));
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Enquiry';
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Network error. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Enquiry';
                });
            });

            closeBtn.addEventListener('click', function() {
                successOverlay.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Enquiry';
            });

            successOverlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    successOverlay.style.display = 'none';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Enquiry';
                }
            });
        });
    </script>

</body>
</html>

<?php include("../../includes/footer.php"); ?>