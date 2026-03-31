<!DOCTYPE html>         
<html>      
  <head>         
    <meta charset="UTF-8">
        <title>Settings</title>
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/settings.css">      
  </head>
  <body>

    <!--header>
        <?php /*include '../../layouts/header.php';*/ ?>
    </header-->

<div class="all">
<div class="avatar">
<img id="avatarPreview" class="pfp"/>
<br>
<div class="avatar-controls">
<label for="avatarInput" class="btn-browse">Browse</label>
<input type="file" id="avatarInput" hidden />   
<span id="fileName"><i style="color: rgb(77, 77, 77) ;">No file selected</i></span>  
<div class="update">
    <button>Update pfp</button>
</div>       
</div>
</div>
<div class="personal">
  <h2>Personal Informations</h2>

  <div class="name-row">
   <div class="form-group">
  <label>First Name</label>
  <input type="text"  value="Ahmed"/>
   </div>
   <div class="form-group">
  <label>Last Name</label>
  <input type="text" value="Ahmed" />
   </div>
</div>

<div class="email-input">
    <label>Email</label>
    <input type="email" value="example@gmail.com">
</div>
 <div class="update">
    <button>Save</button>
</div>  
</div>

<div class="change-password">
  <h2>Change Password</h2>

<div class="password">
    <label>Old password</label>
    <input type="password" placeholder="">
</div>
<div class="password">
    <label>New password</label>
    <input type="password" placeholder="">
</div>
<div class="password">
    <label>Confirm password</label>
    <input type="password" placeholder="">
</div>
 <div class="update">
    <button>Change</button>
</div>  
</div>

<div class="upgrade">
    <p>upgrade to <b>Artisan account</b>.</p>
    <button>Upgrade your account  ></button>
</div>

<div class="delete">
<div class="password">
    <label>Confirm password</label>
    <input type="password" placeholder="">
</div>
    <button>Delete Account</button>
</div>

</div>

 <script>
document.getElementById('avatarInput').addEventListener('change', function() {
  const file = this.files[0];
  fileName.textContent = file.name;
  avatarPreview.src = URL.createObjectURL(file);
});
 </script>  
         
  </body>

</html>