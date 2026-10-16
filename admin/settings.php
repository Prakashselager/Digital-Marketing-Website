<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include('../includes/config.php');

$message = '';
$error = '';

/* ============================================================
   HANDLE ACTIONS
   ============================================================ */

// Update notification email in config.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_email'])) {
    $new_email = trim($_POST['admin_email']);
    if (!empty($new_email)) {
        $config_path = '../includes/config.php';
        if (file_exists($config_path) && is_writable($config_path)) {
            $content = file_get_contents($config_path);
            $content = preg_replace(
                "/define\('ADMIN_EMAIL',\s*'[^']*'\);/",
                "define('ADMIN_EMAIL', '$new_email');",
                $content
            );
            if (file_put_contents($config_path, $content)) {
                $message = 'Notification email updated successfully.';
            } else {
                $error = 'Failed to update config file. Check file permissions.';
            }
        } else {
            $error = 'Config file not found or not writable.';
        }
    }
}

// Add new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            $stmt = $conn->prepare("INSERT INTO admin_users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed);
            if ($stmt->execute()) {
                $message = "Admin '$username' created successfully.";
            } else {
                $error = 'Error: ' . $stmt->error;
            }
            $stmt->close();
            $conn->close();
        }
    }
}

// Change password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $username         = trim($_POST['username']);
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($new_password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            $error = 'Database connection failed.';
        } else {
            $check = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
            $check->bind_param("s", $username);
            $check->execute();
            $result = $check->get_result();

            if ($result->num_rows === 1) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
                $stmt->bind_param("ss", $hashed, $username);
                if ($stmt->execute()) {
                    $message = "Password for '$username' updated successfully.";
                } else {
                    $error = 'Failed to update password: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = 'Username not found.';
            }
            $check->close();
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
    <title>Settings - BrandEve Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ===== RESET & BASE ===== */
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
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
            display: flex;
            background-color: #070b1a;
        }

        /* Fixed background via pseudo-element — smoother than background-attachment: fixed */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            background: url('../assets/images/bg1.png') no-repeat center center;
            background-size: cover;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
              pointer-events: none;
        }

        /* =========================================================
           SIDEBAR — no layout shift, consistent card backgrounds
           ========================================================= */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: rgba(10, 10, 30, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-right: 1px solid rgba(56, 189, 248, 0.08);
            padding: 30px 0;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            flex-shrink: 0;
            z-index: 100;
        }

        .sidebar .logo {
            font-size: 24px;
            font-weight: 800;
            padding: 0 24px 30px;
            color: #ef5b05;
            border-bottom: 1px solid rgba(231, 107, 6, 0.08);
        }
        .sidebar .logo span {
            background: linear-gradient(135deg, #ef5b05, #e75f04);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar .nav {
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* ---- NAV ITEM ---- */
        .sidebar .nav a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #d1d5db;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
            transition:
                background-color 0.25s ease,
                color 0.25s ease,
                border-color 0.25s ease,
                box-shadow 0.25s ease;
            will-change: background-color, color;
        }

        /* accent bar — absolutely positioned, never shifts layout */
        .sidebar .nav a::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            width: 3px;
            height: 60%;
            background: #38BDF8;
            border-radius: 0 3px 3px 0;
            transform: translateY(-50%) scaleY(0);
            transform-origin: center;
            transition: transform 0.25s ease;
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.7);
        }

        .sidebar .nav a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
            transition: color 0.25s ease;
        }

        .sidebar .nav a span {
            white-space: nowrap;
        }

        /* Hover */
        .sidebar .nav a:hover {
            background: rgba(56, 189, 248, 0.08);
            border-color: rgba(56, 189, 248, 0.25);
            color: #ffffff;
        }
        .sidebar .nav a:hover::before {
            transform: translateY(-50%) scaleY(0.6);
        }

        /* Active */
        .sidebar .nav a.active {
            background: rgba(56, 189, 248, 0.14);
            border-color: rgba(56, 189, 248, 0.5);
            color: #38BDF8;
            box-shadow: 0 0 24px -8px rgba(56, 189, 248, 0.5);
        }
        .sidebar .nav a.active::before {
            transform: translateY(-50%) scaleY(1);
        }
        .sidebar .nav a.active i {
            color: #38BDF8;
        }

        /* ---- LOGOUT ---- */
        .sidebar .logout-link {
            margin-top: 20px;
            padding: 16px 12px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .sidebar .logout-link a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #f87171;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            border-radius: 10px;
            background: rgba(248, 113, 113, 0.05);
            border: 1px solid rgba(248, 113, 113, 0.12);
            transition:
                background-color 0.25s ease,
                color 0.25s ease,
                border-color 0.25s ease;
        }
        .sidebar .logout-link a:hover {
            background: rgba(248, 113, 113, 0.12);
            border-color: rgba(248, 113, 113, 0.35);
            color: #fca5a5;
        }

        /* =========================================================
           MAIN CONTENT
           ========================================================= */
        .main-content {
            flex: 1;
            padding: 40px;
            margin-left: 260px;
            min-width: 0;
        }
        .main-content h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .main-content h1 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .main-content .sub {
            color: #d1d5db;
            margin-bottom: 30px;
        }

        /* =========================================================
           CARDS — no background (matches the no-bg rule)
           ========================================================= */
        .card {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 30px;
            max-width: 700px;
        }
        .card h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .card h2 i {
            color: #38BDF8;
            margin-right: 10px;
        }
        .card p {
            color: #d1d5db;
            margin-bottom: 16px;
            font-size: 14px;
        }

        /* ---- Alert messages ---- */
        .message {
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.25);
            color: #6ee7b7;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            max-width: 700px;
        }
        .error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            max-width: 700px;
        }

        /* ---- Forms ---- */
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
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
            font-size: 15px;
            margin-bottom: 16px;
            transition: border-color 0.25s ease, background-color 0.25s ease;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }
        input:focus {
            outline: none;
            border-color: #38BDF8;
            background: rgba(56, 189, 248, 0.06);
        }
        button {
            padding: 12px 28px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 8px 25px rgba(56, 189, 248, 0.2);
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56, 189, 248, 0.35);
        }

        .back-link {
            display: inline-block;
            margin-top: 4px;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.25s ease;
        }
        .back-link:hover {
            color: #38BDF8;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar { width: 220px; }
            .main-content { margin-left: 220px; padding: 30px; }
        }
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid rgba(56, 189, 248, 0.08);
                padding: 16px 0;
            }
            .sidebar .logo { padding: 0 20px 16px; }
            .sidebar .nav {
                flex-direction: row;
                flex-wrap: wrap;
                padding: 0 12px;
                gap: 6px;
            }
            .sidebar .nav a {
                padding: 8px 14px;
                font-size: 13px;
                flex: 0 0 auto;
            }
            .sidebar .nav a::before { display: none; }
            .sidebar .nav a.active {
                box-shadow: inset 0 -3px 0 #38BDF8;
            }
            .sidebar .logout-link { margin-top: 10px; padding: 10px 12px 0; }
            .main-content {
                margin-left: 0;
                max-width: 100%;
                padding: 20px;
            }
            .card { padding: 20px; }
        }
        @media (max-width: 480px) {
            .main-content h1 { font-size: 24px; }
            .card h2 { font-size: 18px; }
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="logo">Brand<span>Eve</span></div>
        <nav class="nav">
            <a href="index.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a href="admins.php"><i class="fas fa-users-cog"></i> <span>Admins</span></a>
            <a href="users.php"><i class="fas fa-user-friends"></i> <span>Users</span></a>
            <a href="deleted.php"><i class="fas fa-trash-alt"></i> <span>Deleted Enquiries</span></a>
            <a href="settings.php" class="active"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </nav>
        <div class="logout-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        <h1>Admin <span>Settings</span></h1>
        <p class="sub">Manage notification email, admin accounts, and password</p>

        <?php if ($message): ?>
            <div class="message"><i class="fas fa-check-circle" style="margin-right: 8px;"></i><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error"><i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- ===== CARD 1: UPDATE NOTIFICATION EMAIL ===== -->
        <div class="card">
            <h2><i class="fas fa-envelope"></i> Notification Email</h2>
            <p>All enquiry notifications will be sent to this email address.</p>
            <form method="POST">
                <label for="admin_email">Admin Email Address</label>
                <input type="email" id="admin_email" name="admin_email"
                       value="<?php echo defined('ADMIN_EMAIL') ? htmlspecialchars(ADMIN_EMAIL) : ''; ?>" required>
                <button type="submit" name="update_email">
                    <i class="fas fa-save" style="margin-right: 8px;"></i>Update Email
                </button>
            </form>
        </div>

        <!-- ===== CARD 2: ADD NEW ADMIN ===== -->
        <div class="card">
            <h2><i class="fas fa-user-plus"></i> Add New Admin</h2>
            <p>Create a new admin account with username, email, and password.</p>
            <form method="POST" autocomplete="off">
                <label for="new_admin_username">Username</label>
                <input type="text" id="new_admin_username" name="username" placeholder="Enter username" required>

                <label for="new_admin_email">Email</label>
                <input type="email" id="new_admin_email" name="email" placeholder="Enter admin email" required>

                <label for="new_admin_password">Password</label>
                <input type="password" id="new_admin_password" name="password" placeholder="Min 6 characters" required>

                <button type="submit" name="add_admin">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i>Add Admin
                </button>
            </form>
        </div>

        <!-- ===== CARD 3: CHANGE PASSWORD ===== -->
        <div class="card">
            <h2><i class="fas fa-key"></i> Change Password</h2>
            <p>Update the password for an admin account.</p>
            <form method="POST" autocomplete="off">
                <label for="cp_username">Username</label>
                <input type="text" id="cp_username" name="username" placeholder="Enter username" required>

                <label for="cp_new_password">New Password</label>
                <input type="password" id="cp_new_password" name="new_password" placeholder="Min 6 characters" required>

                <label for="cp_confirm_password">Confirm Password</label>
                <input type="password" id="cp_confirm_password" name="confirm_password" placeholder="Re-enter new password" required>

                <button type="submit" name="change_password">
                    <i class="fas fa-sync-alt" style="margin-right: 8px;"></i>Change Password
                </button>
            </form>
        </div>

        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </main>

</body>
</html>