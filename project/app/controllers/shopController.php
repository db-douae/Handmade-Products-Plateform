<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/Shop.php';
require_once __DIR__ . '/../models/product.php';

class ShopController {
    private $shopModel;
    private $productModel;

    public function __construct($pdo) {
        $this->shopModel    = new Shop($pdo);
        $this->productModel = new Product($pdo);
    }


    public function myShop() {
        startSession();
        requireRole('artisan');
        $artisanId = $_SESSION['userId'];
        $shop      = $this->shopModel->getByArtisanId($artisanId);
        $products  = $shop ? $this->productModel->getByShopId($shop['id']) : [];
        return [
            'shop'     => $shop,
            'products' => $products
        ];
    }


    public function getShop($artisanId) {
        $shop     = $this->shopModel->getByArtisanId($artisanId);
        $products = $shop ? $this->productModel->getByShopId($shop['id']) : [];
        return [
            'shop'     => $shop,
            'products' => $products
        ];
    }


    public function listShops() {
        return $this->shopModel->getAllShops();
    }


    public function updateShop() {
        startSession();
        requireRole('artisan');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $artisanId   = $_SESSION['userId'];
            $shop        = $this->shopModel->getByArtisanId($artisanId);
            $shopName    = trim($_POST['shop_name']);
            $categoryName = trim($_POST['category_name'] ?? '');

            $this->shopModel->updateShop($shop['id'], $shopName, $categoryName);
            $_SESSION['success'] = "Shop updated successfully!";
            header("Location: /Handmade-Products-Plateform/project/pages/shop/my-shop.php");
            exit();
        }
    }


    public function getCategories() {
        return $this->shopModel->getAllCategories();
    }
}
?>