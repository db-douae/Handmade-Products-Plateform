<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';

requireLogin();
$controller = new UserController($pdo);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$controller->upgradeToArtisan(
    $_SESSION['userId'],
    $_POST['shop_name'],
    $_POST['category_name'],
    $_POST['description']
);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/upgrade.css">
        <title>Upgrade</title>
    </head>
    <body>

        <form action="" method="POST">
        <div class="card">
            <div class="back">
                <button><</button>
                <h3>Upgrade to Artisan account</h3>
                
            </div>
            <h3><?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['success'])): ?>
    <p style="color:green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?></h3>
            <div class="info-upgrade">
            <div class="form-group">
            <label>Shop Name</label>
            <input type="text" name="shop_name" placeholder="example: hirfa shop">
            </div>
            <div class="form-group">
            <label>Choose your category</label> 
            <select name="category_name">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
            </select>
        </div>
            <div class="form-group">
  <label>Service definition</label>
  <textarea name="description"></textarea>
</div>
<div class="form-group">
            <label>Cover to your shop!</label> 
            <label for="avatarInput" class="btn-browse">Browse</label>
            <input type="file" id="avatarInput" hidden />   
            <span id="fileName"><i style="color: rgb(77, 77, 77) ;">No file selected</i></span>  
        </div>
           
            </div>
         <div class="update">
            <button type="submit">Save</button>
            </div> 

        </div>
</form>
<script>
document.getElementById('avatarInput').addEventListener('change', function() {
  const file = this.files[0];
  fileName.textContent = file.name;
});
</script> 
    </body>
</html>