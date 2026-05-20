<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';
$controller = new AuthController($pdo);
$controller->register();
?>
<html lan="ar">
    <head>
        <meta charset="UTF-8">
        <title>Sign In</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/login.css">
    </head>
    <body>
        <div class="wrapper">
            <h1>Sign Up</h1>
            <h5><?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?></h5>
            <form action="" method="POST">
                <div class="content">
                <label>First Name:</label>
                <input type="text" name="first_name" placeholder="First Name">
                 <label>Last Name:</label>
                <input type="text" name="last_name" placeholder="Last Name"></div>
                <br>
                <div class="content">
                 <label>Email:</label>
                <input type="email" name="email" placeholder="Email">
                 <label>Rewrite the email:</label>
                <input type="email" name="re_email" placeholder="Re-Email"></div>
                <br>
                <div class="content">
                 <label>password:</label>
                <input type="password" name="password" placeholder="Password">
                 <label>rewrite the password:</label>
                <input type="password" name="re_password" placeholder="Re-Password"></div>

            
            <!--div class="terms">
                <input type="checkbox" id="checkbox"> 
                <label for="checkbox">I agree to these <a href="#">Terms & Conditions</a></label>

            </div-->
       
            <button type="submit">Sign Up</button>
         </form>    
            <div class="member">
                Already a member? <a href="login.php">Login here</a>

            </div>
        </div>
    </body>
</html>
