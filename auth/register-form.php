<?php
session_start();
include('../includes/config.php');

if (!isset($_SESSION['reg_verified']) || $_SESSION['reg_verified'] !== true) {
    header('Location: register.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $mobile = trim($_POST['mobile']);

    if (empty($username) || empty($email) || empty($password) || empty($mobile)) {
        $error = 'All fields are required.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $error = 'Please enter a valid 10-digit mobile number.';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, mobile, is_verified) VALUES (?, ?, ?, ?, 1)");
            $stmt->bind_param("ssss", $username, $email, $hashed, $mobile);
            if ($stmt->execute()) {
                $success = 'Registration successful! Redirecting to login...';
                unset($_SESSION['reg_email'], $_SESSION['reg_code'], $_SESSION['reg_code_expires'], $_SESSION['reg_verified']);
                echo '<meta http-equiv="refresh" content="2;url=login.php">';
            } else {
                $error = 'Registration failed: ' . $stmt->error;
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
            margin-bottom: 16px;
        }
        .success {
            background: rgba(52,211,153,0.12); border: 2px solid #34d399;
            color: #6ee7b7; padding: 16px 20px; border-radius: 12px; margin-bottom: 16px;
            font-size: 20px; font-weight: 700; text-align: center; box-shadow: 0 0 30px rgba(52,211,153,0.1);
        }
        label { display: block; font-size: 14px; font-weight: 600; color: #d1d5db; margin-bottom: 4px; }
        input { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04); color: #ffffff; font-size: 15px; margin-bottom: 18px;
            transition: all 0.3s ease; }
        input:focus { outline: none; border-color: #38BDF8; background: rgba(56,189,248,0.06);
            box-shadow: 0 0 0 3px rgba(56,189,248,0.08); }
        input[readonly] { opacity: 0.6; cursor: not-allowed; }
        button { width: 100%; padding: 14px; border: none; border-radius: 10px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8); color: #ffffff; font-size: 16px;
            font-weight: 700; cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(56,189,248,0.2); }
        button:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(56,189,248,0.35); }
        .links { text-align: center; margin-top: 16px; color: #6b7280; font-size: 14px; }
        .links a { color: #38BDF8; text-decoration: none; font-weight: 600; }
        .links a:hover { text-decoration: underline; }
        @media (max-width: 480px) { .register-container { padding: 30px 20px; } }
    </style>
</head>
<body>
    <div class="register-container">
        <h1><span>Create Account</span></h1>
        <p class="sub">Complete your registration</p>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success">✅ <?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (empty($success)): ?>
            <form method="POST">
                <label for="username">Full Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your full name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['reg_email']; ?>" readonly>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Min 6 characters" required>
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter 10-digit mobile number" maxlength="10" required>
                <button type="submit" name="register"><i class="fas fa-user-plus" style="margin-right: 10px;"></i>Register</button>
            </form>
        <?php endif; ?>
        <div class="links">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>