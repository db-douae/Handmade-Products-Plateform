<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';
$controller = new AuthController($pdo);
$controller->saveInterests();
?>
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
            <form action="" method="POST">
            <input type="hidden" name="interests" id="interests-value">
                <div class="interests-grid">
                <div class="interest"><p>Pottery</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/1.png" class="icons"></div>
                <div class="interest"><p>Weaving</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/2.png" class="icons"></div>
                <div class="interest"><p>Embroidery</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/3.png" class="icons"></div>
                <div class="interest"><p>Traditional clothes</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/4.png" class="icons"></div>
                <div class="interest"><p>Handmade sweets and foods</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/5.png" class="icons"></div>
                <div class="interest"><p>jewellery</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/6.png" class="icons"></div>
                <div class="interest"><p>Wood</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/7.png" class="icons"></div>
                <div class="interest"><p>Others</p><img src="/Handmade-Products-Plateform/project/public/assets/images/icons/8.png" class="icons"></div>
            </div>

            <p class="counter">I choose <span id="count">0</span> </p>

            <div class="update">
            <button type="submit" >Finish</button>
            <span>choose one at least.</span>
            </div> 
            </form>
        </div>
        
        <script>
document.querySelector('button[type="submit"]').addEventListener('click', function() {
    const selected = [...document.querySelectorAll('.interest.selected')]
        .map(el => el.querySelector('p').textContent);
    document.getElementById('interests-value').value = selected.join(',');
});
        </script>
    </body>
</html>