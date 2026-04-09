<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';
startSession();
$controller = new UserController($pdo);
$profile = $controller->getProfile($_SESSION['userId']);
?>
<!DOCTYPE html>         
<html>      
  <head>         
    <meta charset="UTF-8">
        <title>Settings</title>
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/settings.css">      
  </head>
  <body>

        <?php //include '../../layouts/header.php'; ?>

<div class="all">
<div class="avatar">
<img id="avatarPreview" class="pfp"/>
<br>
<form action="" method="POST">
<div class="avatar-controls">
<label for="avatarInput" class="btn-browse">Browse</label>
<input type="file" id="avatarInput" hidden />   
<span id="fileName"><i style="color: rgb(77, 77, 77) ;">No file selected</i></span>  
<div class="update">
    <button type="submit">Update pfp</button>
</div>       
</div>
</form>
</div>

<form action="" method="POST">
<div class="personal">
  <h2>Personal Informations</h2>

  <div class="name-row">
   <div class="form-group">
  <label>First Name</label>
  <input type="text" name="first_name" value="<?php echo $profile['first_name']; ?>">
   </div>
   <div class="form-group">
  <label>Last Name</label>
  <input type="text" name="last_name" value="<?php echo $profile['last_name']; ?>">
   </div>
</div>

<div class="email-input">
    <label>Email</label>
    <input type="email" name="email" value="<?php echo $profile['email']; ?>">
</div>
 <div class="update">
    <button type="submit">Save</button>
</div>  
</div>
</form>
<form action="" method="POST">
<div class="change-password">
  <h2>Change Password</h2>

<div class="password">
    <label>Old password</label>
    <input type="password" name="password" placeholder="">
</div>
<div class="password">
    <label>New password</label>
    <input type="password" name="new_password" placeholder="">
</div>
<div class="password">
    <label>Confirm password</label>
    <input type="password" name="re_password" placeholder="">
</div>
 <div class="update">
    <button type="submit">Change</button>
</div>  
</div>
</form>


<div class="upgrade">
    <p>upgrade to <b>Artisan account</b>.</p>
    <button onclick="window.location.href='upgrade.php';">Upgrade your account  ></button>
</div>

<form action="" method="POST">
<div class="delete">
<div class="password">
    <label>Confirm password</label>
    <input type="password"name="password" placeholder="">
</div>
    <button type="submit">Delete Account</button>
</div>

</div>
</form>

 <script>
document.getElementById('avatarInput').addEventListener('change', function() {
  const file = this.files[0];
  fileName.textContent = file.name;
  avatarPreview.src = URL.createObjectURL(file);
});
 </script>  
         
  </body>

</html>