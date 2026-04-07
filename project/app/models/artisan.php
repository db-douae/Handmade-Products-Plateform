<?php
class Artisan {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
public function findByUserId($userId){
        $stmt = $this->pdo->prepare("SELECT * FROM artisans WHERE id= ? ");
        $stmt->execute([$userId]);
        return $stmt->fetch();
}

public function create($userId, $shopId, $description){
        $stmt = $this->pdo->prepare(
        "INSERT INTO artisans (id, shop_id, description) 
         VALUES (?, ?, ?)"
    );
    $stmt->execute([
        $userId,
        $shopId,
        $description
    ]);
}

public function getShop($userId){
     $stmt = $this->pdo->prepare(
        "SELECT * FROM artisan_shops 
         JOIN artisans ON artisan_shops.id = artisans.shop_id 
         WHERE artisans.id = ?"
    );
    $stmt->execute([$userId]);
    return $stmt->fetch();
}
}
?>