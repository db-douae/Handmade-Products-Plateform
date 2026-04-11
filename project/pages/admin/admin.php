<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/AdminController.php';
require_once __DIR__ . '/../../app/controllers/NotificationController.php';
requireAdmin();
$adminController = new AdminController($pdo);
$notifController = new NotificationController($pdo);

// حذف مستخدم
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $adminController->deleteUser($_POST['user_id']);
}

$users = $adminController->getAllUsers();
?>
<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background: #3b2a1a;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 30px 20px;
        }
        .sidebar h2 { font-size: 18px; margin-bottom: 30px; color: #f5c97a; }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            border-bottom: 1px solid #5a3e2b;
        }
        .sidebar a:hover { color: #f5c97a; }

        /* Main content */
        .main {
            margin-left: 200px;
            padding: 30px;
        }
        h1 { font-size: 22px; margin-bottom: 20px; color: #3b2a1a; }

        /* Section */
        .section { display: none; }
        .section.active { display: block; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background: #3b2a1a;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:hover { background: #fdf6ec; }

        /* Delete button */
        .btn-delete {
            background: #c0392b;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete:hover { background: #a93226; }

        /* Notification badge */
        .badge {
            display: inline-block;
            background: #e67e22;
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 12px;
            margin-left: 6px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="#" onclick="showSection('users')">👥 Manage Users</a>
    <a href="#" onclick="showSection('notifications')">🔔 Notifications</a>
</div>

<!-- Main -->
<div class="main">

    <!-- Manage Users -->
    <div class="section active" id="users">
        <h1>👥 Manage Users</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['first_name']; ?></td>
                    <td><?php echo $user['last_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" name="delete_user" class="btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Notifications -->
    <div class="section" id="notifications">
        <h1>🔔 Notifications</h1>
        <table>
            <thead>
                <tr>
                    <th>From</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // نجيب إشعارات كل المستخدمين — نضيف method في AdminController لاحقاً
                // مؤقتاً نعرض رسالة
                ?>
                <tr>
                    <td colspan="5" style="text-align:center; color:#999;">
                        No notifications yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
function showSection(name) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(name).classList.add('active');
}
</script>

</body>
</html>