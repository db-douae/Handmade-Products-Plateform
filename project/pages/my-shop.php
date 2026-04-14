<?php
session_start();
require_once __DIR__ . '/../../app/controllers/ShopController.php';
require_once __DIR__ . '/../../app/controllers/ProductController.php';

$artisan_id = $_SESSION['user_id'] ?? 1; // غيري بعد ربط الـ auth

$shopCtrl    = new ShopController();
$productCtrl = new ProductController();

$shop     = $shopCtrl->myShop($artisan_id);
$products = $productCtrl->index();
$stats    = $shopCtrl->stats($shop['id']);

// معالجة الـ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_shop') {
        $result = $shopCtrl->update($shop['id']);
        if ($result['success']) {
            $shop = $shopCtrl->myShop($artisan_id);
        }
    }

    if ($action === 'delete_product') {
        $productCtrl->destroy((int)$_POST['product_id']);
        header('Location: my-shop.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Shop — <?= htmlspecialchars($shop['name']) ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar light">
    <div class="nav-right">
        <span class="shop-icon">🏪</span>
        <span class="shop-title"><?= htmlspecialchars($shop['name']) ?></span>
    </div>
    <button class="btn-edit-shop" onclick="document.getElementById('edit-modal').style.display='flex'">
        Edit Shop
    </button>
</nav>

<div class="shop-layout">

    <!-- SIDEBAR -->
    <aside class="shop-sidebar">
        <div class="sidebar-avatar">
            <?= strtoupper(substr($shop['name'], 0, 1)) ?>
        </div>
        <h2 class="sidebar-name"><?= htmlspecialchars($shop['name']) ?></h2>
        <p class="sidebar-desc"><?= htmlspecialchars($shop['description'] ?? '') ?></p>

        <!-- إحصائيات -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin:16px 0;">
            <div style="text-align:center; padding:10px; background:var(--light); border-radius:8px;">
                <div style="font-size:20px; font-weight:700;"><?= $stats['total_products'] ?></div>
                <div style="font-size:11px; color:var(--gray);">Products</div>
            </div>
            <div style="text-align:center; padding:10px; background:var(--light); border-radius:8px;">
                <div style="font-size:20px; font-weight:700;"><?= $stats['total_orders'] ?></div>
                <div style="font-size:11px; color:var(--gray);">Orders</div>
            </div>
            <div style="text-align:center; padding:10px; background:var(--light); border-radius:8px;">
                <div style="font-size:20px; font-weight:700;">⭐ <?= number_format($stats['avg_rating'], 1) ?></div>
                <div style="font-size:11px; color:var(--gray);">Rating</div>
            </div>
            <div style="text-align:center; padding:10px; background:var(--light); border-radius:8px;">
                <div style="font-size:16px; font-weight:700;">$<?= number_format($stats['total_revenue'], 0) ?></div>
                <div style="font-size:11px; color:var(--gray);">Revenue</div>
            </div>
        </div>

        <a href="/pages/orders/add-product.php" class="btn-add"
           style="width:100%; text-align:center; display:block;">
            + Add new product
        </a>
    </aside>

    <!-- PRODUCTS -->
    <main class="shop-main">
        <h3 class="section-title" style="text-align:right; margin-bottom:16px;">منتجات متجري</h3>

        <div class="masonry-grid">
            <?php foreach ($products as $p): ?>
            <div class="masonry-card">
                <div class="masonry-img" style="<?= $p['main_image'] ? "background-image:url('/{$p['main_image']}');background-size:cover;" : '' ?>"></div>
                <div class="product-info">
                    <h4><?= htmlspecialchars($p['name']) ?></h4>
                    <p>$<?= number_format($p['price'], 2) ?></p>
                </div>
                <div class="product-actions">
                    <a href="/pages/orders/add-product.php?edit=<?= $p['id'] ?>" class="btn-edit-p">Edit ✏️</a>
                    <form method="POST" style="flex:1" onsubmit="return confirm('Delete this product?')">
                        <input type="hidden" name="action" value="delete_product">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button type="submit" class="btn-delete" style="width:100%">Delete 🗑️</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

</div>

<!-- EDIT SHOP MODAL -->
<div id="edit-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);
     align-items:center; justify-content:center; z-index:999;">
    <div style="background:white; border-radius:12px; padding:32px; width:90%; max-width:480px;">
        <h3 style="margin-bottom:20px;">Edit Shop</h3>
        <form method="POST">
            <input type="hidden" name="action" value="update_shop">
            <div class="form-group">
                <label>Shop Name</label>
                <input type="text" name="shop_name" value="<?= htmlspecialchars($shop['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="shop_description" rows="3"><?= htmlspecialchars($shop['description'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="shop_location" value="<?= htmlspecialchars($shop['location'] ?? '') ?>">
            </div>
            <div style="display:flex; gap:8px; margin-top:16px;">
                <button type="submit" class="btn-add" style="flex:1">Save ✓</button>
                <button type="button" onclick="document.getElementById('edit-modal').style.display='none'"
                        class="btn-edit-shop" style="flex:1">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-top">
        <div class="footer-col">
            <h4>Quick links</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Artisans</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Contact info</h4>
            <ul>
                <li><a href="#">+213-783 45 23 59</a></li>
                <li><a href="#">contact@logo.com</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 Craftmen. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Shop</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    
     <!-- NAVBAR -->
      <nav class="navbar">
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
 </nav>

  <!-- MAIN LAYOUT -->
    <div class="shop-layout">

        <!-- SIDEBAR -->
        <aside class="shop-sidebar">
            <div class="sidebar-avatar">U</div>
            <h2 class="sidebar-name">Um Kamal</h2>
            <p class="sidebar-desc">حرفية متخصصة في السيراميك والفخار منذ 15 عاماً</p>

        

            <a href="Add-product.html" class="btn-add" style="width:100%; text-align:center; margin-top:16px; display:block;">
                + Add new product
            </a>

            <button class="btn-edit-shop" style="width:100%; margin-top:10px;">
                Edit Shop 
            </button>
        </aside>

        <!-- PRODUCTS — Pinterest Grid -->
        <main class="shop-main">
            <h3 class="section-title" style="text-align:right; margin-bottom:16px;">my shop</h3>

            <div class="masonry-grid">

                <div class="masonry-card tall">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Terracotta Jar</h4>
                        <p>$19</p>
                    </div>
                    <div class="product-actions">
                        <button class="btn-edit-p">Edit </button>
                        <button class="btn-delete">Delete </button>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Ceramic Vase</h4>
                        <p>$31</p>
                    </div>
                    <div class="product-actions">
                        <button class="btn-edit-p">Edit </button>
                        <button class="btn-delete">Delete </button>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Clay Bowl Set</h4>
                        <p>$42</p>
                    </div>
                    <div class="product-actions">
                        <button class="btn-edit-p">Edit </button>
                        <button class="btn-delete">Delete </button>
                    </div>
                </div>

                <div class="masonry-card tall">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Painted Pot</h4>
                        <p>$17</p>
                    </div>
                    <div class="product-actions">
                        <button class="btn-edit-p">Edit </button>
                        <button class="btn-delete">Delete </button>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-top">
            <div class="footer-col">
                <h4>Quick links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Artisans</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Extra link</h4>
                <ul>
                    <li><a href="#">my account</a></li>
                    <li><a href="#">my order</a></li>
                    <li><a href="#">my favorite</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Location</h4>
                <ul>
                    <li><a href="#">Algeria</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact info</h4>
                <ul>
                    <li><a href="#">+213-783 45 23 59</a></li>
                    <li><a href="#">contact@logo.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Craftmen. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>