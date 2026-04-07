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
            $stmt = $this->pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, profile_picture = ?, password = ?, email= ?, role = ? WHERE id = ?");
                $stmt->execute([
                    $data['first_name'],
                    $data['last_name'],
                    $data['profile_picture'],
                    $data['password'],
                    $data['email'],
                    $data['role'], $id
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

}
?>