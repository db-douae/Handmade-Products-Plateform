<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/shopController.php';

//startSession();
requireLogin();

$artisanId = $_GET['id'] ?? null;
if (!$artisanId) {
    header("Location: /Handmade-Products-Plateform/project/pages/artisans.php");
    exit();
}

$shopController = new ShopController($pdo);
$data     = $shopController->getShop($artisanId);
$shop     = $data['shop'];
$products = $data['products'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artisan Shop</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    <!-- NAVBAR -->
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
<p class="sidebar-desc"><?= htmlspecialchars($shop['description'] ?? '') ?></p>

            <div class="sidebar-links">
                <a href="#" class="sidebar-link">Products</a>
            </div>

            <a href="/Handmade-Products-Plateform/project/pages/orders/customize.php?artisan_id=<?= htmlspecialchars($artisanId) ?>" class="btn-customize" style="width:100%; text-align:center; margin-top: 16px; display:block;">
    custom order
</a>

            <button class="btn-share" style="width:100%; margin-top:10px;" onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')">
                Share ↗
            </button>
        </aside>

        <!-- PRODUCTS — Pinterest Grid -->
        <main class="shop-main">
            <h3 class="section-title" style="text-align:right; margin-bottom:16px;">shop products</h3>

 <!--div class="masonry-grid">
 <?php foreach ($products as $product): ?>
    <div class="masonry-card">
        <div class="masonry-img">
            <?php if ($product['image_product']): ?>
                <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($product['image_product']) ?>" alt="">
            <?php endif; ?>
        </div>
        <div class="product-info">
            <h4><?= htmlspecialchars($product['product_name']) ?></h4>
            <p>$<?= htmlspecialchars($product['price']) ?></p>
        </div>
        
    </div>
<?php endforeach; ?>
</div-->
 <?php foreach ($products as $product): ?>
 <div class="masonry-grid">

    <div class="masonry-card">
        <div class="masonry-img">
            <?php if ($product['image_product']): ?>
                <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($product['image_product']) ?>" alt="">
                
            <?php endif; ?>
        </div>
        <div class="product-info">
    <h4><?= htmlspecialchars($product['product_name']) ?></h4>
    <p><?= htmlspecialchars($product['price']) ?>DZD</p>
    <a href="/Handmade-Products-Plateform/project/pages/orders/delivery-info.php?product_id=<?= $product['id'] ?>&type=normal" class="btn-customize">Order Now</a>
</div>
      
    </div>

  
</div>
<?php endforeach; ?>
        </main>

    </div>

    <!-- REVIEWS -->
    <!--div class="reviews-section">
        <h3 class="section-title">Customer's Reviews</h3>
        <div class="reviews-grid">
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-avatar">S</div>
                    <div class="reviewer-info">
                        <h4>Sara Med</h4>
                        <span class="stars">★★★★★</span>
                    </div>
                </div>
                <p>Beautiful craftsmanship! The vase looks amazing.</p>
            </div>
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-avatar">I</div>
                    <div class="reviewer-info">
                        <h4>Imane Imane</h4>
                        <span class="stars">★★★★★</span>
                    </div>
                </div>
                <p>Very good quality, fast delivery, highly recommended.</p>
            </div>
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-avatar">K</div>
                    <div class="reviewer-info">
                        <h4>Karim</h4>
                        <span class="stars">★★★★★</span>
                    </div>
                </div>
                <p>Amazing work and I received a small gift unexpectedly!</p>
            </div>
        </div>
    </div-->

    <!-- FOOTER -->
 <?php include '../../layouts/footer.php'; ?>

</body>
</html>
