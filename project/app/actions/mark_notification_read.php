<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
startSession();
require_once __DIR__ . '/../controllers/NotificationController.php';

requireLogin();
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('/tmp/mark_debug.txt', print_r($data, true) . ' userId:' . $_SESSION['userId']);
$controller = new NotificationController($pdo);
$controller->markAsRead($data['id']);
?>
