<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/OrderController.php';

startSession();
// منع الحرفي من إرسال طلب لنفسه

//requireRole('buyer');
/*
$customizeProductId = $_GET['id'] ?? null;
if (!$customizeProductId) {
    header("Location: /Handmade-Products-Plateform/project/pages/products.php");
    exit();
}

// نجيب اسم المنتج والحرفي
$stmt = $pdo->prepare("
    SELECT cp.*, p.product_name, s.shop_name, u.first_name, u.last_name
    FROM customize_products cp
    JOIN products p ON cp.product_id = p.id
    JOIN artisan_shops s ON p.shop_id = s.id
    JOIN artisans a ON a.shop_id = s.id
    JOIN users u ON u.id = a.id
    WHERE cp.id = ?
");
$stmt->execute([$customizeProductId]);
$customProduct = $stmt->fetch();

if (!$customProduct) {
    header("Location: /Handmade-Products-Plateform/project/pages/products.php");
    exit();
}

// معالجة الـ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderController = new OrderController($pdo);
    $orderController->placeCustomOrder();
}
*/
// نوعان: إما customize_product_id أو artisan_id
$customizeProductId = $_GET['id'] ?? null;
$artisanId          = $_GET['artisan_id'] ?? null;

if (!$customizeProductId && !$artisanId) {
    header("Location: /Handmade-Products-Plateform/project/pages/artisans.php");
    exit();
}

$artisanName = '';
$shopName    = '';

if ($customizeProductId) {
    // طلب customize منتج موجود
    $stmt = $pdo->prepare("
        SELECT cp.*, p.product_name, s.shop_name, u.first_name, u.last_name
        FROM customize_products cp
        JOIN products p ON cp.product_id = p.id
        JOIN artisan_shops s ON p.shop_id = s.id
        JOIN artisans a ON a.shop_id = s.id
        JOIN users u ON u.id = a.id
        WHERE cp.id = ?
    ");
    $stmt->execute([$customizeProductId]);
    $customProduct = $stmt->fetch();
    if (!$customProduct) {
        header("Location: /Handmade-Products-Plateform/project/pages/products.php");
        exit();
    }
    $artisanName = $customProduct['first_name'] . ' ' . $customProduct['last_name'];
    $shopName    = $customProduct['shop_name'];
    
} else {
    // طلب من صفر — نجيب اسم الحرفي فقط
    $stmt = $pdo->prepare("
        SELECT u.first_name, u.last_name, s.shop_name
        FROM artisans a
        JOIN users u ON u.id = a.id
        JOIN artisan_shops s ON s.id = a.shop_id
        WHERE a.id = ?
    ");
    $stmt->execute([$artisanId]);
    $artisanInfo = $stmt->fetch();
    if (!$artisanInfo) {
        header("Location: /Handmade-Products-Plateform/project/pages/artisans.php");
        exit();
    }
    $artisanName = $artisanInfo['first_name'] . ' ' . $artisanInfo['last_name'];
    $shopName    = $artisanInfo['shop_name'];
    $customProduct = null; // مافيهاش منتج
}

if ($artisanId && $artisanId == $_SESSION['userId']) {
    $_SESSION['error'] = "You cannot place an order with yourself.";
    header("Location: /Handmade-Products-Plateform/project/pages/artisans.php");
    exit();
}
// معالجة الـ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderController = new OrderController($pdo);
    if (isset($_POST['artisan_id'])) {
        // طلب من صفر — نرسله كـ notification فقط
        $orderController->placeCustomOrderFromScratch();
    } else {
        $orderController->placeCustomOrder();
    }
    
    }


?>
<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Customize your order</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>
<style>
    
    input, textarea,label, .form-control {
        text-align: left !important;
        direction: ltr !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    ::placeholder {
        text-align: left !important;
    }
</style>

    <!-- NAVBAR -->
   <?php include '../../layouts/header.php'; ?>

    <!-- CUSTOMIZE CARD -->
    <div class="customize-wrapper">
        <div class="customize-card">

            <div class="card-header">
                <h2>personalize your order</h2>
                <button onclick="window.location.href='../artisans.php';" class="btn-close">✕</button>
            </div>
<form method="POST">
<?php if ($customizeProductId): ?>
    <input type="hidden" name="customize_product_id" value="<?= $customizeProductId ?>">
<?php else: ?>
    <input type="hidden" name="artisan_id" value="<?= $artisanId ?>">
    <input type="hidden" name="order_type" value="from_scratch">
<?php endif; ?>
<input type="hidden" name="selected_color" value="<?= htmlspecialchars($_GET['color'] ?? '') ?>">
<input type="hidden" name="selected_size" value="<?= htmlspecialchars($_GET['size'] ?? '') ?>">

<div class="form-group">
    <label>the Artisan</label>
    <div class="artisan-row">
        <span class="artisan-name">
           <?= htmlspecialchars($artisanName) ?> — <?= htmlspecialchars($shopName) ?>
        </span>
    </div>
</div>

<div class="form-group">
    <label>Title/product Name</label>
    <input type="text" name="order_name" placeholder="Example: Custom pottery with specific colors">
</div>

<div class="form-group">
    <label>Your request template / Request content:</label>
    <textarea rows="5" name="order_definition" placeholder="Describe your request in detail..."></textarea>
</div>

<button type="submit" class="btn-next">→ Next</button>
</form>

        </div>
    </div>

    <!-- FOOTER -->
<?php include '../../layouts/footer.php'; ?>

</body>
</html>
