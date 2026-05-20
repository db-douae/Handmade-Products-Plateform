<?php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/session.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="../public/assets/css/style.css">
<title>About Us - Craftmen</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;600&display=swap');

  :root {
    --brown: #876B5D;
    --dark:  #2F1F1B;
    --light: #F5F2EE;
    --white: #FFFFFF;
    --gray:  #A89080;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: var(--light);
    font-family: 'Lato', sans-serif;
    overflow-x: hidden;
  }

  .about-header {
    background: var(--light);
    text-align: center;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .about-header::before {
    content: '';
    position: absolute;
    top: -40px; left: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);

  }

  .about-header::after {
    content: '';
    position: absolute;
    bottom: -50px; right: -30px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(47,31,27,0.12);
  }

  .about-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem;
    color: var(--dark);
    letter-spacing: 2px;
    position: relative;
    z-index: 1;
  }

  .about-header h1 span { color: var(--brown); }

  .about-section {
    display: flex;
    align-items: center;
    gap: 3rem;
    padding: 4rem 6rem;
    flex-wrap: wrap;
  }

  .slider-wrapper {
    position: relative;
    width: 500px;
    min-width: 300px;
    flex: 1 1 300px;
    border-radius: 14px;
    overflow: hidden;
    background: var(--brown);
    box-shadow: 0 12px 40px rgba(47,31,27,0.2);
  }

  .slider-track {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.77,0,0.175,1);
  }

  .slide { min-width: 100%; position: relative; }

  .slide img {
    width: 100%; height: 320px;
    object-fit: cover; display: block;
  }

  .slide-caption {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(47,31,27,0.85));
    color: var(--light);
    text-align: center;
    padding: 1.5rem 1rem 0.75rem;
    font-size: 15px; font-weight: 600;
    letter-spacing: 1px;
    font-family: 'Playfair Display', serif;
  }

  .slider-dots {
    display: flex; justify-content: center;
    gap: 8px; padding: 12px 0;
    background: var(--brown);
  }

  .dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--gray);
    cursor: pointer;
    transition: background 0.3s, transform 0.3s;
    border: none;
  }

  .dot.active { background: var(--light); transform: scale(1.3); }

  .why-text { flex: 1 1 260px; }

  .why-text h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; color: var(--brown);
    margin-bottom: 1.2rem;
    display: inline-block;
  }

  .why-text h2::after {
    content: ''; display: block;
    width: 50px; height: 3px;
    background: var(--brown);
    margin-top: 8px; border-radius: 2px;
  }

  .why-text p {
    font-size: 15px; color: var(--brown);
    line-height: 1.9; font-weight: 300;
  }

  .features {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    padding: 0 4rem 4rem;
  }

  .feature-card {
    border: 1px solid rgba(135,107,93,0.4);
    border-radius: 12px;
    padding: 1.4rem 1.2rem;
    display: flex; align-items: center; gap: 14px;
    transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
    background: var(--white);
  }

  .feature-card:hover {
    background: rgba(135,107,93,0.08);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(47,31,27,0.1);
  }

  .feature-icon { width: 48px; height: 48px; flex-shrink: 0; color: var(--brown); }

  .feature-card h3 {
    font-size: 14px; font-weight: 700;
    color: var(--dark); margin-bottom: 4px;
    font-family: 'Playfair Display', serif;
  }

  .feature-card p { font-size: 12px; color: var(--gray); }

  @media (max-width: 900px) {
    .about-section { padding: 2.5rem 1.5rem; gap: 2rem; }
    .features { grid-template-columns: repeat(2, 1fr); padding: 0 1.5rem 2.5rem; }
  }

  @media (max-width: 520px) {
    .features { grid-template-columns: 1fr 1fr; padding: 0 1rem 2rem; gap: 0.75rem; }
    .about-section { padding: 2rem 1rem; }
    .about-header h1 { font-size: 1.7rem; }
  }
</style>
</head>
<body>

<?php include '../layouts/header.php'; ?>

