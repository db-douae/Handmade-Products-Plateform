<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';

$controller = new AuthController($pdo);
$controller->login();
?>
<html lan="ar">
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/login.css">
    </head>
    <body>
        <div class="wrapper">
            <h1>Log In</h1>
            <h5><?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?></h5>
            <form action="" method="POST">
                <div class="content">
                <label>email: </label>
                <input type="email" name="email" placeholder="Email"></div>
                <div class="content">
                <label>password:</label>
                <input type="password" name="password" placeholder="Password"></div>
                 <button type="submit">Log In</button>
            </form>
            
            
            <h1></h1>
            <div class="member">
                
                Not a member? <a href="signin.php">Register Now</a>

            </div>
        </div>
    </body>
</html>
