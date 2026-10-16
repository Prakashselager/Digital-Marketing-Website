<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

date_default_timezone_set('UTC');
include('../includes/config.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            // Check if admin exists
            $stmt = $conn->prepare("SELECT id, username FROM admin_users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                $code = sprintf("%06d", mt_rand(100000, 999999));
                $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                // Delete old reset requests for this email
                $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $del->bind_param("s", $email);
                $del->execute();

                // Insert new reset request with code
                $stmt2 = $conn->prepare("INSERT INTO password_resets (email, token, code, expires_at) VALUES (?, ?, ?, ?)");
                $token = ''; // we are using code only
                $stmt2->bind_param("ssss", $email, $token, $code, $expires);
                if (!$stmt2->execute()) {
                    $error = 'Failed to save reset request. Please try again.';
                } else {
                    // Send email
                    $subject = "Password Reset Code - " . SITE_NAME;
                    $body = "Hello " . $admin['username'] . ",\n\n";
                    $body .= "You requested to reset your admin password. Your verification code is:\n\n";
                    $body .= $code . "\n\n";
                    $body .= "This code will expire in 10 minutes.\n\n";
                    $body .= "Enter this code on the reset page to set a new password.\n\n";
                    $body .= "If you did not request this, please ignore this email.\n\n";
                    $body .= "Regards,\n" . SITE_NAME;

                    $url = 'https://api.brevo.com/v3/smtp/email';
                    $data = [
                        'sender' => ['name' => SITE_NAME, 'email' => 'your@gmail.com'],
                        'to' => [['email' => $email, 'name' => $admin['username']]],
                        'subject' => $subject,
                        'textContent' => $body,
                        'htmlContent' => "<html><body><pre>" . htmlspecialchars($body) . "</pre></body></html>"
                    ];
                    $payload = json_encode($data);
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'api-key: ' . BREVO_API_KEY]);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $result2 = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($httpCode === 201) {
                        $_SESSION['reset_email'] = $email;
                        header('Location: reset-password.php');
                        exit;
                    } else {
                        $error = 'Failed to send verification code. Please try again.';
                    }
                }
                $stmt2->close();
            } else {
                $error = 'No admin account found with this email address.';
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - BrandEve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/images/bg1.png') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 40px 35px;
            background: rgba(10, 10, 30, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(56, 189, 248, 0.12);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            margin: 20px;
        }
        .login-container h1 {
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 6px;
        }
        .login-container h1 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .login-container .sub {
            text-align: center;
            color: #d1d5db;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .error {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 4px;
        }
        input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            color: #ffffff;
            font-size: 15px;
            margin-bottom: 18px;
            transition: 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #38BDF8;
            background: rgba(56,189,248,0.06);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.08);
        }
        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 25px rgba(56,189,248,0.2);
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56,189,248,0.35);
        }
        .back-link {
            text-align: center;
            margin-top: 14px;
        }
        .back-link a {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .back-link a:hover {
            color: #38BDF8;
            text-decoration: underline;
        }
        @media (max-width: 480px) {
            .login-container { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Forgot <span>Password</span></h1>
        <p class="sub">Enter your email to receive a verification code</p>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="admin@brandeve.com" required>
            <button type="submit"><i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Code</button>
        </form>
        <div class="back-link">
            <a href="login.php"><i class="fas fa-arrow-left" style="margin-right: 4px;"></i>Back to Login</a>
        </div>
    </div>
</body>
</html>