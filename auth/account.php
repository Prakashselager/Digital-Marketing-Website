<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
include('../includes/config.php');
include('../includes/navbar.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - BrandEve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; overflow-x: hidden; overscroll-behavior: none; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/images/bg1.png') no-repeat center center fixed;
            background-size: cover; background-attachment: fixed;
            min-height: 100vh; color: #ffffff; overflow-x: hidden;
        }
        .account-container {
            max-width: 800px; margin: 120px auto 80px; padding: 0 20px;
        }
        .account-card {
            background: rgba(10, 10, 30, 0.85); backdrop-filter: blur(12px);
            border-radius: 24px; border: 1px solid rgba(56, 189, 248, 0.12);
            padding: 40px; box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        }
        .account-card h1 {
            font-size: 32px; font-weight: 800; margin-bottom: 6px;
        }
        .account-card h1 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .account-card .sub {
            color: #d1d5db; font-size: 15px; margin-bottom: 30px;
        }
        .info-row {
            display: flex; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .info-row:last-child { border-bottom: none; }
        .info-label {
            width: 120px; color: #93C5FD; font-weight: 600; font-size: 14px;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .info-value { color: #e5e7eb; font-size: 16px; font-weight: 500; }
        .logout-btn {
            display: inline-flex; align-items: center; gap: 8px; margin-top: 25px;
            padding: 12px 30px; border-radius: 50px; background: rgba(239,68,68,0.1);
            color: #f87171; text-decoration: none; font-weight: 700; font-size: 15px;
            border: 1px solid rgba(239,68,68,0.2); transition: all 0.3s ease;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.2); transform: translateY(-2px); }
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px; margin-top: 25px; margin-right: 12px;
            padding: 12px 30px; border-radius: 50px; background: rgba(56,189,248,0.1);
            color: #38BDF8; text-decoration: none; font-weight: 700; font-size: 15px;
            border: 1px solid rgba(56,189,248,0.2); transition: all 0.3s ease;
        }
        .back-btn:hover { background: rgba(56,189,248,0.2); transform: translateY(-2px); }
        @media (max-width: 600px) {
            .account-card { padding: 25px 20px; }
            .info-row { flex-direction: column; gap: 4px; padding: 12px 0; }
            .info-label { width: 100%; font-size: 12px; }
            .info-value { font-size: 15px; }
            .account-card h1 { font-size: 26px; }
        }
    </style>
</head>
<body>
    <div class="account-container">
        <div class="account-card">
            <h1>My <span>Account</span></h1>
            <p class="sub">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>

            <div class="info-row">
                <span class="info-label">Username</span>
                <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Mobile</span>
                <span class="info-value"><?php echo htmlspecialchars($_SESSION['user_mobile']); ?></span>
            </div>

            <div>
                <a href="../pages/home.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php include('../includes/footer.php'); ?>