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
      <header>
        <?php include '../layouts/header.php'; ?>
    </header>
        <section class="after-header">
        <select>
           <option>خيار 1</option>
            <option><a href="login.html">خيار 2</a></option>
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
