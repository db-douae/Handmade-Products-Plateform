<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/session.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/shopController.php';


startSession();
$shopController = new ShopController($pdo);
$shops = $shopController->listShops();

$productController = new ProductController($pdo);
$category = $_GET['category'] ?? null;
$products = $productController->listProducts();
$productsByInterests = $productController->listProductsByInterests();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Products</title>
        <meta name="viewoport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/Handmade-Products-Plateform/project/public/assets/css/products.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.0/css/all.css">
    </head>
<body>
<?php include '../layouts/header.php'; ?>
    <section class="after-header">
        <select id="sort-select">
   <option value="all">New to Old</option>
   <option value="interests">By Interests</option>
   <option value="low">Lower to Higher price</option>
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
        <label href="#Pottery" for="tab2">Pottery</label>

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
    <div class="container" id="interests-container" style="display:none;">
    <?php if (empty($productsByInterests)): ?>
        <p style="text-align:center; color:#876b5d;">No products match your interests.</p>
    <?php else: ?>
        <?php foreach ($productsByInterests as $product): ?>
        <div class="box" onclick="openModal(
            '<?= htmlspecialchars($product['image_product'] ?? '') ?>',
            '<?= htmlspecialchars($product['product_name']) ?>',
            '<?= htmlspecialchars($product['price']) ?>',
            '<?= htmlspecialchars($product['first_name'] . ' ' . $product['last_name']) ?>',
            '<?= htmlspecialchars($product['product_info'] ?? '') ?>', 
            <?= $product['id'] ?>,
            <?= $product['customize_product_id'] ?? 'null' ?>,
            <?= $product['artisan_id'] ?>
        )">
            <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($product['image_product'] ?? '') ?>">
            <div class="product">
                <p style="font-size: 16px;">
                    <?= htmlspecialchars($product['product_name']) ?><br>
                    <b style="color: #876b5d;"><?= htmlspecialchars($product['price']) ?>DZD</b>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php 
$categories = ['all', 'Pottery', 'Weaving', 'Embroidery', 'Traditional clothes', 'Handmade sweets and foods', 'jewellery', 'Wood', 'Others'];
foreach ($categories as $index => $cat):
    $contentId = 'content' . ($index + 1);
?>
<div class="container" id="<?= $contentId ?>">
    <?php foreach ($products as $product): ?>
        <?php if ($cat === 'all' || strtolower($product['category_name']) === strtolower($cat)): ?>
        <div class="box" onclick="openModal(
    '<?= htmlspecialchars($product['image_product'] ?? '') ?>',
    '<?= htmlspecialchars($product['product_name']) ?>',
    '<?= htmlspecialchars($product['price']) ?>',
    '<?= htmlspecialchars($product['first_name'] . ' ' . $product['last_name']) ?>',
    '<?= htmlspecialchars($product['product_info'] ?? '') ?>', 
    <?= $product['id'] ?>,
    <?= $product['customize_product_id'] ?? 'null' ?>,
    <?= $product['artisan_id'] ?>
)">
            <img src="/Handmade-Products-Plateform/project/public/uploads/<?= htmlspecialchars($product['image_product'] ?? '') ?>">
            <div class="product">
                <p style="font-size: 16px;">
                    <?= htmlspecialchars($product['product_name']) ?><br>
                    <b style="color: #876b5d;"><?= htmlspecialchars($product['price']) ?>DZD</b>
                    
                </p>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>

    <script>
const categoryContainers = Array.from(document.querySelectorAll('.container:not(#interests-container)'));


categoryContainers.forEach(c => c.style.display = 'none');
categoryContainers[0].style.display = 'block';

// tabs
document.querySelectorAll('input[name="tabs"]').forEach((tab, index) => {
    tab.addEventListener('change', () => {
        document.getElementById('interests-container').style.display = 'none';
        document.getElementById('sort-select').value = 'all';
        categoryContainers.forEach(c => c.style.display = 'none');
        categoryContainers[index].style.display = 'block';
    });
});

