<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../controllers/NotificationController.php';
requireLogin();
$controller = new NotificationController($pdo);
$controller->clearRead();
?>
