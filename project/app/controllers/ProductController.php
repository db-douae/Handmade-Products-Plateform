<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/../models/Shop.php';

class ProductController {
    private $productModel;
    private $shopModel;
private $pdo;

public function __construct($pdo) {
    $this->pdo = $pdo;
    $this->productModel = new Product($pdo);
    $this->shopModel = new Shop($pdo);
}

    public function listProducts() {
        startSession();
        $category = $_GET['category'] ?? null;
        return $this->productModel->getProductsByCategory($category);
    }


    public function listByShop($shopId) {
        return $this->productModel->getByShopId($shopId);
    }


    public function addProduct() {
        startSession();
        requireRole('artisan');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shop = $this->shopModel->getByArtisanId($_SESSION['userId']);
$shopId = $shop['id'];
            $name     = trim($_POST['product_name']);
            $price = (float) $_POST['price'];
if (empty($price) || !is_numeric($price)) {
    $_SESSION['error'] = "Please enter a valid price!";
    header("Location: /Handmade-Products-Plateform/project/pages/orders/Add-product.php");
    exit();
}
            $info     = trim($_POST['product_info'] ?? '');
            $image    = null;


            if (isset($_FILES['image_product']) && $_FILES['image_product']['error'] === 0) {
                $file     = $_FILES['image_product'];
                $filename = uniqid() . '_' . basename($file['name']);
                $dest     = __DIR__ . '/../../public/uploads/' . $filename;
                move_uploaded_file($file['tmp_name'], $dest);
                $image = $filename;
            }

            $data = [
                'shop_id'      => $shopId,
                'product_name' => $name,
                'price'        => $price,
                'product_info' => $info,
                'image_product'=> $image
            ];

            $productId = $this->productModel->addProduct($data);

if (!empty($_POST['color']) || !empty($_POST['size']) || !empty($_POST['text_option'])) {
    $stmt = $this->pdo->prepare(
        "INSERT INTO customize_products (product_id, color, size, text, status) 
         VALUES (?, ?, ?, ?, 'available')"
    );
    $stmt->execute([
        $productId,
        $_POST['color'] ?? null,
        $_POST['size'] ?? null,
        $_POST['text_option'] ?? null
    ]);
}
            $_SESSION['success'] = "Product added successfully!";
            header("Location: /Handmade-Products-Plateform/project/pages/shop/my-shop.php");
            exit();
        }
    }


    public function updateProduct($productId) {
        startSession();
        requireRole('artisan');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $this->productModel->getById($productId);
            $image   = $product['image_product']; 

            if (isset($_FILES['image_product']) && $_FILES['image_product']['error'] === 0) {
                $file     = $_FILES['image_product'];
                $filename = uniqid() . '_' . basename($file['name']);
                $dest     = __DIR__ . '/../../public/uploads/' . $filename;
                move_uploaded_file($file['tmp_name'], $dest);
                $image = $filename;
            }

            $data = [
                'product_name'  => trim($_POST['product_name']),
                'price'         => $_POST['price'],
                'product_info'  => trim($_POST['product_info'] ?? ''),
                'image_product' => $image
            ];

            $this->productModel->updateProduct($productId, $data);
            $_SESSION['success'] = "Product updated successfully!";
            header("Location: /Handmade-Products-Plateform/project/pages/shop/my-shop.php");
            exit();
        }
    }


    public function deleteProduct($productId) {
        startSession();
        requireRole('artisan');
        $this->productModel->deleteProduct($productId);
        $_SESSION['success'] = "Product deleted successfully!";
        header("Location: /Handmade-Products-Plateform/project/pages/shop/my-shop.php");
        exit();
    }


    public function getProduct($productId) {
        return $this->productModel->getById($productId);
    }
    
    public function listProductsByInterests() {
    startSession();
    if (!isset($_SESSION['userId'])) return [];

    $stmt = $this->pdo->prepare("SELECT interests FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['userId']]);
    $row = $stmt->fetch();

    if (!$row || empty($row['interests'])) return [];

    $interests = array_map('trim', explode(',', $row['interests']));
    return $this->productModel->getProductsByInterests($interests);
}

}
?>
