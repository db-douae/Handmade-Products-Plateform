<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: /pages/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../app/controllers/OrderController.php';
require_once __DIR__ . '/../../app/config/database.php';

$customize_product_id = (int)($_GET['customize_product_id'] ?? 0);

// Load customize product + product info
$db   = getDB();
$stmt = $db->prepare("
    SELECT cp.*, p.product_name, p.price, p.image_product
    FROM customize_products cp
    JOIN products p ON cp.product_id = p.id
    WHERE cp.id = ?
");
$stmt->execute([$customize_product_id]);
$customize = $stmt->fetch();

if (!$customize) {
    header('Location: /pages/products.php');
    exit;
}

$controller = new OrderController();
$message    = '';
$error      = '';
$order_id   = null;

// Handle POST: place the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_GET['customize_product_id'] = $customize_product_id; // pass to controller

    // Manually call placeCustomOrder
    $data = [
        'customize_product_id' => $customize_product_id,
        'order_name'           => trim($_POST['order_name'] ?? ''),
        'order_definition'     => trim($_POST['order_definition'] ?? ''),
    ];

    if (empty($data['order_name'])) {
        $error = 'اسم الطلب مطلوب';
    } else {
        require_once __DIR__ . '/../../app/models/Order.php';
        $orderModel = new Order();
        $order_id = $orderModel->placeCustomOrder(
            (int)$_SESSION['user_id'],
            $customize_product_id,
            $data['order_name'],
            $data['order_definition']
        );

        header("Location: /pages/orders/delivery-info.php?order_type=custom&order_id=$order_id");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد الطلب المخصص</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/header.php'; ?>

<main class="container narrow">
    <h1>تأكيد الطلب المخصص</h1>

    <!-- Customization Summary -->
    <div class="order-summary card">
        <h3>customise summary></h3>
        <?php if ($customize['image_product']): ?>
            <img src="<?= htmlspecialchars($customize['image_product']) ?>" alt="" style="max-height:150px;">
        <?php endif; ?>
        <p><strong>product</strong> <?= htmlspecialchars($customize['product_name']) ?></p>
        <p><strong>main price</strong> <?= number_format($customize['price'], 2) ?> دج</p>
        <?php if ($customize['color']): ?>
            <p><strong>color:</strong> <?= htmlspecialchars($customize['color']) ?></p>
        <?php endif; ?>
        <?php if ($customize['size']): ?>
            <p><strong>size:</strong> <?= htmlspecialchars($customize['size']) ?></p>
        <?php endif; ?>
        <?php if ($customize['text']): ?>
            <p><strong>text:</strong> <?= htmlspecialchars($customize['text']) ?></p>
        <?php endif; ?>
    </div>

    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <!-- Order Form -->
    <form method="POST" class="form-card">
        <div class="form-group">
            <label>Order Name*</label>
            <input type="text" name="order_name" required
                   placeholder="مثال: قلادة ذهبية مخصصة لعيد الأم">
        </div>

        <div class="form-group">
            <label>Added details</label>
            <textarea name="order_definition" rows="4"
                      placeholder="any details you would like to add to the artisan..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">confirm and send Order</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
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
    <title>customize order</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    <!-- NAVBAR -->
         <nav class="navbar">
        <div class="logo">Craftmen</div>
        <ul class="nav-links">
            <li><a href="#index.html">Home</a></li>
            <li><a href="#Artisans">Artisans</a></li>
            <li><a href="#Product">Products</a></li>
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

    <!-- CUSTOMIZE WRAPPER -->
    <div class="customize-wrapper">
        <div class="customize-card">

            <!-- HEADER -->
            <div class="card-header">
                <h2>Customise Order</h2>
                <button class="btn-close">✕</button>
            </div>

            <!-- BODY -->
            <div class="card-body">

                <!-- الجانب الأيسر -->
                <div class="card-left">

                    <!-- شبكة الصور -->
                    <div class="form-group">
                        <label>Available colors/Available shapes</label>
                        <div class="shapes-grid">
                            <div class="shape-item active">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item selected">
                                <img src="" alt="shape">
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                            <div class="shape-item">
                                <span>+</span>
                            </div>
                        </div>
                    </div>

                    <!-- اختيار المقاس -->
                    <div class="form-group">
                        <label>choose size</label>
                        <div class="sizes-row">
                            <button class="size-btn active">S</button>
                            <button class="size-btn">M</button>
                            <button class="size-btn">L</button>
                            <button class="size-btn">XL</button>
                            <button class="size-btn">XXL</button>
                            <button class="size-btn">...</button>
                        </div>
                    </div>

                    <!-- اختيار حجم ملف -->
                    <div class="form-group">
                        <label>choose product size</label>
                        <div class="size-product-row">
                            <select>
                                <option>420 x 103</option>
                                <option>500 × 200</option>
                                <option>300 × 300</option>

                            </select>
                            <span>في حالة المنتج يطلع عن نفسه</span>
                        </div>
                    </div>

                </div>

                <!-- الجانب الأيمن -->
                <div class="card-right">

                    <!-- Preview الصورة -->
                    <div class="preview-box">
                        <div class="preview-img">
                            <span>preview</span>
                        </div>
                    </div>

                    <!-- إضافة خلفية على منتج -->
                    <div class="form-group">
                        <label>Add product Backround</label>
                        <input type="file" accept="image/*">
                    </div>

                    <!-- النص الذي تريد إضافته -->
                    <div class="form-group">
                        <input type="text" placeholder="النص الذي تريد إضافته...">
                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer">
                <button class="btn-next" onclick="window.location.href='CustomOrder.html'">
                    → Next
                </button>
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

    <script>
        // اختيار شكل
        document.querySelectorAll('.shape-item').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.shape-item').forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
            });
        });

        // اختيار مقاس
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>

</body>
</html>