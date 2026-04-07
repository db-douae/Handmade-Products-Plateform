<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/notification.php';

class NotificationController {
    private $notificationModel;

    public function __construct($pdo) {
        $this->notificationModel = new Notification($pdo);
    }

    public function markAsRead($id){
        $this->notificationModel->markAsRead($id);
    }

    public function getUserNotifications($userId){
        return $this->notificationModel->getByUserId($userId);
    }
    public function sendNotification($data){
        return $this->notificationModel->create($data);

    }

}

?>