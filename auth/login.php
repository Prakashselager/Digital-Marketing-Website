<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: ../pages/home.php');
    exit;
}

include('../includes/config.php');
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            $stmt = $conn->prepare("SELECT id, username, email, password_hash, mobile, is_verified FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if ($user['is_verified'] == 0) {
                    $error = 'Please verify your email before logging in.';
                } elseif (password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['username'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_mobile'] = $user['mobile'];
                    header('Location: ../pages/home.php');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            } else {
                $error = 'Invalid email or password.';
            }
            $stmt->close();
            $conn->close();
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrandEve</title>
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
        .login-container {
            max-width: 400px; width: 100%; padding: 40px 35px;
            background: rgba(10, 10, 30, 0.85); backdrop-filter: blur(12px);
            border-radius: 24px; border: 1px solid rgba(56, 189, 248, 0.12);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        }
        .login-container h1 {
            text-align: center; font-size: 28px; font-weight: 800; margin-bottom: 6px;
        }
        .login-container h1 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .login-container .sub {
            text-align: center; color: #d1d5db; font-size: 14px; margin-bottom: 25px;
        }
        .error {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.2);
            color: #fca5a5; padding: 10px 14px; border-radius: 8px; font-size: 14px;
            margin-bottom: 16px; display: <?php echo $error ? 'block' : 'none'; ?>;
        }
        label {
            display: block; font-size: 14px; font-weight: 600; color: #d1d5db; margin-bottom: 4px;
        }

        /* ===== COMMON INPUT WRAPPER ===== */
        .input-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 16px; /* uniform padding */
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #38BDF8;
            background: rgba(56, 189, 248, 0.06);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.08);
        }

        /* ===== PASSWORD WRAPPER (with eye icon) ===== */
        .password-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .password-wrapper input {
            width: 100%;
            padding: 12px 45px 12px 16px; /* extra right padding for the icon */
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .password-wrapper input:focus {
            outline: none;
            border-color: #38BDF8;
            background: rgba(56, 189, 248, 0.06);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.08);
        }

        .password-wrapper .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.35);
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }

        .password-wrapper .toggle-password:hover {
            color: #38BDF8;
        }

        .login-container button {
            width: 100%; padding: 14px; border: none; border-radius: 10px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff; font-size: 16px; font-weight: 700;
            cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(56,189,248,0.2);
            margin-top: 0;
        }
        .login-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56,189,248,0.35);
        }
        .links {
            text-align: center; margin-top: 16px; color: #6b7280; font-size: 14px;
        }
        .links a {
            color: #38BDF8; text-decoration: none; font-weight: 600;
        }
        .links a:hover { text-decoration: underline; }

        @media (max-width: 480px) {
            .login-container { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>User <span>Login</span></h1>
        <p class="sub">Welcome back! Login to your account</p>
        <div class="error"><?php echo $error; ?></div>
        <form method="POST">
            <label for="email">Email Address</label>
            <div class="input-wrapper">
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span class="toggle-password" onclick="togglePassword()"><i class="fas fa-eye"></i></span>
            </div>

            <button type="submit"><i class="fas fa-sign-in-alt" style="margin-right: 10px;"></i>Login</button>
        </form>
        <div class="links">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
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