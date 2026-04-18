<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: /pages/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/Product.php';

$product_id   = (int)($_GET['product_id'] ?? 0);
$productModel = new Product();
$product      = $product_id ? $productModel->getById($product_id) : null;

if (!$product) {
    header('Location: /pages/products.php');
    exit;
}

$db = getDB();

// Load existing customize_product for this product
$stmt = $db->prepare("SELECT * FROM customize_products WHERE product_id = ?");
$stmt->execute([$product_id]);
$customize = $stmt->fetch();

$message = '';
$error   = '';

// Handle POST: save customization request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color  = trim($_POST['color'] ?? '');
    $size   = trim($_POST['size'] ?? '');
    $text   = trim($_POST['text'] ?? '');

    if (!$customize) {
        // Create customize_product entry
        $stmt = $db->prepare("
            INSERT INTO customize_products (product_id, color, size, text, status)
            VALUES (?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([$product_id, $color, $size, $text]);
        $customize_product_id = (int)$db->lastInsertId();
    } else {
        $customize_product_id = (int)$customize['id'];
        $stmt = $db->prepare("
            UPDATE customize_products SET color = ?, size = ?, text = ?, status = 'pending' WHERE id = ?
        ");
        $stmt->execute([$color, $size, $text, $customize_product_id]);
    }

    // Redirect to order placement
    header("Location: /pages/orders/costumize-product.php?customize_product_id=$customize_product_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تخصيص المنتج</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="container narrow">
    <h1>تخصيص المنتج</h1>

    <!-- Product Summary -->
    <div class="product-summary">
        <?php if ($product['image_product']): ?>
            <img src="<?= htmlspecialchars($product['image_product']) ?>" alt="">
        <?php endif; ?>
        <div>
            <h3><?= htmlspecialchars($product['product_name']) ?></h3>
            <p class="price"><?= number_format($product['price'], 2) ?> دج</p>
        </div>
    </div>

    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="POST" class="form-card">
        <div class="form-group">
            <label>اللون المطلوب</label>
            <input type="text" name="color" placeholder="مثال: أحمر، أزرق، بيج..."
                   value="<?= htmlspecialchars($customize['color'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>الحجم</label>
            <input type="text" name="size" placeholder="مثال: صغير، وسط، كبير، 40cm..."
                   value="<?= htmlspecialchars($customize['size'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>نص أو رسالة (إن وجدت)</label>
            <textarea name="text" rows="3" placeholder="نص تريد كتابته على المنتج..."><?= htmlspecialchars($customize['text'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">متابعة الطلب ←</button>
            <a href="/pages/products.php" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</main>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Customize your order</title>
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

    <!-- CUSTOMIZE CARD -->
    <div class="customize-wrapper">
        <div class="customize-card">

            <div class="card-header">
                <h2>personalize your order</h2>
                <button class="btn-close">✕</button>
            </div>

            <div class="form-group">
                <label>the Artisan</label>
                <div class="artisan-row">
                    <span class="artisan-name">Um Kamal — AlMasna3</span>
                    <button class="btn-remove">✕</button>
                </div>
            </div>

            <div class="form-group">
                <label>Title/product Name</label>
                <input type="text" placeholder="مثال: وعاء فخاري بألوان محددة">
            </div>

            <div class="form-group">
                <label>Your request template / Request content:</label>
                <textarea rows="5" placeholder="أشرح طلبك بالتفصيل — الألوان، الأبعاد، المواد، أي تفاصيل تريدها..."></textarea>
            </div>

            <div class="form-group">
                <label>Adding pictures</label>
                <input type="file" accept="image/*" id="img-input">
            </div>

            <button class="btn-next" onclick="window.location.href='CustomOrder.html'">
                → Next
            </button>

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
```

---
