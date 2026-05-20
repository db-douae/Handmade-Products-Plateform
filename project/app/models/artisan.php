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

public function create($userId, $shopId, $description, $category_artisan){
        $stmt = $this->pdo->prepare(
        "INSERT INTO artisans (id, shop_id, description, category_artisan) 
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([
        $userId,
        $shopId,
        $description,
        $category_artisan
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

public function createShop($shopName, $categoryName) {
    $stmt = $this->pdo->prepare(
        "INSERT INTO artisan_shops (shop_name, category_name) VALUES (?, ?)"
    );
    $stmt->execute([$shopName, $categoryName]);
    return $this->pdo->lastInsertId();
}

}
?>