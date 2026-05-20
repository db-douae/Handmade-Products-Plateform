<?php

class User {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
public function findByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email= ? ");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

public function create($data) {
    $stmt = $this->pdo->prepare(
        "INSERT INTO users (first_name, last_name, email, password, role) 
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $data['password'],
        $data['role']
    ]);
}

public function updateProfile($id, $data){
            $stmt = $this->pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email= ? WHERE id = ?");
                $stmt->execute([
                    $data['first_name'],
                    $data['last_name'],
                    $data['email'],
                    $id
                ]);
    }

 public function updateInterests($id, $interests) {

    $stmt = $this->pdo->prepare("UPDATE users SET interests = ? WHERE id = ?");
    $stmt->execute([$interests, $id]);
}

public function findById($id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id= ? ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

public function updateRole($id) {
    $stmt = $this->pdo->prepare("UPDATE users SET role = 'artisan' WHERE id = ?");
    $stmt->execute([$id]);
}

public function getAllUsers(){
    $stmt = $this->pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll();
}

public function deleteUser($id){
    $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}
public function updatePassword($id, $newPassword) {
    $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$newPassword, $id]);
}
public function updateProfilePicture($id, $filename) {
    $stmt = $this->pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
    $stmt->execute([$filename, $id]);
}
public function getAllProducts() {
    $stmt = $this->pdo->prepare(
        "SELECT p.*, s.shop_name FROM products p 
         JOIN artisan_shops s ON p.shop_id = s.id
         ORDER BY p.created_at DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function deleteProduct($id) {
    $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

public function getAllNotifications() {
    $stmt = $this->pdo->prepare(
        "SELECT * FROM notifications ORDER BY date DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

public function deleteNotification($id) {
    $stmt = $this->pdo->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->execute([$id]);
}
}
?>
