<?php
class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addProduct($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO products (shop_id, product_name, price, product_info, image_product)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['shop_id'],
            $data['product_name'],
            $data['price'],
            $data['product_info'],
            $data['image_product']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateProduct($id, $data) {
        $stmt = $this->pdo->prepare(
            "UPDATE products SET product_name=?, price=?, product_info=?, image_product=?
             WHERE id=?"
        );
        $stmt->execute([
            $data['product_name'],
            $data['price'],
            $data['product_info'],
            $data['image_product'],
            $id
        ]);
    }

    public function deleteProduct($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id=?");
        $stmt->execute([$id]);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByShopId($shopId) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE shop_id=? ORDER BY created_at DESC");
        $stmt->execute([$shopId]);
        return $stmt->fetchAll();
    }

    public function getProductsByCategory($category = null) {
        if ($category) {
            $stmt = $this->pdo->prepare(
                "SELECT p.*, s.shop_name, s.category_name, u.first_name, u.last_name, cp.id as customize_product_id, a.id as artisan_id
                 FROM products p
                 JOIN artisan_shops s ON p.shop_id = s.id
                 JOIN artisans a ON a.shop_id = s.id
                 JOIN users u ON u.id = a.id
                 LEFT JOIN customize_products cp ON cp.product_id = p.id
                 WHERE s.category_name = ?
                 ORDER BY p.created_at DESC"
            );
            $stmt->execute([$category]);
        } else {
            $stmt = $this->pdo->prepare(
                "SELECT p.*, s.shop_name, s.category_name, u.first_name, u.last_name, cp.id as customize_product_id, a.id as artisan_id
                 FROM products p
                 JOIN artisan_shops s ON p.shop_id = s.id
                 JOIN artisans a ON a.shop_id = s.id
                 JOIN users u ON u.id = a.id
                 LEFT JOIN customize_products cp ON cp.product_id = p.id
                 ORDER BY p.created_at DESC"
            );
            $stmt->execute();
        }
        return $stmt->fetchAll();
    }
    public function getProductsByInterests($interests) {

    $placeholders = implode(',', array_fill(0, count($interests), '?'));
    $stmt = $this->pdo->prepare(
"SELECT p.*, s.shop_name, s.category_name, u.first_name, u.last_name, cp.id as customize_product_id, a.id as artisan_id
         FROM products p
         JOIN artisan_shops s ON p.shop_id = s.id
         JOIN artisans a ON a.shop_id = s.id
         JOIN users u ON u.id = a.id
         LEFT JOIN customize_products cp ON cp.product_id = p.id
         WHERE s.category_name IN ($placeholders)
         ORDER BY p.created_at DESC"
    );
    $stmt->execute($interests);
    return $stmt->fetchAll();
}
public function getLatestProducts($limit = 6) {
    $stmt = $this->pdo->prepare(
        "SELECT p.*, s.shop_name, s.category_name
         FROM products p
         JOIN artisan_shops s ON p.shop_id = s.id
         ORDER BY p.created_at DESC
         LIMIT ?"
    );
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}
}
?>