<div class="about-header">
  <h1><span>About</span> Us</h1>
</div>

<div class="about-section">
  <div class="slider-wrapper">
    <div class="slider-track" id="sliderTrack">
      <div class="slide">
        <img src="/Handmade-Products-Plateform/project/public/assets/images/1.jpg" alt="Handmade Pottery"/>
        <div class="slide-caption">Handmade Pottery</div>
      </div>
      <div class="slide">
        <img src="/Handmade-Products-Plateform/project/public/assets/images/weaving.jpg" alt="handmade weaving"/>
        <div class="slide-caption">Handmade weaving</div>
      </div>
      <div class="slide">
        <img src="/Handmade-Products-Plateform/project/public/assets/images/【Matériau de Haute Qualité】Nos sacs à bandoulière….jpg" alt="Leather bag"/>
        <div class="slide-caption">Leather Crafts</div>
      </div>
      <div class="slide">
        <img src="/Handmade-Products-Plateform/project/public/assets/images/Embroidered Argenta Shams.webp" alt="Embroidery"/>
        <div class="slide-caption">Embroidery</div>
      </div>
      <div class="slide">
        <img src="/Handmade-Products-Plateform/project/public/assets/images/Wood - Wood Art _ Facebook.jpg" alt="wood Art"/>
        <div class="slide-caption">Wood Art</div>
      </div>
      <div class="slide">
        <img src="/Handmade-Products-Plateform/project/public/assets/images/خيط الروح الجزائري.jpg" alt="jewelery"/>
        <div class="slide-caption">Handmade accessory </div>
      </div>
    </div>
    <div class="slider-dots" id="dots"></div>
  </div>

  <div class="why-text">
    <h2>Why Choose Us?</h2>
    <p>
      We celebrate the beauty of handmade craftsmanship. Every product in our collection
      is carefully crafted by skilled Algerian artisans, preserving traditional techniques
      passed down through generations. When you shop with us, you support local communities
      and bring authentic art into your home.
    </p>
  </div>
</div>

<!--div class="features">
  <div class="feature-card">
    <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13l-1-4m12 4l1 6"/>
      <circle cx="9" cy="21" r="1"/><circle cx="19" cy="21" r="1"/>
    </svg>
    <div><h3>Free Delivery</h3><p>On All Orders</p></div>
  </div>
  <div class="feature-card">
    <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M4 4h16v4H4zM4 12h16v4H4zM4 20h16"/>
      <path d="M9 8v4M15 8v4"/>
    </svg>
    <div><h3>15 Days Returns</h3><p>Moneyback Guarantee</p></div>
  </div>
  <div class="feature-card">
    <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M20 12V22H4V12"/>
      <path d="M22 7H2v5h20V7z"/>
      <path d="M12 22V7"/>
      <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
      <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
    </svg>
    <div><h3>Offer & Gift</h3><p>Special Deals Daily</p></div>
  </div>
  <div class="feature-card">
    <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <rect x="2" y="5" width="20" height="14" rx="2"/>
      <path d="M2 10h20"/>
    </svg>
    <div><h3>Secure Payments</h3><p>Protected by Paypal</p></div>
  </div>
</div-->

<?php include '../layouts/footer.php'; ?>

<script>
  const track = document.getElementById('sliderTrack');
  const dotsContainer = document.getElementById('dots');
  const slides = document.querySelectorAll('.slide');
  let current = 0;

  slides.forEach((_, i) => {
    const dot = document.createElement('button');

    dot.className = 'dot' + (i === 0 ? ' active' : '');
    dot.setAttribute('aria-label', 'Slide ' + (i + 1));
    dot.onclick = () => goTo(i);
    dotsContainer.appendChild(dot);

  });

  function goTo(index) {

    current = index;
    track.style.transform = `translateX(-${current * 100}%)`;
    document.querySelectorAll('.dot').forEach((d, i) => {
      d.classList.toggle('active', i === current);

    });
  }

  setInterval(() => goTo((current + 1) % slides.length), 3000);
</script>

</body>
</html>
