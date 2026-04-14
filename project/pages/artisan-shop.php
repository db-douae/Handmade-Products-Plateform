<?php
require_once __DIR__ . '/../../app/controllers/ShopController.php';
require_once __DIR__ . '/../../app/controllers/ProductController.php';

$shop_id = (int)($_GET['id'] ?? 1);

$shopCtrl    = new ShopController();
$productCtrl = new ProductController();

$shop     = $shopCtrl->show($shop_id);
$products = (new \app\models\Product())->getByShop($shop_id);
$stats    = $shopCtrl->stats($shop_id);

if (!$shop) {
    header('Location: /pages/artisans.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($shop['name']) ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar light">
    <div class="logo">Craftmen</div>
    <ul class="nav-links">
        <li><a href="/index.php">Home</a></li>
        <li><a href="/pages/artisans.php">Artisans</a></li>
        <li><a href="/pages/products.php">Products</a></li>
    </ul>
    <a href="#" class="btn-login">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
    </a>
</nav>

<div class="shop-layout">

    <!-- SIDEBAR -->
    <aside class="shop-sidebar">
        <div class="sidebar-avatar">
            <?= strtoupper(substr($shop['artisan_name'], 0, 1)) ?>
        </div>
        <h2 class="sidebar-name"><?= htmlspecialchars($shop['name']) ?></h2>
        <p class="sidebar-desc"><?= htmlspecialchars($shop['description'] ?? '') ?></p>
        <p style="font-size:12px; color:var(--gray); text-align:center;">
            📍 <?= htmlspecialchars($shop['location'] ?? '') ?>
        </p>

        <div style="display:flex; justify-content:center; gap:16px; margin:12px 0;
                    font-size:13px; color:var(--gray);">
            <span>⭐ <?= number_format($stats['avg_rating'], 1) ?></span>
            <span><?= $stats['total_products'] ?> products</span>
        </div>

        <a href="/pages/orders/customize.php?shop_id=<?= $shop_id ?>"
           class="btn-customize" style="width:100%; text-align:center; display:block;">
            طلب مخصص 🎨
        </a>

        <button class="btn-share" style="width:100%; margin-top:10px;"
                onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')">
            Share ↗
        </button>
    </aside>

    <!-- PRODUCTS -->
    <main class="shop-main">
        <h3 class="section-title" style="text-align:right; margin-bottom:16px;">Products</h3>

        <div class="masonry-grid">
            <?php foreach ($products as $p): ?>
            <div class="masonry-card <?= rand(0,1) ? 'tall' : '' ?>">
                <div class="masonry-img" style="<?= $p['main_image'] ? "background-image:url('/{$p['main_image']}');background-size:cover;" : '' ?>"></div>
                <div class="product-info">
                    <h4><?= htmlspecialchars($p['name']) ?></h4>
                    <p>$<?= number_format($p['price'], 2) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
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
                <li><a href="#">Artisans</a></li>
                <li><a href="#">Products</a></li>
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
    <title>Artisan Shop</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar light">
        <div class="logo">Craftmen</div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="#">Artisans</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
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
            <p class="sidebar-desc">حرفية متخصصة في صناعة المنتجات اليدوية التقليدية منذ أكثر من 10 سنوات، تعتمد على مواد طبيعية وتقنيات قديمة فطرية ومميزة</p>

            <div class="sidebar-links">
                <a href="#" class="sidebar-link">Products</a>
            </div>

            <a href="customize.html" class="btn-customize" style="width:100%; text-align:center; margin-top: 16px; display:block;">
               custom order
            </a>

            <button class="btn-share" style="width:100%; margin-top:10px;" onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')">
                Share ↗
            </button>
        </aside>

        <!-- PRODUCTS — Pinterest Grid -->
        <main class="shop-main">
            <h3 class="section-title" style="text-align:right; margin-bottom:16px;">shop products</h3>

            <div class="masonry-grid">

                <div class="masonry-card tall">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Terracotta Jar</h4>
                        <p>$19</p>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Ceramic Vase</h4>
                        <p>$31</p>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Clay Bowl Set</h4>
                        <p>$24</p>
                    </div>
                </div>

                <div class="masonry-card tall">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Painted Pot</h4>
                        <p>$17</p>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Ceramic Cup</h4>
                        <p>$12</p>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Clay Plate</h4>
                        <p>$22</p>
                    </div>
                </div>

                <div class="masonry-card tall">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Decorative Bowl</h4>
                        <p>$38</p>
                    </div>
                </div>

                <div class="masonry-card">
                    <div class="masonry-img"></div>
                    <div class="product-info">
                        <h4>Mini Vase</h4>
                        <p>$15</p>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <!-- REVIEWS -->
    <div class="reviews-section">
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