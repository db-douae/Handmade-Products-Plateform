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
<title>Contact Us - Craftmen</title>
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

  /* ── Header ── */
  .contact-header {
    background: var(--light);
    text-align: center;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .contact-header::before {
    content: '';
    position: absolute;
    top: -40px; left: -40px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
  }

  .contact-header::after {
    content: '';
    position: absolute;
    bottom: -50px; right: -30px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(47,31,27,0.12);
  }

  .contact-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem;
    color: var(--dark);
    letter-spacing: 2px;
    position: relative;
    z-index: 1;
  }

  .contact-header h1 span { color: var(--brown); }

  .contact-header p {
    color: var(--brown);
    font-size: 14px;
    font-weight: 300;
    margin-top: 0.5rem;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 1;
  }

  /* ── Cards grid ── */
  .contact-section {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    padding: 3rem 6rem;
  }

  .contact-card {
    background: var(--white);
    border: 1px solid rgba(135,107,93,0.3);
    border-radius: 14px;
    padding: 2.2rem 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
  }

  .contact-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(47,31,27,0.13);
    background: rgba(135,107,93,0.04);
  }

  .icon-circle {
    width: 60px; height: 60px;
    border-radius: 50%;
    background: rgba(135,107,93,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brown);
    flex-shrink: 0;
  }

  .icon-circle svg {
    width: 28px; height: 28px;
    stroke: var(--brown);
  }

  .contact-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    color: var(--dark);
  }

  .contact-card p {
    font-size: 13px;
    color: var(--gray);
    font-weight: 300;
    line-height: 1.8;
  }

  .contact-card a {
    font-size: 14px;
    color: var(--brown);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
  }

  .contact-card a:hover { color: var(--dark); }

  /* ── Social section ── */
  .social-section {
    text-align: center;
    padding: 0 6rem 4rem;
  }

  .social-section h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: var(--brown);
    margin-bottom: 0.5rem;
    display: inline-block;
  }

  .social-section h2::after {
    content: '';
    display: block;
    width: 40px; height: 3px;
    background: var(--brown);
    margin: 6px auto 0;
    border-radius: 2px;
  }

  .social-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
  }

  .social-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.55rem 1.4rem;
    border: 1px solid rgba(135,107,93,0.35);
    border-radius: 8px;
    background: var(--white);
    color: var(--brown);
    font-family: 'Lato', sans-serif;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.25s, color 0.25s, transform 0.2s;
    letter-spacing: 0.5px;
  }

  .social-btn:hover {
    background: var(--brown);
    color: var(--white);
    transform: translateY(-2px);
  }

  .social-btn svg {
    width: 17px; height: 17px;
    fill: currentColor;
    flex-shrink: 0;
  }

  /* ── Responsive ── */
  @media (max-width: 900px) {
    .contact-section { grid-template-columns: 1fr 1fr; padding: 2.5rem 1.5rem; }
    .social-section  { padding: 0 1.5rem 3rem; }
  }

  @media (max-width: 520px) {
    .contact-section  { grid-template-columns: 1fr; padding: 2rem 1rem; }
    .social-section   { padding: 0 1rem 2.5rem; }
    .contact-header h1 { font-size: 1.7rem; }
  }
</style>
</head>
<body>

<?php include '../layouts/header.php'; ?>

<!-- Page title -->
<div class="contact-header">
  <h1><span>Contact</span> Us</h1>
  <p>We'd love to hear from you — reach out anytime</p>
  <p style="font-size:13px; color:var(--gray); font-weight:300; margin-top:0.4rem; position:relative; z-index:1;">
  Forgot your password or need to report an issue? Don't hesitate to reach out — we're here to help.
</p>
</div>


<!-- Contact info cards -->
<div class="contact-section">

  <!-- Email -->
  <div class="contact-card">
    <div class="icon-circle">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h3>Email Us</h3>
    <p>Send us your questions<br>or inquiries anytime</p>
    <a href="mailto:support@craftmen.dz">contact@craftsmen.com</a>
  </div>

  <!-- Phone -->
  <div class="contact-card">
    <div class="icon-circle">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h3>Call Us</h3>
    <p>Available Sunday – Thursday<br>9:00 AM – 5:00 PM</p>
    <a href="tel:+213XXXXXXXXX">+213 XX XX XX XX</a>
  </div>

  <!-- Location -->
  <div class="contact-card">
    <div class="icon-circle">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h3>Our Location</h3>
    <p>Based in Algeria<br>Médéa, Algeria</p>
    <a href="https://maps.google.com/?q=Médéa,Algeria" target="_blank">View on Map</a>
  </div>

</div>

<!-- Social media -->
<!--div class="social-section">
  <h2>Follow Us</h2>
  <div class="social-links">

    <a class="social-btn" href="#" target="_blank">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
      </svg>
      Facebook
    </a>

    <a class="social-btn" href="#" target="_blank">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
      </svg>
      Instagram
    </a>

    <a class="social-btn" href="#" target="_blank">
      <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
        <path d="M380.9 97.1C337 53.2 279 25.5 217.6 24 99.5 24 8.1 115.4 8.1 233.5c0 40.8 10.7 80.6 31.1 115.7L6.1 487.9l142.2-37.3c33.9 18.5 72.2 28.2 111.1 28.2h.1c118.2 0 209.6-91.4 209.6-209.5 0-56-21.8-108.6-61.3-148.3zm-163.3 322c-34.5 0-68.3-9.3-97.8-26.9l-7-4.2-72.6 19 19.4-70.7-4.6-7.3C35.9 300.3 25 267.4 25 233.5 25 124.4 113.4 36 224.6 36c53.3 0 103.4 20.8 141.1 58.6 37.8 37.8 58.6 87.9 58.6 141.1.1 110.1-89.3 183.4-206.7 183.4z"/>
      </svg>
      WhatsApp
    </a>

  </div>
</div-->

<?php include '../layouts/footer.php'; ?>

</body>
</html>
