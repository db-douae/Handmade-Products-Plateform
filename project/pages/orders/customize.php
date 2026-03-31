<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Customize your order</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    <!-- NAVBAR -->
     <nav class="navbar">
    <div class="logo">Craftmen</div>
        <ul class="nav-links">
            <li><a href="#index.html">Home</a></li>
            <li><a href="#Artisans">Artisans</a></li>
            <li><a href="#Products">Products</a></li>
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

    <!-- CUSTOMIZE CARD -->
    <div class="customize-wrapper">
        <div class="customize-card">

            <div class="card-header">
                <h2>personalize your order</h2>
                <button class="btn-close">✕</button>
            </div>

            <div class="form-group">
                <label>the Artisan</label>
                <div class="artisan-row">
                    <span class="artisan-name">Um Kamal — AlMasna3</span>
                    <button class="btn-remove">✕</button>
                </div>
            </div>

            <div class="form-group">
                <label>Title/product Name</label>
                <input type="text" placeholder="مثال: وعاء فخاري بألوان محددة">
            </div>

            <div class="form-group">
                <label>Your request template / Request content:</label>
                <textarea rows="5" placeholder="أشرح طلبك بالتفصيل — الألوان، الأبعاد، المواد، أي تفاصيل تريدها..."></textarea>
            </div>

            <div class="form-group">
                <label>Adding pictures</label>
                <input type="file" accept="image/*" id="img-input">
            </div>

            <button class="btn-next" onclick="window.location.href='CustomOrder.html'">
                → Next
            </button>

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

</body>
</html>
```

---
