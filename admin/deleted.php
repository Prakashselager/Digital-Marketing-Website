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

/* ============================================================
   HANDLE ACTIONS FIRST (single connection)
   ============================================================ */

// Restore (undelete)
if (isset($_GET['restore']) && is_numeric($_GET['restore'])) {
    $id = (int)$_GET['restore'];
    $stmt = $conn->prepare("UPDATE enquiries SET deleted_at = NULL WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: deleted.php');
    exit;
}

// Permanently delete
if (isset($_GET['permanent_delete']) && is_numeric($_GET['permanent_delete'])) {
    $id = (int)$_GET['permanent_delete'];
    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: deleted.php');
    exit;
}

/* ============================================================
   FETCH DELETED ENQUIRIES
   ============================================================ */
$deleted = [];
$result = $conn->query("SELECT * FROM enquiries WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
if ($result) {
    $deleted = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted Enquiries - BrandEve Admin</title>
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
            vertical-align: middle;
        }
        tbody tr {
            transition: background-color 0.2s ease;
        }
        tbody tr:hover {
            background: rgba(56, 189, 248, 0.05);
        }

        .action-btn {
            padding: 4px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-right: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .btn-restore {
            background: rgba(52, 211, 153, 0.1);
            color: #6ee7b7;
        }
        .btn-restore:hover {
            background: rgba(52, 211, 153, 0.22);
            color: #a7f3d0;
        }
        .btn-permanent-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }
        .btn-permanent-delete:hover {
            background: rgba(239, 68, 68, 0.22);
            color: #fca5a5;
        }

        .no-data {
            text-align: center;
            padding: 40px 0;
            color: #6b7280;
            font-size: 16px;
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
            .action-btn { font-size: 11px; padding: 3px 8px; }
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
            <a href="deleted.php" class="active"><i class="fas fa-trash-alt"></i> <span>Deleted Enquiries</span></a>
            <a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </nav>
        <div class="logout-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        <h1>Deleted <span>Enquiries</span></h1>
        <p class="sub">Enquiries that have been soft-deleted (can be restored or permanently removed)</p>

        <div class="table-wrapper">
            <?php if (empty($deleted)): ?>
                <div class="no-data">No deleted enquiries.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deleted as $idx => $row): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars(substr($row['message'], 0, 30)) . (strlen($row['message']) > 30 ? '...' : ''); ?></td>
                            <td><?php echo date('d M Y H:i', strtotime($row['deleted_at'])); ?></td>
                            <td>
                                <a href="?restore=<?php echo $row['id']; ?>" class="action-btn btn-restore" onclick="return confirm('Restore this enquiry?');"><i class="fas fa-undo"></i> Restore</a>
                                <a href="?permanent_delete=<?php echo $row['id']; ?>" class="action-btn btn-permanent-delete" onclick="return confirm('Permanently delete this enquiry?');"><i class="fas fa-times-circle"></i> Permanent</a>
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