<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';

$db = getDB();

// Fetch all artisans with shop info
$stmt = $db->query("
    SELECT a.id, a.description, a.created_at,
           u.first_name, u.last_name, u.email, u.interests,
           s.id as shop_id, s.shop_name, s.category_name,
           COUNT(p.id) as product_count
    FROM artisans a
    JOIN users u ON a.user_id = u.id
    LEFT JOIN artisan_shops s ON s.artisan_id = a.id
    LEFT JOIN products p ON p.artisan_id = a.id
    GROUP BY a.id
    ORDER BY a.created_at DESC
");
$artisans = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الحرفيون</title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>

<main class="container">
    <h1>لحرفيون</h1>

    <div class="artisans-grid">
        <?php if (empty($artisans)): ?>
            <p class="no-results">لا يوجد حرفيون مسجلون حالياً.</p>
        <?php else: ?>
            <?php foreach ($artisans as $artisan): ?>
                <div class="artisan-card">
                    <div class="artisan-avatar">
                        <?= strtoupper(substr($artisan['first_name'], 0, 1)) ?>
                    </div>
                    <div class="artisan-info">
                        <h3><?= htmlspecialchars($artisan['first_name'] . ' ' . $artisan['last_name']) ?></h3>

                        <?php if ($artisan['shop_name']): ?>
                            <p class="shop-badge"><?= htmlspecialchars($artisan['shop_name']) ?></p>
                            <p class="category"><?= htmlspecialchars($artisan['category_name']) ?></p>
                        <?php endif; ?>

                        <?php if ($artisan['description']): ?>
                            <p class="description"><?= htmlspecialchars($artisan['description']) ?></p>
                        <?php endif; ?>

                        <p class="product-count"><?= $artisan['product_count'] ?> منتج</p>

                        <?php if ($artisan['shop_id']): ?>
                            <a href="/pages/shop/artisan-shop.php?id=<?= $artisan['shop_id'] ?>" class="btn btn-primary">
                              visit store
                            </a>
                        <?php endif; ?>
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
        <title>Artisans</title>
        <meta name="viewoport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/project/public/assets/css/artisans.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.0/css/all.css">
    </head>
    <body>
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
    
    <section class="category">
  <input type="radio" name="tabs" id="tab1" checked class="tabs">
  <label for="tab1">All</label>

  <input type="radio" name="tabs" id="tab2" class="tabs">
  <label for="tab2">Wood</label>

  <input type="radio" name="tabs" id="tab3" class="tabs">
  <label for="tab3">Pottery</label>

  <input type="radio" name="tabs" id="tab4" class="tabs">
  <label for="tab4">Jewelry</label>

  <input type="radio" name="tabs" id="tab5" class="tabs">
  <label for="tab5">Weaving</label>

  <input type="radio" name="tabs" id="tab6" class="tabs">
  <label for="tab6">Candles</label>

  <input type="radio" name="tabs" id="tab7" class="tabs">
  <label for="tab7">Leather</label>

  <input type="radio" name="tabs" id="tab8" class="tabs">
  <label for="tab8">Other</label>
</section>

<hr style="border: 1px solid #876b5d;">

<section>
  <div class="artisans-grid" data-tab="tab2">
    <div class="artisan-card">
      <div class="card-banner">
        <img src="banner.jpg" alt="banner">
        <div class="avatar">
          <img src="avatar.jpg" alt="avatar">
        </div>
      </div>
      <div class="card-info">
        <h3>Karim A.</h3>
        <p class="shop-name">Atlas</p>
        <span class="category-name">Wood</span>
        <p class="bio">A skilled carpenter specializing in engraving and decorating wood.</p>
        <div class="card-buttons">
          <button class="btn-visit">Go to Shop</button>
          <button class="btn-custom">Customize Order</button>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
    document.querySelectorAll('input[name="tabs"]').forEach(tab => {
  tab.addEventListener('change', () => {
    const selected = tab.id;
    
    document.querySelectorAll('.artisan-card').forEach(card => {
      if (selected === 'tab1') {
        // tab1 = All، يظهر الكل
        card.style.display = 'block';
      } else if (card.dataset.tab === selected) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none';
      }
    });
  });
});
</script>
<footer>
        <?php include '../layouts/footer.php'; ?>
    </footer>

    </html>