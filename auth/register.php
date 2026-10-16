<?php
session_start();
include('../includes/config.php');

$step = isset($_GET['step']) ? $_GET['step'] : 'email';
$error = '';
$success = '';
$email = isset($_SESSION['reg_email']) ? $_SESSION['reg_email'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_code'])) {
    $email = trim($_POST['email']);
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();
            if ($check->num_rows > 0) {
                $error = 'This email is already registered. Please login.';
            } else {
                $code = sprintf("%06d", mt_rand(100000, 999999));
                $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                $_SESSION['reg_email'] = $email;
                $_SESSION['reg_code'] = $code;
                $_SESSION['reg_code_expires'] = $expires;

                $url = 'https://api.brevo.com/v3/smtp/email';
                $data = [
                    'sender' => ['name' => SITE_NAME, 'email' => 'brandevesolutions@gmail.com'],
                    'to' => [['email' => $email, 'name' => 'User']],
                    'subject' => 'Email Verification - ' . SITE_NAME,
                    'textContent' => "Your verification code is: $code\n\nThis code will expire in 10 minutes.",
                    'htmlContent' => "<html><body><h2>Email Verification</h2><p>Your verification code is:</p><h1 style='color:#38BDF8;font-size:32px;'>$code</h1><p>This code will expire in 10 minutes.</p></body></html>"
                ];
                $payload = json_encode($data);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'api-key: ' . BREVO_API_KEY]);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 201) {
                    $success = 'Verification code sent to your email.';
                    $step = 'verify';
                } else {
                    $error = 'Failed to send verification code. Please try again.';
                }
            }
            $check->close();
            $conn->close();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    $entered_code = trim($_POST['code']);
    if (empty($entered_code)) {
        $error = 'Please enter the verification code.';
    } elseif (!isset($_SESSION['reg_code']) || !isset($_SESSION['reg_code_expires'])) {
        $error = 'No verification code found. Please request a new one.';
    } elseif (strtotime($_SESSION['reg_code_expires']) < time()) {
        $error = 'Verification code has expired. Please request a new one.';
        unset($_SESSION['reg_code']);
    } elseif ($entered_code !== $_SESSION['reg_code']) {
        $error = 'Invalid verification code. Please try again.';
    } else {
        $_SESSION['reg_verified'] = true;
        header('Location: register.php?step=form');
        exit;
    }
    $step = 'verify';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BrandEve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; overflow-x: hidden; overscroll-behavior: none; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('../assets/images/bg1.png') no-repeat center center fixed;
            background-size: cover; background-attachment: fixed;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            color: #ffffff; overflow-x: hidden; padding: 20px;
        }
        .register-container {
            max-width: 480px; width: 100%; padding: 40px 35px;
            background: rgba(10, 10, 30, 0.85); backdrop-filter: blur(12px);
            border-radius: 24px; border: 1px solid rgba(56, 189, 248, 0.12);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        }
        .register-container h1 {
            text-align: center; font-size: 28px; font-weight: 800; margin-bottom: 6px;
        }
        .register-container h1 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .register-container .sub {
            text-align: center; color: #d1d5db; font-size: 14px; margin-bottom: 25px;
        }
        .error {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5; padding: 10px 14px; border-radius: 8px; font-size: 14px;
            margin-bottom: 16px; display: <?php echo $error ? 'block' : 'none'; ?>;
        }
        .success {
            background: rgba(52,211,153,0.12); border: 2px solid #34d399;
            color: #6ee7b7; padding: 16px 20px; border-radius: 12px; margin-bottom: 16px;
            font-size: 20px; font-weight: 700; text-align: center; box-shadow: 0 0 30px rgba(52,211,153,0.1);
            display: <?php echo $success ? 'block' : 'none'; ?>;
        }
        label { display: block; font-size: 14px; font-weight: 600; color: #d1d5db; margin-bottom: 4px; }

        /* ===== REGULAR INPUT ===== */
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%; padding: 12px 16px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04); color: #ffffff; font-size: 15px;
            margin-bottom: 18px; transition: all 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus {
            outline: none; border-color: #38BDF8;
            background: rgba(56,189,248,0.06);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.08);
        }

        /* ===== PASSWORD WRAPPER ===== */
        .password-wrapper {
            position: relative;
            margin-bottom: 18px;
        }
        .password-wrapper input {
            width: 100%; padding: 12px 45px 12px 16px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04); color: #ffffff; font-size: 15px;
            transition: all 0.3s ease;
        }
        .password-wrapper input:focus {
            outline: none; border-color: #38BDF8;
            background: rgba(56,189,248,0.06);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.08);
        }
        .password-wrapper .toggle-password {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            color: rgba(255,255,255,0.35); cursor: pointer; font-size: 18px; transition: 0.3s;
        }
        .password-wrapper .toggle-password:hover { color: #38BDF8; }

        button {
            width: 100%; padding: 14px; border: none; border-radius: 10px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff; font-size: 16px; font-weight: 700;
            cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(56,189,248,0.2);
        }
        button:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(56,189,248,0.35); }
        .links { text-align: center; margin-top: 16px; color: #6b7280; font-size: 14px; }
        .links a { color: #38BDF8; text-decoration: none; font-weight: 600; }
        .links a:hover { text-decoration: underline; }

        input[readonly] { opacity: 0.6; cursor: not-allowed; }

        @media (max-width: 480px) { .register-container { padding: 30px 20px; } }
    </style>
</head>
<body>
    <div class="register-container">
        <h1><span>Register</span></h1>
        <p class="sub">
            <?php
            if ($step === 'email') echo 'Enter your email to get started';
            elseif ($step === 'verify') echo 'Enter the verification code sent to your email';
            else echo 'Create your account';
            ?>
        </p>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success">✅ <?php echo $success; ?></div>
        <?php endif; ?>

        <?php if ($step === 'email'): ?>
            <form method="POST">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" value="<?php echo $email; ?>" required>
                <button type="submit" name="send_code"><i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Send Verification Code</button>
            </form>
            <div class="links">
                Already have an account? <a href="login.php">Login here</a>
            </div>

        <?php elseif ($step === 'verify'): ?>
            <form method="POST">
                <label for="code">Verification Code</label>
                <input type="text" id="code" name="code" placeholder="Enter 6-digit code" maxlength="6" required>
                <button type="submit" name="verify_code"><i class="fas fa-check-circle" style="margin-right: 10px;"></i>Verify Code</button>
            </form>
            <div class="links">
                Didn't receive code? <a href="register.php?step=email">Resend code</a> | <a href="login.php">Back to Login</a>
            </div>

        <?php else: ?>
            <form method="POST" action="register-form.php">
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your full name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['reg_email']; ?>" readonly>
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Min 6 characters" required>
                    <span class="toggle-password" onclick="togglePassword()"><i class="fas fa-eye"></i></span>
                </div>
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter 10-digit mobile number" maxlength="10" required>
                <button type="submit" name="register"><i class="fas fa-user-plus" style="margin-right: 10px;"></i>Register</button>
            </form>
            <div class="links">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.querySelector('.toggle-password i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>