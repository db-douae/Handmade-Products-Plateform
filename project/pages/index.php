<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/session.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';


$productController = new ProductController($pdo);
$products = $productController->listProducts();
$products = array_slice($products, 0, 6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  
  <title>Craftmen</title>
  <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@300;400&display=swap" rel="stylesheet"/>
</head>
<body>
<?php include '../layouts/header.php'; ?>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-text">
      <h1>Handcrafted<br/>with Passion</h1>
      <p>Discover unique artisan products made with care and tradition.</p>
      <a href="#products" class="btn-primary">Shop Now</a>
      <a href="artisans.php" class="btn-primary">best Artisans</a>
    </div>
    <div class="hero-image">
      <img src="/Handmade-Products-Plateform/project/public/assets/images/فخار قبايلي جزائري 🇩🇿.jpg" alt="Craftmen Hero"/>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section class="products" id="products">
    <h2 class="section-title">Our Products</h2>

    <!-- SWITCH TABS -->
    <!--div class="switch-tabs">
      <button class="tab active" data-category="all">All</button>
      <button class="tab" data-category="wood">Pottery</button>
      <button class="tab" data-category="leather">Weaving</button>
      <button class="tab" data-category="ceramic">Embroidery</button>
      <button class="tab" data-category="candles">Traditional clothes</button>
      <button class="tab" data-category="pottery">Handmade sweets and foods</button>
      <button class="tab" data-category="jewelery">jewelery</button>
      <button class="tab" data-category="weaving">Wood</button-->
      <!--button class="tab" data-category="Embroidery">Embroidery</button-->
      
    <!--/div-->
    <div class="switch-tabs">
  <button class="tab active" data-category="all">All</button>
  <?php 
  $categories = array_unique(array_column($products, 'category_name'));
  foreach ($categories as $cat): ?>
    <button class="tab" data-category="<?= htmlspecialchars($cat) ?>">
      <?= htmlspecialchars($cat) ?>
    </button>
  <?php endforeach; ?>
</div>

    <!-- PRODUCT GRID -->
<div class="product-grid">
  <?php foreach ($products as $product): ?>
    <div class="product-card" 
         data-category="<?= htmlspecialchars($product['category_name']) ?>"
         onclick="window.location.href='/Handmade-Products-Plateform/project/pages/orders/delivery-info.php?product_id=<?= $product['id'] ?>&type=normal'"
         style="cursor:pointer;">
      <div class="product-img">
        <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($product['image_product'] ?? '') ?>"
             alt="<?= htmlspecialchars($product['product_name']) ?>"/>
      </div>
      <div class="product-info">
        <h3><?= htmlspecialchars($product['product_name']) ?></h3>
        <p><?= htmlspecialchars($product['product_info']) ?></p>
        <div class="product-footer">
          <span class="price"><?= number_format($product['price'], 2) ?> DA</span>
          <button class="btn-primary small">Order Now</button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
  </section>

  <!-- FOOTER -->
<?php include '../layouts/footer.php'; ?>

  <script>
    const tabs = document.querySelectorAll('.tab');
    const cards = document.querySelectorAll('.product-card');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        const category = tab.dataset.category;
        cards.forEach(card => {
          if (category === 'all' || card.dataset.category.toLowerCase() === category.toLowerCase()) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  </script>

</body>
</html>
