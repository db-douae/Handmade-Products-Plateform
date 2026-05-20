<?php

require_once __DIR__ . '/../../app/config/database.php';    
require_once __DIR__ . '/../../app/helpers/session.php'; 
require_once __DIR__ . '/../../app/controllers/OrderController.php';
require_once __DIR__ . '/../../app/controllers/NotificationController.php';

requireLogin();
file_put_contents('/tmp/debug.txt', print_r($_POST, true));

$notifId = $_POST['notif_id'] ?? null;
$status  = $_POST['status'] ?? null;

if (!$notifId || !$status) exit('Missing data');

$notifStmt = $pdo->prepare("SELECT * FROM notifications WHERE id = ?");
$notifStmt->execute([$notifId]);
$notif = $notifStmt->fetch();

preg_match('/order_id:(\d+)/', $notif['message'], $matches);
$orderId = $matches[1] ?? null;

if ($orderId) {
    $controller = new OrderController($pdo);
    $controller->updateOrderStatus($orderId, $status);
}

$notifController = new NotificationController($pdo);
$notifController->markAsRead($notifId);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