// select
document.getElementById('sort-select').addEventListener('change', function() {
    const val = this.value;
    if (val === 'interests') {
        categoryContainers.forEach(c => c.style.display = 'none');
        document.getElementById('interests-container').style.display = 'block';
        document.querySelectorAll('input[name="tabs"]').forEach(t => t.checked = false);
    } else if (val === 'low') {
        document.getElementById('interests-container').style.display = 'none';
        document.getElementById('tab1').checked = true;
        categoryContainers.forEach((c, i) => c.style.display = i === 0 ? 'block' : 'none');

        const allContainer = categoryContainers[0];
        const boxes = Array.from(allContainer.querySelectorAll('.box'));
        boxes.sort((a, b) => {
            const priceA = parseFloat(a.querySelector('.product p b').textContent.replace('$', ''));
            const priceB = parseFloat(b.querySelector('.product p b').textContent.replace('$', ''));
            return priceA - priceB;
        });
        boxes.forEach(box => allContainer.appendChild(box));
    } else {
        document.getElementById('interests-container').style.display = 'none';
        document.getElementById('tab1').checked = true;
        categoryContainers.forEach((c, i) => {
            c.style.display = i === 0 ? 'block' : 'none';
        });
    }
});
document.querySelector('.search-container input').addEventListener('input', function() {
    const query = this.value.toLowerCase().trim();

    document.getElementById('interests-container').style.display = 'none';
    document.getElementById('sort-select').value = 'all';

    if (query === '') {
        categoryContainers.forEach((c, i) => {
            c.style.display = i === 0 ? 'block' : 'none';
        });
        document.querySelectorAll('.box').forEach(box => box.style.display = 'block');
        document.getElementById('tab1').checked = true;
        return;
    }

    categoryContainers.forEach((c, i) => c.style.display = i === 0 ? 'block' : 'none');
    document.querySelectorAll('.container:not(#interests-container) .box').forEach(box => {
        const name = box.querySelector('.product p').textContent.toLowerCase();
        box.style.display = name.includes(query) ? 'block' : 'none';
    });
});

    </script>
     <div class="overlay" id="overlay">
      <div class="modal-content">
        <img id="modal-img">
        <div class="definition">
          <span onclick="closeModal()">✕</span>
           <br>
           <div class="artisan">
            <br>
            <!--div class="pfp-artisan">
            <?php if (!empty($shop['profile_picture'])): ?>
            <img src="<?= htmlspecialchars($shop['profile_picture']) ?>">
            <?php endif; ?>
            </div-->
            <p></p>
           </div>
           <br>
          <h4 style="color: #2F1F1B;"></h4>
          <p class="price"><b></b></p>
          <p class="product-info" style="color: #555; font-size: 14px;"></p> 
           <hr> 
           
           <div class="buttons">
           
           <button><a href="#" class="btn-shop">Go to Shop</a></button>
           
           <button><a href="#" class="btn-order">Normal Order</a></button>
           <button><a href="#" class="btn-customize-order">Customize Product</a></button>
          
           
           <br></div>        
           
        </div>
      </div>
   </div>
    <script>
const currentUserId = <?= $_SESSION['userId'] ?? 'null' ?>;
</script>

    <script>
function openModal(img, name, price, artisan,productInfo, productId, customizeProductId, artisanId) {
console.log('artisanId:', artisanId, 'currentUserId:', currentUserId); // ← هنا
    document.getElementById('modal-img').src = 
        '/Handmade-Products-Plateform/project/public/uploads/' + img;
    document.querySelector('.definition h4').textContent = name;
    document.querySelector('.price b').textContent =  price + 'DZD';
    document.querySelector('.artisan p').textContent = artisan;
    document.getElementById('overlay').dataset.productId = productId;
  
    document.getElementById('overlay').classList.add('active');

    // Normal Order
    document.querySelector('.btn-order').href = 
        '/Handmade-Products-Plateform/project/pages/orders/delivery-info.php?product_id=' + productId + '&type=normal';

    // Customize Product
    const btnCustomize = document.querySelector('.btn-customize-order');
  
if (customizeProductId) {
    btnCustomize.href = '/Handmade-Products-Plateform/project/pages/orders/costumize-product.php?id=' + customizeProductId;
    btnCustomize.parentElement.style.display = 'inline'; 
} else {
    btnCustomize.parentElement.style.display = 'none'; 
}

    document.querySelector('.btn-shop').href = 
        '/Handmade-Products-Plateform/project/pages/shop/artisan-shop.php?id=' + artisanId;
            const buttons = document.querySelector('.buttons');
             document.querySelector('.product-info').textContent = productInfo;
 if (currentUserId && currentUserId == artisanId) {
    document.querySelector('.btn-order').parentElement.style.display = 'none';
    document.querySelector('.btn-customize-order').parentElement.style.display = 'none';
    document.querySelector('.btn-shop').parentElement.style.display = 'none'; 
} else {
    document.querySelector('.btn-order').parentElement.style.display = 'inline';

    document.querySelector('.btn-shop').parentElement.style.display = 'inline'; 
    
}
}

function closeModal() {
    document.getElementById('overlay').classList.remove('active');
}
document.getElementById('overlay').onclick = function(e) {
    if (e.target === this) closeModal();
}
    </script>
    
    <div class="space"></div>

    </section>

    <footer>
        <?php include '../layouts/footer.php'; ?>
    </footer>

</body>

</html>

