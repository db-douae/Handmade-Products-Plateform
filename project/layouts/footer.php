<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>footer</title>
<style>
:root {
  --brown: #876B5D;
  --dark:  #2F1F1B;
  --light: #F5F2EE;
  --white: #FFFFFF;
  --gray:  #A89080;
}

/* ===== RESET ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'poppins', sans-serif;
  background-color: var(--light);
  color: var(--dark);
}
/* ===== FOOTER ===== */
footer {
  background-color: var(--dark);
  color: var(--light);
  padding: 48px 64px 0;
  margin-top: 48px;
}

.footer-top {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 32px;
  padding-bottom: 40px;
}

.footer-col h4 {
  font-size: 15px;
  font-weight: 700;
  color: var(--light);
  margin-bottom: 16px;
  letter-spacing: 0.5px;
}

.footer-col ul {
  list-style: none;
}

.footer-col ul li {
  margin-bottom: 10px;
}

.footer-col ul li a {
  color: var(--gray);
  text-decoration: none;
  font-size: 14px;
  transition: color 0.2s;
}

.footer-col ul li a:hover {
  color: var(--light);
}

.footer-bottom {
  border-top: 1px solid #3E2A25;
  padding: 16px 0;
  text-align: center;
  font-size: 13px;
  color: #6B4F47;
}


</style>
    </head>
    <body>
        <footer>
            <div class="footer-top">
                <div class="footer-col">
                    <h4>Quick links</h4>
                    <ul>
                    <li><a href="/Handmade-Products-Plateform/project/pages/index.php">Home</a></li>
                    <li><a href="/Handmade-Products-Plateform/project/pages/about.php">About</a></li>
                    <li><a href="/Handmade-Products-Plateform/project/pages/artisans.php">Artisans</a></li>
                    <li><a href="/Handmade-Products-Plateform/project/pages/products.php">Products</a></li>
                    <li><a href="/Handmade-Products-Plateform/project/pages/index.php">Contact</a></li>
                    </ul>
                </div>
             <div class="footer-col">
                <h4>Extra link</h4>
                <ul>
                <li><a href="/Handmade-Products-Plateform/project/pages/account/settings.php">my account</a></li>
                <!--li><a href="#">my order</a></li>
                <li><a href="#">my favorite</a></li-->
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
                <li><a href="#">+213 X XX XX XX XX</a></li>
                <li><a href="#">contact@craftsmen.com</a></li>
                </ul>
            </div>
        </div>
                <div class="footer-bottom">
            <p>© 2026 Craftmen. All rights reserved.</p>
        </div>
        </footer>
    </body>
</html>
