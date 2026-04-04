<!DOCTYPE html>
<html>
    <head>
        <title>Products</title>
        <meta name="viewoport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/Handmade-Products-Plateform/project/public/assets/css/products.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.0/css/all.css">
    </head>
<body>

    <section class="after-header">
        <select>
           <option>New to Old</option>
            <option>By Interests</option>
            <option>Lower to Higher price</option>
        </select>
       <div class="search-container">
            <input type="text" placeholder="search...">
            <img src="/Handmade-Products-Plateform/project/public/assets/images/search-icon.png" class="search-icon">
        </div>
    </section>


    <section class="category">

        <input type="radio" name="tabs" id="tab1" checked class="tabs">
       <label for="tab1">All</label>

        <input type="radio" name="tabs" id="tab2" class="tabs">
        <label for="tab2">Wood</label>

        <input type="radio" name="tabs" id="tab3" class="tabs">
        <label for="tab3">Pottery</label>

        <input type="radio" name="tabs" id="tab4"  class="tabs">
        <label for="tab4">Jewelry</label>

        <input type="radio" name="tabs" id="tab5"  class="tabs">
        <label for="tab5">Weaving</label>

        <input type="radio" name="tabs" id="tab6" class="tabs">
        <label for="tab6">Candles</label>
        
        <input type="radio" name="tabs" id="tab7"  class="tabs">
        <label for="tab7">Leather</label>

        <input type="radio" name="tabs" id="tab8" class="tabs">
        <label for="tab8">Other</label>

    </section>

    <hr style="border: 1px solid #876b5d;">

    <section>
    <div class="container" id="content1">
        <div class="box"><img src="img1.jpg" onclick="openModal(this)">
            <div class="product">
           <p style="font-size: 16px;">
            Hand-painted Ceramic<br>
            <b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img2.jpg">
        <div class="product">
           <p style="font-size: 16px;">
            Hand-painted Ceramic<br>
            <b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img3.jpg" onclick="openModal(this)">
        <div class="product">
           <p style="font-size: 16px;">
             Hand-painted Ceramic<br>
            <b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img4.png" onclick="openModal(this)">
        <div class="product">
           <p style="font-size: 16px;">
             Hand-painted Ceramic<br>
            <b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img5.png">
        <div class="product">
           <p style="font-size: 16px;">
            Hand-painted Ceramic<br>
            <b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img6.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img7.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div></div>
        <div class="box"><img src="img8.png">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div></div>
    </div>
    <div class="container" id="content2">
        <div class="box"><img src="img1.jpg" onclick="openModal(this)">
            <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img2.jpg">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img3.jpg">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
        <div class="box"><img src="img4.png" onclick="openModal(this)">
        <div class="product">
           <p style="font-size: 16px;">
            <i style="color: #fff;">-</i> Hand-painted Ceramic<br>
            <i style="color: #fff;">-</i><b style="color: #876b5d;">  $240</b></p>
            </div>
        </div>
    </div>
    <script>
            document.querySelectorAll('input[name="tabs"]').forEach((tab, index) => {
              tab.addEventListener('change', () => {
               document.querySelectorAll('.container').forEach(c => c.style.display = 'none');
               document.querySelectorAll('.container')[index].style.display = 'block';
              });
            });

        // لإظهار الأول عند تحميل الصفحة
        document.querySelectorAll('.container').forEach(c => c.style.display = 'none');
        document.querySelectorAll('.container')[0].style.display = 'block';

    </script>

    <script>
        function openModal(img) {
          document.getElementById('modal-img').src = img.src;
          document.getElementById('overlay').classList.add('active');
        }

        document.getElementById('overlay').onclick = function() {
            this.classList.remove('active');
        }
        function closeModal() {
           document.getElementById('overlay').classList.remove('active');
        }
    </script>

 <div class="overlay" id="overlay">
      <div class="modal-content">
        <img id="modal-img">
        <div class="definition">
          <span onclick="closeModal()">✕</span>
           <br>
           <div class="artisan">
            <br>
            <div class="pfp-artisan"></div>
            <p>amira</p>
           </div>
           <br>
          <h4 style="color: #2F1F1B;">Hand-painted Ceramic</h4>
          <p class="price">price : <b>$240</b></p>
           <hr> 
           <div class="buttons">
           <button href="login.html">Visit the store</button>
           <button href="login.html">Normal Order</button>
           <button href="login.html">Customize Product</button>
           <br></div>        
           
        </div>
      </div>
   </div>
    </section>

    <footer>
        <?php /*include '../layouts/footer.php';*/ ?>
    </footer>

</body>

</html>
