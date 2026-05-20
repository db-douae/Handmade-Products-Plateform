<?php

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
requireLogin();

$orderId = $_GET['order_id'] ?? null;
$type    = $_GET['type'] ?? null;



if (!$orderId || !$type) exit('Invalid request');

if ($type === 'normal_order') {
    $stmt = $pdo->prepare("
        SELECT no.*, p.product_name, p.price, u.first_name, u.last_name, 
               d.client_number, d.address, d.wilaya
        FROM normal_orders no
        JOIN products p ON no.product_id = p.id
        JOIN users u ON no.buyer_id = u.id
        JOIN delivery_info d ON no.delivery_id = d.id
        WHERE no.id = ?
    ");
} elseif ($type === 'customize_order') {
    $stmt = $pdo->prepare("
        SELECT co.*, p.product_name, p.price, u.first_name, u.last_name,
               cp.color, cp.size, cp.text,
               d.client_number, d.address, d.wilaya
        FROM customize_orders co
        JOIN customize_products cp ON co.customize_product_id = cp.id
        JOIN products p ON cp.product_id = p.id
        JOIN users u ON co.user_id = u.id
        LEFT JOIN delivery_info d ON co.delivery_id = d.id
        WHERE co.id = ?
    ");
} elseif ($type === 'scratch_order') {
    $stmt = $pdo->prepare("
        SELECT so.*, u.first_name, u.last_name,
               d.client_number, d.address, d.wilaya
        FROM scratch_orders so
        JOIN users u ON so.user_id = u.id
        LEFT JOIN delivery_info d ON so.delivery_id = d.id
        WHERE so.id = ?
    ");
}

$stmt->execute([$orderId]);
$order = $stmt->fetch();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Info</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/info.css">
</head>
<body>
<div style="max-width:600px; margin:40px auto; padding:20px;" class="card">
  <div class="back">
 <button onclick="window.location.href='../index.php';">&lt;</button>
    <h2>Order Information</h2>
 
      </div>
      <br>
      <hr style="color:#eee;">
      <br>


    <div class="form-group">
    <h3>Customer</h3>
<p>Name: <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></p>

<?php if(empty($order['client_number'])): ?>
    <p style="color:orange;">Delivery info not provided yet</p>
<?php else: ?>
    <p>Phone: <?= htmlspecialchars($order['client_number']) ?></p>
    <p>Address: <?= htmlspecialchars($order['address']) ?></p>
    <p>Wilaya: <?= htmlspecialchars($order['wilaya']) ?></p>
<?php endif; ?>
    </div>


    <br>
      <hr style="color:#eee;">
      <br>

      
    <div class="form-group">
    <h3>Order</h3>
    <?php if($type === 'normal_order'): ?>
        <p>Product: <?= htmlspecialchars($order['product_name']) ?></p>
        <p>Price: <?= $order['price'] ?> DZD</p>
    <?php elseif($type === 'customize_order'): ?>
        <p>Product: <?= htmlspecialchars($order['product_name']) ?></p>
        <p>Price: <?= $order['price'] ?> DZD</p>
        <p>Color: <?= htmlspecialchars($order['color'] ?? '') ?></p>
        <p>Size: <?= htmlspecialchars($order['size'] ?? '') ?></p>
        <p>Details: <?= htmlspecialchars($order['order_definition'] ?? '') ?></p>
    <?php elseif($type === 'scratch_order'): ?>
        <p>Title: <?= htmlspecialchars($order['order_name']) ?></p>
        <p>Details: <?= htmlspecialchars($order['order_definition'] ?? '') ?></p>
        <p>Status: <?= htmlspecialchars($order['status']) ?></p>
    <?php endif; ?>
</div>
    <br>
        <div class="update">
            <button onclick="window.location.href='../index.php';" type="submit">I see it.</button>
            <span></span>
</div>
</div>
</body>
</html>
