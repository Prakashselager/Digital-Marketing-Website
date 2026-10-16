<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include('../includes/config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed.');
}

/* ============================================================
   HANDLE ACTIONS FIRST (so we only need one connection)
   ============================================================ */

// Mark as read
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read'])) {
    $id = (int)$_POST['id'];
    $stmt = $conn->prepare("UPDATE enquiries SET status = 'read' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: index.php');
    exit;
}

// Soft delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("UPDATE enquiries SET deleted_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: index.php');
    exit;
}

/* ============================================================
   FETCH DATA
   ============================================================ */
$enquiries = [];
$result = $conn->query("SELECT * FROM enquiries WHERE deleted_at IS NULL ORDER BY created_at DESC");
if ($result) {
    $enquiries = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BrandEve</title>
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
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
            display: flex;
            background-color: #070b1a;
        }

        /* Fixed background via pseudo-element (smoother than background-attachment: fixed) */
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
           SIDEBAR (FIXED) — no layout shift, consistent backgrounds
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
                box-shadow 0.25s ease,
                transform 0.2s ease;
            will-change: background-color, color;
        }

        /* accent bar — absolutely positioned, so it never shifts the layout */
        .sidebar .nav a::before {
            content: '';
            position: absolute;
            left: -12px;               /* sits just outside the card edge */
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

        /* Hover — every card lights up the same way */
        .sidebar .nav a:hover {
            background: rgba(56, 189, 248, 0.08);
            border-color: rgba(56, 189, 248, 0.25);
            color: #ffffff;
        }
        .sidebar .nav a:hover::before {
            transform: translateY(-50%) scaleY(0.6);
        }

        /* Active — strongest state, matches hover but with full accent bar */
        .sidebar .nav a.active {
            background: rgba(56, 189, 248, 0.14);
            border-color: rgba(56, 189, 248, 0.5);
            color: #38BDF8;
            box-shadow: 0 0 24px -8px rgba(56, 189, 248, 0.5);
        }
        .sidebar .nav a.active::before {
            transform: translateY(-50%) scaleY(1);
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

        /* ---- STATS ---- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-box {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            will-change: transform;
        }
        .stat-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }

        .stat-box:nth-child(1) {
            border-color: #38BDF8;
            background: rgba(56, 189, 248, 0.06);
        }
        .stat-box:nth-child(2) {
            border-color: #34D399;
            background: rgba(52, 211, 153, 0.06);
        }
        .stat-box:nth-child(3) {
            border-color: #F472B6;
            background: rgba(244, 114, 182, 0.06);
        }
        .stat-box:nth-child(4) {
            border-color: #FBBF24;
            background: rgba(251, 191, 36, 0.06);
        }

        .stat-box .number {
            font-size: 36px;
            font-weight: 900;
            display: block;
            line-height: 1.2;
        }
        .stat-box:nth-child(1) .number {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .stat-box:nth-child(2) .number {
            background: linear-gradient(135deg, #34D399, #6EE7B7);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .stat-box:nth-child(3) .number {
            background: linear-gradient(135deg, #F472B6, #F9A8D4);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .stat-box:nth-child(4) .number {
            background: linear-gradient(135deg, #FBBF24, #FCD34D);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .stat-box .label {
            color: #d1d5db;
            font-size: 14px;
            margin-top: 4px;
        }

        /* ---- TABLE ---- */
        .table-wrapper {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
            padding: 20px;
        }
        .table-wrapper h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .table-wrapper th {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            color: #93C5FD;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-wrapper td {
            padding: 12px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            vertical-align: middle;
        }
        .table-wrapper tr:hover td {
            background: rgba(56, 189, 248, 0.03);
        }

        .status-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-unread {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
        }
        .status-read {
            background: rgba(52, 211, 153, 0.15);
            color: #6ee7b7;
        }

        .action-btn {
            padding: 4px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: inline-block;
            margin-right: 4px;
        }
        .btn-read {
            background: rgba(56, 189, 248, 0.1);
            color: #38BDF8;
        }
        .btn-read:hover {
            background: rgba(56, 189, 248, 0.22);
        }
        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.22);
        }

        .no-enquiries {
            text-align: center;
            padding: 40px 0;
            color: #6b7280;
            font-size: 16px;
        }

        .message-cell {
            max-width: 300px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* =========================================================
           RESPONSIVE
           ========================================================= */
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
            .main-content { margin-left: 0; max-width: 100%; padding: 20px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .table-wrapper { overflow-x: auto; padding: 12px; }
            .table-wrapper table { font-size: 12px; }
            .action-btn { font-size: 11px; padding: 3px 8px; }
            .message-cell { max-width: 150px; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .main-content h1 { font-size: 24px; }
            .message-cell { max-width: 100px; }
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="logo">Brand<span>Eve</span></div>
        <nav class="nav">
            <a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a href="admins.php"><i class="fas fa-users"></i> <span>Admins</span></a>
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
        <h1>Dashboard</h1>
        <p class="sub">Manage enquiries from your services</p>

        <?php
        $total = count($enquiries);
        $unread = 0;
        $read = 0;
        foreach ($enquiries as $e) {
            if ($e['status'] === 'unread') $unread++;
            else $read++;
        }
        ?>
        <div class="stats-grid">
            <div class="stat-box">
                <span class="number"><?php echo $total; ?></span>
                <span class="label">Total Enquiries</span>
            </div>
            <div class="stat-box">
                <span class="number"><?php echo $unread; ?></span>
                <span class="label">Unread</span>
            </div>
            <div class="stat-box">
                <span class="number"><?php echo $read; ?></span>
                <span class="label">Read</span>
            </div>
            <div class="stat-box">
                <span class="number"><?php echo count(array_unique(array_column($enquiries, 'service_name'))); ?></span>
                <span class="label">Services Queried</span>
            </div>
        </div>

        <div class="table-wrapper">
            <h2><i class="fas fa-envelope" style="margin-right: 10px; color: #38BDF8;"></i>All Enquiries</h2>
            <?php if (empty($enquiries)): ?>
                <div class="no-enquiries">No enquiries yet.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enquiries as $idx => $row): ?>
                        <tr>
                            <td><?php echo $idx + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td class="message-cell"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                            <td><span class="status-badge <?php echo $row['status'] === 'unread' ? 'status-unread' : 'status-read'; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                            <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <?php if ($row['status'] === 'unread'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="mark_read" class="action-btn btn-read"><i class="fas fa-check"></i> Read</button>
                                </form>
                                <?php endif; ?>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Move this enquiry to deleted?');" class="action-btn btn-delete"><i class="fas fa-trash"></i></a>
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