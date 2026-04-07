<?php 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/user.php';

class AdminController{
    private $adminModel ;

    public function __construct($pdo) {
        $this->adminModel = new User($pdo);
    }

    public function deleteUser($userId){
        $this->adminModel->deleteUser($userId);
    }

    public function getAllUsers() {
    return $this->adminModel->getAllUsers();
}


}

?>