<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

include('../includes/config.php');

// Set timezone to UTC for consistency (or match your server timezone)
date_default_timezone_set('UTC');

if (!isset($_SESSION['reset_email'])) {
    header('Location: forgot-password.php');
    exit;
}

$email = $_SESSION['reset_email'];
$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (empty($code) || empty($password) || empty($confirm)) {
        $error = 'All fields are required.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            // Fetch the reset record with its expiration time
            $stmt = $conn->prepare("SELECT id, expires_at FROM password_resets WHERE email = ? AND code = ? ORDER BY created_at DESC LIMIT 1");
            $stmt->bind_param("ss", $email, $code);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                // No record found – check if the email has any records (to differentiate invalid vs expired)
                $check = $conn->prepare("SELECT id FROM password_resets WHERE email = ? ORDER BY created_at DESC LIMIT 1");
                $check->bind_param("s", $email);
                $check->execute();
                $checkResult = $check->get_result();
                if ($checkResult->num_rows === 0) {
                    $error = 'No reset request found for this email. Please request a new code.';
                } else {
                    $error = 'Invalid verification code. Please check and try again.';
                }
                $check->close();
            } else {
                $row = $result->fetch_assoc();
                $expires_at = strtotime($row['expires_at']);
                $current_time = time();

                if ($current_time > $expires_at) {
                    $error = 'Verification code has expired. Please request a new one.';
                    // Optionally delete expired record to avoid confusion
                    $del = $conn->prepare("DELETE FROM password_resets WHERE id = ?");
                    $del->bind_param("i", $row['id']);
                    $del->execute();
                    $del->close();
                } else {
                    // Code is valid – update password
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $update = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE email = ?");
                    $update->bind_param("ss", $hashed, $email);
                    if ($update->execute()) {
                        // Delete all reset records for this email
                        $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                        $del->bind_param("s", $email);
                        $del->execute();
                        $del->close();

                        $message = 'Password reset successful. You can now <a href="login.php">login</a> with your new password.';
                        unset($_SESSION['reset_email']);
                    } else {
                        $error = 'Failed to update password. Please try again.';
                    }
                    $update->close();
                }
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
    <title>Reset Password - BrandEve</title>
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
        .message {
            background: rgba(52,211,153,0.1);
            border: 1px solid rgba(52,211,153,0.2);
            color: #6ee7b7;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .message a {
            color: #6ee7b7;
            text-decoration: underline;
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
        <h1>Reset <span>Password</span></h1>
        <p class="sub">Enter the verification code and set a new password</p>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (empty($message)): ?>
        <form method="POST">
            <label for="code">Verification Code</label>
            <input type="text" id="code" name="code" placeholder="Enter 6-digit code" maxlength="6" required>
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Min 6 characters" required>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password" required>
            <button type="submit"><i class="fas fa-save" style="margin-right: 10px;"></i>Reset Password</button>
        </form>
        <?php endif; ?>

        <div class="back-link">
            <a href="login.php"><i class="fas fa-arrow-left" style="margin-right: 4px;"></i>Back to Login</a>
        </div>
    </div>
</body>
</html>