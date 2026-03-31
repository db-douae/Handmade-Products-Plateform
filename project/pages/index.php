<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Craftmen</title>
  <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@300;400&display=swap" rel="stylesheet"/>
</head>
<body>
  <nav class="navbar">
    <div class="logo">Craftmen</div>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
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

  <!-- HERO -->
  <section class="hero">
    <div class="hero-text">
      <h1>Handcrafted<br/>with Passion</h1>
      <p>Discover unique artisan products made with care and tradition.</p>
      <a href="#products" class="btn-primary">Shop Now</a>
      <a href="#Artisans" class="btn-primary">best Artisans</a>"
    </div>
    <div class="hero-image">
      <img src="images/فخار قبايلي جزائري 🇩🇿.jpg" alt="Craftmen Hero"/>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section class="products" id="products">
    <h2 class="section-title">Our Products</h2>

    <!-- SWITCH TABS -->
    <div class="switch-tabs">
      <button class="tab active" data-category="all">All</button>
      <button class="tab" data-category="wood">Wood</button>
      <button class="tab" data-category="leather">Leather</button>
      <button class="tab" data-category="ceramic">Ceramic</button>
      <button class="tab" data-category="candles">Candles</button>
      <button class="tab" data-category="pottery">Pottery</button>
      <button class="tab" data-category="jewelery">jewelery</button>
      <button class="tab" data-category="weaving">weaving</button>
      <button class="tab" data-category="Embroidery">Embroidery</button>
      
    </div>

    <!-- PRODUCT GRID -->
    <div class="product-grid">

      <div class="product-card" data-category="wood">
        <div class="product-img">
          <img src="images/Handmade ceramic mug and cup.webp" alt="Handmade ceramic"/>
        </div>
        <div class="product-info">
          <h3>Oak Wood Bowl</h3>
          <p>Hand-carved from solid oak. Each piece is unique.</p>
          <div class="product-footer">
            <span class="price">$48.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>

      <div class="product-card" data-category="leather">
        <div class="product-img">
          <img src="images/【Matériau de Haute Qualité】Nos sacs à bandoulière….jpg" alt="Leather Bag"/>
        </div>
        <div class="product-info">
          <h3>Leather Tote Bag</h3>
          <p>Full-grain leather, hand-stitched with durable thread.</p>
          <div class="product-footer">
            <span class="price">$120.00</span>
            <button class="btn-primary small">Add to Cart</button>
          
          </div>
        </div>
      </div>
        

      <div class="product-card" data-category="wood">
        <div class="product-img">
          <img src="images/Bring a touch of artisanal elegance to your….webp" alt="Wooden Frame"/>
        </div>
        <div class="product-info">
          <h3>Walnut Photo Frame</h3>
          <p>Solid walnut with hand-sanded finish. 5×7 size.</p>
          <div class="product-footer">
            <span class="price">$55.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>

      <div class="product-card" data-category="leather">
        <div class="product-img">
          <img src="images/Optimale bescherming voor jouw telefoon met onze….jpg" alt="Leather Wallet"/>
        </div>
        <div class="product-info">
          <h3>Slim Leather Wallet</h3>
          <p>Minimalist bifold wallet in genuine brown leather.</p>
          <div class="product-footer">
            <span class="price">$65.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>

      <div class="product-card" data-category="ceramic">
        <div class="product-img">
          <img src="images/p2.webp" alt="Ceramic Vase"/>
        </div>
        <div class="product-info">
          <h3>Rustic Ceramic Vase</h3>
          <p>Textured surface with warm earthy glaze. 30cm tall.</p>
          <div class="product-footer">
            <span class="price">$78.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>
      <div class="product-card" data-category="candles">
        <div class="product-img">
          <img src="images/candles.webp" alt="Handcrafted candle"/>
        </div>
        <div class="product-info">
          <h3>Handcrafted candle</h3>
          <p>Handmade candle with unique materials.</p>
          <div class="product-footer">
            <span class="price">$48.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>
      <div class="product-card" data-category="pottery">
        <div class="product-img">
          <img src="images/pottery.jpg" alt="Handmade pottery"/>
        </div>
        <div class="product-info">
          <h3>Handmade pottery</h3>
          <p>Hand-carved made with passion and creativity.</p>
          <div class="product-footer">
            <span class="price">$48.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>
      <div class="product-card" data-category="jewelery">
        <div class="product-img">
          <img src="images/خيط الروح الجزائري.jpg" alt="خيط الروح الجزائري"/>
        </div>
        <div class="product-info">
          <h3>algerien necklace</h3>
          <p>Handmade necklace . with natural silk thread.</p>
          <div class="product-footer">
            <span class="price">$48.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>
      <div class="product-card" data-category="weaving">
        <div class="product-img">
          <img src="images/weaving.jpg" alt="Embroidered pillow"/>
        </div>
        <div class="product-info">
          <h3></h3>
          <p>A professional weaving. Each piece is unique.</p>
          <div class="product-footer">
            <span class="price">$48.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>
      <div class="product-card" data-category="Embroidery">
        <div class="product-img">
          <img src="images/Embroidered Argenta Shams.webp" alt="Wood Bowl"/>
        </div>
        <div class="product-info">
          <h3>Oak Wood Bowl</h3>
          <p>Hand-carved from solid oak. Each piece is unique.</p>
          <div class="product-footer">
            <span class="price">$48.00</span>
            <button class="btn-primary small">Add to Cart</button>
          </div>
        </div>
      </div>
    </div>
  </section>

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
    const tabs = document.querySelectorAll('.tab');
    const cards = document.querySelectorAll('.product-card');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        const category = tab.dataset.category;
        cards.forEach(card => {
          if (category === 'all' || card.dataset.category === category) {
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