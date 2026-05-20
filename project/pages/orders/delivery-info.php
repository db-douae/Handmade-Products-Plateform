<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/OrderController.php';
requireLogin();
// منع الحرفي من الطلب من نفسه
if ($productId) {
    $stmt = $pdo->prepare("
        SELECT p.shop_id, s.artisan_id 
        FROM products p
        JOIN artisan_shops s ON s.id = p.shop_id
        WHERE p.id = ?
    ");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
    
    if ($product && $product['artisan_id'] == $_SESSION['userId']) {
        die("You cannot order your own products.");
    }
}

$productId = $_GET['product_id'] ?? null;
$type = $_GET['type'] ?? 'normal'; 


//requireRole('buyer');

$productId = $_GET['product_id'] ?? null;
$type = $_GET['type'] ?? 'normal'; // normal أو custom

$orderController = new OrderController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if ($type === 'normal') {
    $orderController->placeOrder();
    exit();
} else if ($type === 'customize_product') {
    $orderController->placeCustomProductOrder();
    exit();
} else if ($type === 'scratch') {
    $orderController->saveScratchOrderWithDelivery();
    exit();
} else {
    $orderController->addDeliveryToCustomOrder($_GET['order_id']);
    exit();
}
}

// نجيب بيانات المستخدم
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['userId']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delivery information</title>
        <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/info.css">
    </head>
    <body>
        <div class="card">
  <div class="back">
 <button onclick="window.location.href='../';">&lt;</button>
                <h3>enter your delivery information to proceed</h3>
  </div>
  <div class="card-section">
  <p>Order:</p>
</div>
<form method="POST">
  <div class="info-upgrade">
<input type="hidden" name="product_id" value="<?= htmlspecialchars($productId ?? '') ?>">
<input type="hidden" name="quantity" value="1">
<input type="hidden" name="customize_product_id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
<input type="hidden" name="selected_color" value="<?= htmlspecialchars($_GET['color'] ?? '') ?>">
<input type="hidden" name="selected_size" value="<?= htmlspecialchars($_GET['size'] ?? '') ?>">
<input type="hidden" name="selected_text" value="<?= htmlspecialchars($_GET['text'] ?? '') ?>">

<div class="form-group">
            <label>First Name</label> : <?= htmlspecialchars($user['first_name']) ?>
            <input type="hidden" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" placeholder="enter your first name">
            </div>
<div class="form-group">
            <label>Last Name</label> : <?= htmlspecialchars($user['last_name']) ?>
            <input type="hidden"  name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" placeholder="enter your Last name">
            </div>
            <div class="card-section2"></div>
            <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="client_number" value="+213">
            </div>
            <div class="address-row">
  <div class="form-group">
    <label>Wilaya</label>
    <select name="wilaya">
      <option >1- Adrar</option>
      <option>2- Chlef</option>
      <option>3- Laghouat</option>
      <option>4- Oum El Bouaghi</option>
      <option>5- Batna</option>
      <option>6- Béjaïa</option>
      <option>7- Biskra</option>
      <option>8- Béchar</option>
      <option>9- Blida</option>
      <option>10- Bouira</option>
      <option>11- Tamanrasset</option>
      <option>12- Tébessa</option>
      <option>13- Tlemcen</option>
      <option>14- Tiaret</option>
      <option>15- Tizi Ouzou</option>
      <option>16- Algiers</option>
      <option>17- Djelfa</option>
      <option>18- Jijel</option>
      <option>19- Sétif</option>
      <option>20- Saïda</option>
      <option>21- Skikda</option>
      <option>22- Sidi Bel Abbès</option>
      <option>23- Annaba</option>
      <option>24- Guelma</option>
      <option>25- Constantine</option>
      <option>26- Médéa</option>
      <option>27- Mostaganem</option>
      <option>28- M'Sila</option>
      <option>29- Mascara</option>
      <option>30- Ouargla</option>
      <option>31- Oran</option>
      <option>32- El Bayadh</option>
      <option>33- Illizi</option>
      <option>34- Bordj Bou Arréridj</option>
      <option>35- Boumerdès</option>
      <option>36- El Tarf</option>
      <option>37- Tindouf</option>
      <option>38- Tissemsilt</option>
      <option>39- El Oued</option>
      <option>40- Khenchela</option>
      <option>41- Souk Ahras</option>
      <option>42- Tipaza</option>
      <option>43- Mila</option>
      <option>44- Aïn Defla</option>
      <option>45- Naâma</option>
      <option>46- Aïn Témouchent</option>
      <option>47- Ghardaïa</option>
      <option>48- Relizane</option>
      <option>49- Timimoun</option>
      <option>50- Bordj Badji Mokhtar</option>
      <option>51- Ouled Djellal</option>
      <option>52- Béni Abbès</option>
      <option>53- In Salah</option>
      <option>54- In Guezzam</option>
      <option>55- Touggourt</option>
      <option>56- Djanet</option>
      <option>57- El M'Ghair</option>
      <option>58- El Meniaa</option>
    </select>
  </div>
  <div class="form-group">
    <label>Address</label>
    <input type="text" name="address" placeholder="Municipality, Street...">
  </div>
</div>

             </div>
         <div class="update">
            <button type="submit">Save</button>
            <span> <strong>Note:</strong> Payment is due upon acceptance and receipt of the order (Cash on Delivery), and the information will be sent to the craftsman</span>
</div>
</form>
</div>
    </body>
</html>
