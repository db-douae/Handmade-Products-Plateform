<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/session.php';
require_once __DIR__ . '/../app/controllers/shopController.php';

startSession();

$shopController = new ShopController($pdo);
$shops = $shopController->listShops();
?>
<!DOCTYPE html>
<!--hi-->
<html>
    <head>
        <title>Artisans</title>
        <meta name="viewoport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/Handmade-Products-Plateform/project/public/assets/css/artisans.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.0/css/all.css">
    </head>
    <body>
        <?php include '../layouts/header.php'; ?>
        <section class="after-header">
        <select id="sort-select-artisans">
         <option value="all">New to Old</option>
        <option value="interests">By Interests</option>
        </select>
       <div class="search-container">
            <input type="text" placeholder="search...">
            <img src="/Handmade-Products-Plateform/project/public/assets/images/icons/search-icon.png" class="search-icon">
        </div>
    </section>
    
    <section class="category">

        <input type="radio" name="tabs" id="tab1" checked class="tabs">
       <label for="tab1">All</label>

        <input type="radio" name="tabs" id="tab2" class="tabs">
        <label for="tab2">Pottery</label>

        <input type="radio" name="tabs" id="tab3" class="tabs">
        <label for="tab3">Weaving</label>

        <input type="radio" name="tabs" id="tab4"  class="tabs">
        <label for="tab4">Embroidery</label>

        <input type="radio" name="tabs" id="tab5" class="tabs">
        <label for="tab5">Traditional clothes</label>
        
        <input type="radio" name="tabs" id="tab6"  class="tabs">
        <label for="tab6">Handmade sweets and foods</label>
        
        <input type="radio" name="tabs" id="tab7"  class="tabs">
        <label for="tab7">jewellery</label>
        
        <input type="radio" name="tabs" id="tab8"  class="tabs">
        <label for="tab8">Wood</label>

        <input type="radio" name="tabs" id="tab9" class="tabs">
        <label for="tab9">Others</label>

    </section>

<hr style="border: 1px solid #876b5d;">

<section>
<?php 
$categoryToTab = [
    'pottery'                  => 'tab2',
    'weaving'                  => 'tab3',
    'embroidery'               => 'tab4',
    'traditional clothes'      => 'tab5',
    'handmade sweets and foods'=> 'tab6',
    'jewellery'                => 'tab7',
    'wood'                     => 'tab8',
    'others'                   => 'tab9',
];
?>
<div class="artisans-grid">
<?php foreach ($shops as $shop): 
    $tab = $categoryToTab[strtolower($shop['category_name'] ?? '')] ?? 'tab8';
?>
    <div class="artisan-card" data-tab="<?= $tab ?>">
        <div class="card-banner">
            <div class="avatar">
    <?php if (!empty($shop['profile_picture'])): ?>
        <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($shop['profile_picture']) ?>" 
             style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
    <?php else: ?>
        <?= strtoupper(substr($shop['first_name'], 0, 1)) ?>
    <?php endif; ?>
</div>
<br>
<br>
        </div>
        <div class="card-info">
            <h3><?= htmlspecialchars($shop['first_name'] . ' ' . $shop['last_name']) ?></h3>
            <p class="shop-name"><?= htmlspecialchars($shop['shop_name']) ?></p>
            <span class="category-name"><?= htmlspecialchars($shop['category_name'] ?? '') ?></span>
            <p class="bio"style="color:#ffff;"><?/*= htmlspecialchars($shop['description'] ?? '') */?>--</p>
           <div class="card-buttons">
    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == $shop['artisan_id']): ?>
        <a href="/Handmade-Products-Plateform/project/pages/shop/my-shop.php" class="btn-visit">My Shop</a>
    <?php else: ?>
        <a href="/Handmade-Products-Plateform/project/pages/shop/artisan-shop.php?id=<?= $shop['artisan_id'] ?>" class="btn-visit">Go to Shop</a>
        <a href="/Handmade-Products-Plateform/project/pages/orders/customize.php?artisan_id=<?= $shop['artisan_id'] ?>" class="btn-custom">Customize Order</a>
    <?php endif; ?>
</div>
        </div>
    </div>
<?php endforeach; ?>
</div>
</section>
<script>
// tabs
document.querySelectorAll('input[name="tabs"]').forEach(tab => {
    tab.addEventListener('change', () => {
        const selected = tab.id;
        document.querySelectorAll('.artisan-card').forEach(card => {
            card.style.display = (selected === 'tab1' || card.dataset.tab === selected) ? 'block' : 'none';
        });
    });
});

// search
document.querySelector('.search-container input').addEventListener('input', function() {
    const query = this.value.toLowerCase().trim();
    document.querySelectorAll('.artisan-card').forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const shop = card.querySelector('.shop-name').textContent.toLowerCase();
        card.style.display = (name.includes(query) || shop.includes(query)) ? 'block' : 'none';
    });
    if (query === '') {
        document.getElementById('tab1').checked = true;
        document.querySelectorAll('.artisan-card').forEach(card => card.style.display = 'block');
    }
});
document.getElementById('sort-select-artisans').addEventListener('change', function() {
    if (this.value !== 'interests') return;

    <?php 
    $userInterests = [];
    if (isset($_SESSION['userId'])) {
        $stmt = $pdo->prepare("SELECT interests FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['userId']]);
        $row = $stmt->fetch();
        if ($row && !empty($row['interests'])) {
            $userInterests = array_map('strtolower', array_map('trim', explode(',', $row['interests'])));
        }
    }
    ?>
    const interests = <?= json_encode($userInterests) ?>;

    document.querySelectorAll('.artisan-card').forEach(card => {
        const cat = card.querySelector('.category-name').textContent.toLowerCase().trim();
        card.style.display = interests.includes(cat) ? 'block' : 'none';
    });

    document.querySelectorAll('input[name="tabs"]').forEach(t => t.checked = false);
});
</script>

<div class="space"></div>

<footer>
        <?php include '../layouts/footer.php'; ?>
    </footer>

    </html>
