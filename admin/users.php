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

// Delete user
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: users.php');
    exit;
}

// Update user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = (int)$_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;

    if (!empty($username) && !empty($email)) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, mobile = ?, is_verified = ? WHERE id = ?");
        $stmt->bind_param("sssii", $username, $email, $mobile, $is_verified, $id);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header('Location: users.php');
    exit;
}

/* ============================================================
   FETCH USERS
   ============================================================ */
$users = [];
$result = $conn->query("SELECT id, username, email, mobile, is_verified, created_at FROM users ORDER BY id DESC");
if ($result) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - BrandEve Admin</title>
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

        .status-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-verified {
            background: rgba(52, 211, 153, 0.15);
            color: #6ee7b7;
        }
        .status-unverified {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
        }

        .action-btn {
            padding: 4px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
            display: inline-block;
            margin-right: 4px;
        }
        .btn-edit {
            background: rgba(56, 189, 248, 0.1);
            color: #38BDF8;
        }
        .btn-edit:hover {
            background: rgba(56, 189, 248, 0.22);
        }
        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }
        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.22);
        }

        .no-data {
            text-align: center;
            padding: 40px 0;
            color: #6b7280;
            font-size: 16px;
        }

        /* ===== MODAL ===== */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: rgba(10, 10, 30, 0.95);
            border-radius: 24px;
            border: 1px solid rgba(56, 189, 248, 0.15);
            padding: 40px 35px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            animation: modalIn 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }
        .modal-content h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .modal-content h2 span {
            background: linear-gradient(135deg, #38BDF8, #60A5FA);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .modal-content .sub {
            color: #d1d5db;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .modal-content label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 4px;
        }
        .modal-content input,
        .modal-content select {
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
        .modal-content input:focus,
        .modal-content select:focus {
            outline: none;
            border-color: #38BDF8;
            background: rgba(56, 189, 248, 0.06);
        }
        .modal-content .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .modal-content .checkbox-group input {
            width: auto;
            margin: 0;
            accent-color: #38BDF8;
        }
        .modal-content .checkbox-group label {
            margin: 0;
            cursor: pointer;
        }
        .modal-content .btn-save {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1E3A5F, #38BDF8);
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 8px 25px rgba(56, 189, 248, 0.2);
        }
        .modal-content .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(56, 189, 248, 0.35);
        }
        .modal-content .btn-cancel {
            width: 100%;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            background: transparent;
            color: #d1d5db;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.25s ease;
            margin-top: 10px;
        }
        .modal-content .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
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
            .modal-content { padding: 25px 20px; }
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
            <a href="users.php" class="active"><i class="fas fa-user-friends"></i> <span>Users</span></a>
            <a href="deleted.php"><i class="fas fa-trash-alt"></i> <span>Deleted Enquiries</span></a>
            <a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </nav>
        <div class="logout-link">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        <h1>Registered <span>Users</span></h1>
        <p class="sub">Manage all users registered on your website</p>

        <div class="table-wrapper">
            <?php if (empty($users)): ?>
                <div class="no-data">No users registered yet.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['mobile']); ?></td>
                            <td>
                                <span class="status-badge <?php echo $user['is_verified'] ? 'status-verified' : 'status-unverified'; ?>">
                                    <?php echo $user['is_verified'] ? 'Verified' : 'Unverified'; ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <button type="button"
                                    onclick="openEditModal(<?php echo $user['id']; ?>, <?php echo htmlspecialchars(json_encode($user['username'])); ?>, <?php echo htmlspecialchars(json_encode($user['email'])); ?>, <?php echo htmlspecialchars(json_encode($user['mobile'])); ?>, <?php echo (int)$user['is_verified']; ?>)"
                                    class="action-btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?');" class="action-btn btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <!-- ===== EDIT MODAL ===== -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit <span>User</span></h2>
            <p class="sub">Update user details</p>
            <form method="POST">
                <input type="hidden" id="edit_id" name="id">
                <label for="edit_username">Full Name</label>
                <input type="text" id="edit_username" name="username" required>
                <label for="edit_email">Email Address</label>
                <input type="email" id="edit_email" name="email" required>
                <label for="edit_mobile">Mobile Number</label>
                <input type="tel" id="edit_mobile" name="mobile" maxlength="10">
                <div class="checkbox-group">
                    <input type="checkbox" id="edit_verified" name="is_verified" value="1">
                    <label for="edit_verified">Email Verified</label>
                </div>
                <button type="submit" name="update_user" class="btn-save"><i class="fas fa-save" style="margin-right: 8px;"></i>Update User</button>
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // ===== EDIT MODAL FUNCTIONS =====
        function openEditModal(id, username, email, mobile, verified) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_mobile').value = mobile || '';
            document.getElementById('edit_verified').checked = verified === 1;
            document.getElementById('editModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Click outside modal to close
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Escape key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('editModal');
                if (modal.classList.contains('active')) {
                    closeEditModal();
                }
            }
        });
    </script>

</body>
</html>