<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

include('../includes/config.php');

if (!defined('DB_HOST') || !defined('DB_USER') || !defined('DB_PASS') || !defined('DB_NAME')) {
    die('Database configuration is missing. Please check config.php.');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            $stmt = $conn->prepare("SELECT id, password_hash FROM admin_users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                if (password_verify($password, $admin['password_hash'])) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Invalid username or password.';
                }
            } else {
                $error = 'Invalid username or password.';
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
    <title>Admin Login - BrandEve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
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
            background: url('../assets/images/bg1.png') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            overflow-x: hidden;
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
        .login-container .error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
            display: <?php echo $error ? 'block' : 'none'; ?>;
        }
        .login-container label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 4px;
        }

        /* ===== INPUT WRAPPER (for both fields) ===== */
        .input-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 16px;
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

        /* ===== PASSWORD FIELD WITH EYE ICON ===== */
        .password-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .password-wrapper input {
            width: 100%;
            padding: 12px 45px 12px 16px;
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
            color:blue;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }

        .password-wrapper .toggle-password:hover {
            color: #38BDF8;
        }

        .login-container button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(56, 189, 248, 0.2);
        }
        .login-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56, 189, 248, 0.35);
        }
        .login-container .links {
            text-align: center;
            margin-top: 14px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .login-container .links a {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .login-container .links a:hover {
            color: #38BDF8;
            text-decoration: underline;
        }
        .login-container .footer {
            text-align: center;
            margin-top: 16px;
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .login-container { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin <span>Login</span></h1>
        <p class="sub">BrandEve Solutions Dashboard</p>
        <div class="error"><?php echo $error; ?></div>
        <form method="POST">

            <!-- ===== USERNAME FIELD ===== -->
            <label for="username">Username</label>
            <div class="input-wrapper">
                <input type="text" id="username" name="username" placeholder="Enter username" required>
            </div>

            <!-- ===== PASSWORD FIELD WITH EYE ICON ===== -->
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <span class="toggle-password" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit"><i class="fas fa-lock" style="margin-right: 10px;"></i>Login</button>
        </form>
        <div class="links">
            <a href="forgot-password.php"><i class="fas fa-key" style="margin-right: 4px;"></i>Forgot Password?</a>
        </div>
        <div class="footer">Secure Admin Access</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('togglePassword');
            const input = document.getElementById('password');

            toggle.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.innerHTML = type === 'password'
                    ? '<i class="fas fa-eye"></i>'
                    : '<i class="fas fa-eye-slash"></i>';
            });
        });
    </script>

</body>
</html>