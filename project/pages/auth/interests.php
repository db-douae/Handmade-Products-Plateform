<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/interests.css">
        <title>Interests</title>
    </head>
    <body>
        <div class="card">
            <div class="back">
                <button><</button>
                <h3>Choose your Interests</h3>
            </div>
            <div class="choose">
                <p><b>Tell us about your interests</b> — pick what you like so we can show you the right products.</p>
            </div>
                <div class="interests-grid">
                <div class="interest"><p>Wood</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/1.png" class="icons"></div>
                <div class="interest"><p>Jewelry</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/2.png" class="icons"></div>
                <div class="interest"><p>Weaving</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/3.png" class="icons"></div>
                <div class="interest"><p>Pottery</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/4.png" class="icons"></div>
                <div class="interest"><p>Ceramics</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/5.png" class="icons"></div>
                <div class="interest"><p>Embroidery</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/6.png" class="icons"></div>
                <div class="interest"><p>Candles</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/7.png" class="icons"></div>
                <div class="interest"><p>Else</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/8.png" class="icons"></div>
            </div>

            <p class="counter">I choose <span id="count">0</span> </p>

            <div class="update">
            <button>Finish</button>
            <span>choose one at least.</span>
            <span id="count">0</span>
            </div> 
        </div>
        <script>
            document.querySelectorAll('.interest').forEach(function(card) {
  card.addEventListener('click', function() {
    this.classList.toggle('selected');

document.getElementById('count').textContent = document.querySelectorAll('.interest.selected').length;
  });
});
        </script>
    </body>
</html>