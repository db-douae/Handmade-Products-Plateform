<?php
class Shop {
// Specifically for classics, it preserves the database connection.
    private $pdo;
// The constructor is called automatically when you create new Shop($pdo). It takes the PDO and stores it in $this->pdo so that you can use it in all functions.
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
// Add a new shop to the database, and return the **ID** of the row that was just added — useful for linking the shop to the artisan directly.
    public function createShop($shopName, $categoryName) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO artisan_shops (shop_name, category_name) VALUES (?, ?)"
        );
        $stmt->execute([$shopName, $categoryName]);
        return $this->pdo->lastInsertId();
    }

    public function updateShop($shopId, $shopName, $categoryName) {
        $stmt = $this->pdo->prepare(
            "UPDATE artisan_shops SET shop_name=?, category_name=? WHERE id=?"
        );
        $stmt->execute([$shopName, $categoryName, $shopId]);
    }

    public function getById($shopId) {
        $stmt = $this->pdo->prepare("SELECT * FROM artisan_shops WHERE id=?");
        $stmt->execute([$shopId]);
        return $stmt->fetch();
    }

/*    public function getByArtisanId($artisanId) {
        $stmt = $this->pdo->prepare(
            "SELECT s.* FROM artisan_shops s
             JOIN artisans a ON a.shop_id = s.id
             WHERE a.id = ?"
        );
        $stmt->execute([$artisanId]);
        return $stmt->fetch();
    }*/
    public function getByArtisanId($artisanId) {
    $stmt = $this->pdo->prepare(
        "SELECT s.*, u.first_name, u.last_name, u.profile_picture, a.description
         FROM artisan_shops s
         JOIN artisans a ON a.shop_id = s.id
         JOIN users u ON u.id = a.id
         WHERE a.id = ?"
    );
    $stmt->execute([$artisanId]);
    return $stmt->fetch();
}

    public function getAllCategories() {
        $stmt = $this->pdo->prepare(
            "SELECT DISTINCT category_name FROM artisan_shops WHERE category_name IS NOT NULL"
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

public function getAllShops() {
    $stmt = $this->pdo->prepare(
        "SELECT s.*, u.first_name, u.last_name, u.profile_picture, a.description, a.id as artisan_id
        FROM artisan_shops s
        JOIN artisans a ON a.shop_id = s.id
        JOIN users u ON u.id = a.id
        ORDER BY s.created_at DESC"
    );
    $stmt->execute();
    return $stmt->fetchAll();
}
}
?>
