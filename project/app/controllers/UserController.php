<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/artisan.php';

class UserController {
    private $userModel;
    private $artisanModel;
    
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->artisanModel = new Artisan($pdo);
    }

    public function upgradeToArtisan($userId, $shopId, $description){
    $this->userModel->updateRole($userId);
    $this->artisanModel->create($userId, $shopId, $description);      
    }

    public function getProfile($id){
        return $this->userModel->findById($id);
    }

    public function updateProfile($id, $data) {
    $this->userModel->updateProfile($id, $data);
    }
}

?>