<?php
include("../includes/config.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - BrandEve Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">
    <style>
        :root {
            --image-height: 280px;
            --image-height-mobile: 220px;
            --primary-color: #2563eb;
            --primary-dark: #1e3a8a;
            --primary-dark-hover: #1e40af;
            --primary-light: #eff6ff;
            --text-dark: #0b2545;
            --text-body: #475569;
            --text-muted: #94a3b8;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --page-bg: #f5f8ff;
            --page-bg-alt: #eef3ff;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--page-bg);
            min-height: 100vh;
            color: var(--text-dark);
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(circle at 90% 10%, rgba(59, 130, 246, 0.12), transparent 40%),
                radial-gradient(circle at 10% 90%, rgba(99, 102, 241, 0.10), transparent 40%),
                linear-gradient(180deg, var(--page-bg) 0%, var(--page-bg-alt) 100%);
        }

        .contact-hero {
            max-width: 1280px;
            margin: 0 auto;
            padding: 60px 40px 60px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
        }

        .tag-label {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--primary-color);
            margin-bottom: 28px;
        }

        .tag-label::after {
            content: '';
            width: 40px;
            height: 2px;
            background: var(--primary-color);
        }

        .hero-left h1 {
            font-size: clamp(38px, 5vw, 58px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1.5px;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        .hero-left h1 span {
            color: var(--primary-color);
        }

        .hero-text {
            font-size: 16px;
            line-height: 1.75;
            color: var(--text-body);
            max-width: 500px;
            margin-bottom: 40px;
            text-align:justify;
        }

        .contact-form-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-sm);
            padding: 32px;
            box-shadow: 0 4px 24px rgba(15, 23, 42, 0.04);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full {
            margin-bottom: 24px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            color: var(--text-muted);
            font-size: 15px;
            transition: color 0.3s ease;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            width: 100%;
            padding: 15px 18px 15px 48px;
            border: 1px solid var(--card-border);
            border-radius: var(--radius-sm);
            background: var(--card-bg);
            color: var(--text-dark);
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper textarea {
            min-height: 130px;
            resize: vertical;
            padding-top: 16px;
            align-items: flex-start;
        }

        .input-wrapper.textarea-wrapper i {
            top: 18px;
        }

        .input-wrapper input::placeholder,
        .input-wrapper textarea::placeholder {
            color: var(--text-muted);
        }

        .input-wrapper input:hover,
        .input-wrapper textarea:hover {
            border-color: #cbd5e1;
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-wrapper input:focus ~ i,
        .input-wrapper textarea:focus ~ i {
            color: var(--primary-color);
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 32px;
            border: none;
            border-radius: var(--radius-sm);
            background: var(--primary-dark);
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 18px rgba(30, 58, 138, 0.25);
        }

        .submit-btn:hover {
            background: var(--primary-dark-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(30, 58, 138, 0.35);
        }

        .submit-btn:hover i {
            transform: translateX(4px);
        }

        .submit-btn i {
            transition: transform 0.3s ease;
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .hero-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: fit-content;
        }

        .hero-image-wrapper {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            height: var(--image-height);
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
        }

        .hero-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
            position: absolute;
            inset: 0;
        }

        .hero-image-wrapper:hover img {
            transform: scale(1.04);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            padding: 30px 22px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
            min-height: 140px;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.12);
            border-color: #c7d2fe;
        }

        .info-icon {
            flex-shrink: 0;
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 18px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .info-card:hover .info-icon {
            background: var(--primary-color);
            color: #ffffff;
            transform: scale(1.08) rotate(-6deg);
        }

        .info-content h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
            letter-spacing: -0.2px;
        }

        .info-content p {
            font-size: 14px;
            color: var(--text-body);
            line-height: 1.6;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .info-content .muted {
            font-size: 13px;
            color: var(--text-muted);
        }

        .social-row {
            display: flex;
            gap: 8px;
            margin-top: 6px;
        }

        .social-row a {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-body);
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-row a:hover {
            background: var(--primary-color);
            color: #ffffff;
            transform: translateY(-3px);
        }

        .map-section {
            max-width: 1280px;
            margin: 20px auto 100px;
            padding: 0 40px;
        }

        .map-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .map-header h2 {
            font-size: clamp(28px, 3.5vw, 42px);
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -1px;
            margin-bottom: 10px;
        }

        .map-header h2 span {
            color: var(--primary-color);
        }

        .map-header p {
            color: var(--text-body);
            font-size: 16px;
        }

        .map-wrapper {
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            transition: all 0.4s ease;
        }

        .map-wrapper:hover {
            box-shadow: 0 25px 70px rgba(37, 99, 235, 0.15);
            border-color: #c7d2fe;
        }

        .map-wrapper iframe {
            width: 100%;
            height: 450px;
            border: none;
            display: block;
        }

        .success-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(6px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-box {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.3);
            animation: fadeUp 0.4s ease;
        }

        .success-box .icon-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            color: var(--primary-color);
        }

        .success-box h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .success-box p {
            font-size: 15px;
            color: var(--text-body);
            line-height: 1.6;
            margin-bottom: 26px;
        }

        .success-box .btn-close {
            padding: 13px 34px;
            border: none;
            border-radius: var(--radius-sm);
            background: var(--primary-dark);
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .success-box .btn-close:hover {
            background: var(--primary-dark-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(30, 58, 138, 0.35);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1024px) {
            :root {
                --image-height: var(--image-height-mobile);
            }

            .contact-hero {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 120px 24px 40px;
            }

            .hero-right {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .contact-hero {
                padding: 110px 20px 30px;
            }

            .hero-left h1 {
                letter-spacing: -1px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .contact-form-card {
                padding: 24px 20px;
            }

            .map-section {
                padding: 0 20px;
                margin-bottom: 60px;
            }

            .map-wrapper iframe {
                height: 320px;
            }
        }

        @media (max-width: 480px) {
            .hero-text {
                font-size: 15px;
            }

            .submit-btn {
                width: 100%;
                justify-content: center;
            }

            .map-wrapper iframe {
                height: 260px;
            }
        }
    </style>
</head>
<body>

    <section class="contact-hero">

        <div class="hero-left">
            <div class="tag-label">Get In Touch</div>
            <h1>Let's Build Something <span>Great Together</span></h1>
            <p class="hero-text">
                Have a project in mind, a question, or just want to say hello? We'd love to hear from you. Reach out to us and let's create something amazing together.
            </p>

            <div class="contact-form-card">
                <form id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="name" name="name" placeholder="Your Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="Your Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-phone-alt"></i>
                                <input type="tel" id="phone" name="phone" maxlength="10" minlength="10" pattern="[0-9]{10}" inputmode="numeric" placeholder="Mobile Number" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-tag"></i>
                                <input type="text" id="subject" name="subject" placeholder="Subject" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        <div class="input-wrapper textarea-wrapper">
                            <i class="fas fa-comment-dots"></i>
                            <textarea id="message" name="message" placeholder="Your Message" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        Send Message <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="hero-right">

            <div class="hero-image-wrapper">
                <img src="<?php echo BASE_URL; ?>assets/images/contact.png" alt="Contact BrandEve">
            </div>
<br>
<br>
<br>
            <div class="info-grid">

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-content">
                        <h4>Our Location</h4>
                        <p>Kumbalgodu, Bengaluru</p>
                        <span class="muted">Karnataka 560074</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-content">
                        <h4>Email Us</h4>
                        <p>your@gmail.com</p>
                        <span class="muted">We reply within 24 hours</span>
                    </div>
</div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="info-content">
                        <h4>Call Us</h4>
                        <p>+91 00000000000</p>
                        <span class="muted">Mon – Sat, 9:00 AM – 6:00 PM</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-share-alt"></i></div>
                    <div class="info-content">
                        <h4>Follow Us</h4>
                        <div class="social-row">
                            <a href="https://www.facebook.com/brandevesolutions" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/brandeve_solutions/" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/company/brandevesolutions" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://twitter.com/brandevesolutions" aria-label="X"><i class="fab fa-x-twitter"></i></a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <section class="map-section">

        <div class="map-header">
            <h2>Find Us <span>Here</span></h2>
            <p>Visit our office — we'd love to meet you in person.</p>
        </div>

        <div class="map-wrapper">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d231.7024603662082!2d77.43390971717929!3d12.871502618541259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTLCsDUyJzE3LjUiTiA3N8KwMjYnMDIuMCJF!5e1!3m2!1sen!2sin!4v1788857606437!5m2!1sen!2sin"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </section>

    <div class="success-overlay" id="successOverlay">
        <div class="success-box">
            <div class="icon-circle"><i class="fas fa-check"></i></div>
            <h2>Message Sent!</h2>
            <p>Thank you for reaching out. We'll get back to you soon...</p>
            <button class="btn-close" id="closeSuccess">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            const successOverlay = document.getElementById('successOverlay');
            const closeBtn = document.getElementById('closeSuccess');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

                const formData = new FormData(this);

                fetch('<?php echo BASE_URL; ?>api/contact.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Server error: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        successOverlay.style.display = 'flex';
                        form.reset();
                    } else {
                        alert('Error: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Network error: ' + error.message);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Send Message <i class="fas fa-arrow-right"></i>';
                });
            });

            closeBtn.addEventListener('click', function() {
                successOverlay.style.display = 'none';
            });

            successOverlay.addEventListener('click', function(e) {
                if (e.target === this) successOverlay.style.display = 'none';
            });
        });
    </script>

</body>
</html>

<?php include("../includes/footer.php"); ?>