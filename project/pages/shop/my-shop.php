<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/shopController.php';
require_once __DIR__ . '/../../app/controllers/ProductController.php';


//startSession();
requireLogin();
requireRole('artisan');

if (isset($_GET['delete'])) {
    $productController = new ProductController($pdo);
    $productController->deleteProduct($_GET['delete']);
}
$shopController = new ShopController($pdo);
$data     = $shopController->myShop();
$shop     = $data['shop'];
$products = $data['products'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Shop</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    
     <!-- NAVBAR -->
      <!--nav class="navbar">
     <div class="logo">Craftmen</div>
     <ul class="nav-links">
         <li><a href="#index.html">Home</a></li>
         <li><a href="#Artisans">Artisans</a></li>
         <li><a href="#Products">Products</a></li>
         <li><a href="#About">About</a></li>
         <li><a href="#Contact">Contact</a></li>
     </ul>
     <a href="#" class="btn-login">
         <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
             <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
             <circle cx="12" cy="7" r="4"/>
         </svg>
     </a>
 </nav-->
<?php include '../../layouts/header.php'; ?>
  <!-- MAIN LAYOUT -->
    <div class="shop-layout">

        <!-- SIDEBAR -->
        <aside class="shop-sidebar">
  <div class="sidebar-avatar">
    <?php if (!empty($shop['profile_picture'])): ?>
        <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($shop['profile_picture']) ?>" 
             style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
    <?php else: ?>
        <?= strtoupper(substr($shop['first_name'] ?? 'U', 0, 1)) ?>
    <?php endif; ?>
</div>
<h2 class="sidebar-name"><?= htmlspecialchars($shop['shop_name']) ?></h2>
<p class="sidebar-desc"><?= htmlspecialchars($shop['category_name'] ?? '') ?></p>

        

            <a href="/Handmade-Products-Plateform/project/pages/orders/Add-product.php" class="btn-add" style="width:100%; text-align:center; margin-top:16px; display:block;">
                + Add new product
            </a>

            <!--button class="btn-edit-shop" style="width:100%; margin-top:10px;">
                Edit Shop 
            </button-->
        </aside>

        <!-- PRODUCTS — Pinterest Grid -->
        <main class="shop-main">
            <h3 class="section-title" style="text-align:right; margin-bottom:16px;">my shop</h3>

          <?php foreach ($products as $product): ?>
<div class="masonry-card">
    <div class="masonry-img">
        <?php if ($product['image_product']): ?>
            <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($product['image_product']) ?>" alt="">
        <?php endif; ?>
    </div>
    <div class="product-info">
        <h4><?= htmlspecialchars($product['product_name']) ?></h4>
        <p><?= htmlspecialchars($product['price']) ?>DZD</p>
    </div>
    <div class="product-actions">
        <!--a href="Add-product.php?edit=<?= $product['id'] ?>" class="btn-edit-p">Edit</a-->
        <a href="?delete=<?= $product['id'] ?>" class="btn-delete" 
           onclick="return confirm('Delete this product?')">Delete</a>
    </div>
</div>
<?php endforeach; ?>
</div>
        </main>

    </div>

    <!-- FOOTER -->
<?php include '../../layouts/footer.php'; ?>

</body>
</html>
