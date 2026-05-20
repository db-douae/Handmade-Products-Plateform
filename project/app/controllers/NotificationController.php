<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/notification.php';
require_once __DIR__ . '/../models/notification.php';
require_once __DIR__ . '/../models/user.php';

class NotificationController {
    private $notificationModel;

    public function __construct($pdo) {
        $this->notificationModel = new Notification($pdo);
    }

    public function markAsRead($id){
           $userId = $_SESSION['userId'];
    $this->notificationModel->markAsRead($id, $userId);
    }

    public function getUserNotifications($userId){
        return $this->notificationModel->getByUserId($userId);
    }
    public function sendNotification($data){
    $data['date'] = date('Y-m-d H:i:s');
    return $this->notificationModel->create($data);
    }
    public function clearRead() {
    $user_id = $_SESSION['userId'];
    $this->notificationModel->deleteReadNotifications($user_id);
}

}

?>
