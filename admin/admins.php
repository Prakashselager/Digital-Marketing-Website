<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include('../includes/config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('DB connection failed.');
}

// Delete admin
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $check = $conn->query("SELECT COUNT(*) AS total FROM admin_users");
    $total = $check->fetch_assoc()['total'];
    if ($total > 1 && $id != $_SESSION['admin_id']) {
        $stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: admins.php');
    exit;
}

$admins = [];
$result = $conn->query("SELECT id, username, email, created_at FROM admin_users ORDER BY id ASC");
if ($result) {
    $admins = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins - BrandEve Admin</title>
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
            /* every card has a subtle background by default */
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.04);
            /* transition specific properties only — avoids jitter/shake */
            transition:
                background-color 0.25s ease,
                color 0.25s ease,
                border-color 0.25s ease,
                box-shadow 0.25s ease;
            will-change: background-color, color;
        }

        /* accent bar — absolutely positioned, never shifts the layout */
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

        /* Hover — every card lights up consistently */
        .sidebar .nav a:hover {
            background: rgba(56, 189, 248, 0.08);
            border-color: rgba(56, 189, 248, 0.25);
            color: #ffffff;
        }
        .sidebar .nav a:hover::before {
            transform: translateY(-50%) scaleY(0.6);
        }

        /* Active — strongest state */
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
           TABLE WRAPPER — no background (as requested)
           ========================================================= */
        .table-wrapper {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #93C5FD;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        tbody tr {
            transition: background-color 0.2s ease;
        }
        tbody tr:hover {
            background: rgba(56, 189, 248, 0.05);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            padding: 4px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background-color 0.2s ease, color 0.2s ease;
            display: inline-block;
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.22);
            color: #fca5a5;
        }

        .btn-add {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 50px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 8px 25px rgba(56, 189, 248, 0.2);
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56, 189, 248, 0.35);
        }

        .no-data {
            text-align: center;
            padding: 40px 0;
            color: #6b7280;
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
        }
        @media (max-width: 480px) {
            .main-content h1 { font-size: 24px; }
            .table-wrapper { padding: 12px; }
            table { font-size: 12px; }
            .btn-add { font-size: 14px; padding: 8px 18px; }
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="logo">Brand<span>Eve</span></div>
        <nav class="nav">
            <a href="index.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a href="admins.php" class="active"><i class="fas fa-users-cog"></i> <span>Admins</span></a>
            <a href="users.php"><i class="fas fa-user-friends"></i> <span>Users</span></a>
            <a href="deleted.php"><i class="fas fa-trash-alt"></i> <span>Deleted Enquiries</span></a>
            <a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </nav>
        <div class="logout-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        <h1>Admin <span>Users</span></h1>
        <p class="sub">Manage administrator accounts</p>

        <a href="settings.php" class="btn-add"><i class="fas fa-user-plus"></i> Add New Admin</a>

        <div class="table-wrapper">
            <?php if (empty($admins)): ?>
                <div class="no-data">No admins found.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo $admin['id']; ?></td>
                            <td><?php echo htmlspecialchars($admin['username']); ?></td>
                            <td><?php echo htmlspecialchars($admin['email']); ?></td>
                            <td><?php echo date('d M Y', strtotime($admin['created_at'])); ?></td>
                            <td>
                                <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                <a href="?delete=<?php echo $admin['id']; ?>" onclick="return confirm('Delete this admin?');" class="btn-delete"><i class="fas fa-trash"></i> Delete</a>
                                <?php else: ?>
                                <span style="color:#6b7280; font-size:13px;">(You)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>