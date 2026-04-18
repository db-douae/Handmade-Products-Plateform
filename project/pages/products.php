<?php
session_start();
require_once __DIR__ . '/../app/controllers/ProductController.php';

$controller = new ProductController();
$category   = $_GET['category'] ?? null;

// Fetch products
ob_start();
$controller->index();
$json     = ob_get_clean();
$response = json_decode($json, true);
$products = $response['products'] ?? [];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>products</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>

<main class="container">
    <h1>products</h1>

    <!-- Category Filter -->
    <div class="filters">
        <a href="/pages/products.php" class="btn <?= !$category ? 'active' : '' ?>">الكل</a>
        <?php
        require_once __DIR__ . '/../app/models/Shop.php';
        $shopModel  = new Shop();
        $categories = $shopModel->getAllCategories();
        foreach ($categories as $cat): ?>
            <a href="?category=<?= urlencode($cat) ?>" class="btn <?= $category === $cat ? 'active' : '' ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
        <?php if (empty($products)): ?>
            <p class="no-results">currently no available products.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <?php if ($product['image_product']): ?>
                        <img src="<?= htmlspecialchars($product['image_product']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <?php else: ?>
                        <div class="no-image">لا توجد صورة</div>
                    <?php endif; ?>

                    <div class="product-info">
                        <h3><?= htmlspecialchars($product['product_name']) ?></h3>
                        <p class="price"><?= number_format($product['price'], 2) ?> دج</p>
                        <p class="artisan">
                            بقلم: <?= htmlspecialchars($product['first_name'] . ' ' . $product['last_name']) ?>
                        </p>
                        <?php if (!empty($product['shop_name'])): ?>
                            <p class="shop"><?= htmlspecialchars($product['shop_name']) ?></p>
                        <?php endif; ?>
                        <div class="product-actions">
                            <a href="/pages/orders/Add-product.php?product_id=<?= $product['id'] ?>" class="btn btn-primary">اطلب الآن</a>
                            <a href="/pages/orders/customize.php?product_id=<?= $product['id'] ?>" class="btn btn-secondary">تخصيص</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>Products</title>
        <meta name="viewoport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/Handmade-Products-Plateform/project/public/assets/css/products.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.0/css/all.css">
    </head>
<body>

    <br>
    <h1></h1>
    <br>

    <header>
        <?php include '../layouts/header.php'; ?>
    </header>
    
    <section class="after-header">
        <select>
           <option>choice 1</option>
            <option><a href="login.html">choice 2</a></option>
        </select>
       <div class="search-container">
            <input type="text" placeholder="search...">
            <img src="search-icon.png" class="search-icon">
        </div>
    </section>

    <br>

    <section class="category">

        <input type="radio" name="tabs" id="tab1" checked class="tabs">
       <label for="tab1">tab 1</label>

        <input type="radio" name="tabs" id="tab2" class="tabs">
        <label for="tab2">tab 1</label>

        <input type="radio" name="tabs" id="tab3" class="tabs">
        <label for="tab3">tab 1</label>

        <input type="radio" name="tabs" id="tab4"  class="tabs">
        <label for="tab4">tab 1</label>

        <input type="radio" name="tabs" id="tab5"  class="tabs">
        <label for="tab5">tab 1</label>

        <input type="radio" name="tabs" id="tab6" class="tabs">
        <label for="tab6">tab 1</label>
        
        <input type="radio" name="tabs" id="tab7"  class="tabs">
        <label for="tab7">tab 1</label>

        <input type="radio" name="tabs" id="tab8" class="tabs">
        <label for="tab8">tab 1</label>

    </section>

    <br>
    <hr style="border: 1px solid #876b5d;">

    <section>
    <div class="container" id="content1">
        <div class="box"><img src="img1.jpg" onclick="openModal(this)">
            <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img2.jpg">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #f5f2ee;">-</i> Hand-painted Ceramic<br>
            <i style="color: #f5f2ee;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img3.jpg" onclick="openModal(this)">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #f5f2ee;">-</i> Hand-painted Ceramic<br>
            <i style="color: #f5f2ee;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img4.png" onclick="openModal(this)">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img5.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img6.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img7.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div></div>
        <div class="box"><img src="img8.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div></div>
    </div>
    <div class="container" id="content2">
        <div class="box"><img src="img1.jpg" onclick="openModal(this)">
            <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img2.jpg">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img3.jpg">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img4.png" onclick="openModal(this)">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
    </div>
    <script>
            document.querySelectorAll('input[name="tabs"]').forEach((tab, index) => {
              tab.addEventListener('change', () => {
               document.querySelectorAll('.container').forEach(c => c.style.display = 'none');
               document.querySelectorAll('.container')[index].style.display = 'block';
              });
            });

        // لإظهار الأول عند تحميل الصفحة
        document.querySelectorAll('.container').forEach(c => c.style.display = 'none');
        document.querySelectorAll('.container')[0].style.display = 'block';

    </script>

    <script>
        function openModal(img) {
          document.getElementById('modal-img').src = img.src;
          document.getElementById('overlay').classList.add('active');
        }

        document.getElementById('overlay').onclick = function() {
            this.classList.remove('active');
        }
        function closeModal() {
           document.getElementById('overlay').classList.remove('active');
        }
    </script>

    <div class="overlay" id="overlay">
      <div class="modal-content">
        <img id="modal-img">
        <div class="definition">
          <span onclick="closeModal()">✕</span>
           <br>
           <br>
          <h4 style="color: #2F1F1B;">Hand-painted Ceramic</h4>
           <hr>
           <br>
           <p style="color: #876b5d; font-size: x-large;">You should Log in to buy this.</p>
           <br>
           <button href="login.html">Log In</button>
        </div>
      </div>
   </div>
    </section>

    <footer>
        <?php include '../layouts/footer.php'; ?>
    </footer>

</body>

</html>
