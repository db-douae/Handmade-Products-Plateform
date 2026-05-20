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

    public function upgradeToArtisan($userId, $shopName, $categoryName, $description) {
         $user = $this->userModel->findById($userId);
             if ($user['role'] === 'artisan') {
        $_SESSION['error'] = "You are already an artisan!";
        return;
    }
        
$shopId = $this->artisanModel->createShop($shopName, $categoryName);
         $this->userModel->updateRole($userId);
         $this->artisanModel->create($userId, $shopId, $description, $categoryName);
$_SESSION['role'] = 'artisan';
    $_SESSION['success'] = "You are now an artisan!";
    }

    public function getProfile($id){
        return $this->userModel->findById($id);
    }

    public function updateProfile($id, $data) {
    $this->userModel->updateProfile($id, $data);
    }

    public function changePassword($id, $oldPassword, $newPassword, $rePassword) {
    $user = $this->userModel->findById($id);
    

    if (!password_verify($oldPassword, $user['password'])) {
        $_SESSION['error'] = "Old password is incorrect!";
        return;
    }
    

    if ($newPassword !== $rePassword) {
        $_SESSION['error'] = "Passwords do not match!";
        return;
    }

    if (strlen($newPassword) < 8) {
    $_SESSION['error'] = "Password must be at least 8 characters!";
    return;
}
    

    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $this->userModel->updatePassword($id, $hashed);
    $_SESSION['success'] = "Password changed successfully!";
}

public function deleteAccount($id, $password) {
    $user = $this->userModel->findById($id);
    
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Wrong password!";
        return;
    }
    
    $this->userModel->deleteUser($id);
    logoutUser();
}
public function updateProfilePicture($id) {
    if (isset($_FILES['avatarInput']) && $_FILES['avatarInput']['error'] == 0) {
        $file = $_FILES['avatarInput'];
        $filename = uniqid() . '_' . basename($file['name']);
        $destination = __DIR__ . '/../../public/uploads/' . $filename;
        move_uploaded_file($file['tmp_name'], $destination);
        $this->userModel->updateProfilePicture($id, $filename);
    }
}

}

?>