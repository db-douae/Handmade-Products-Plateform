<?php
session_start();
require_once __DIR__ . '/../../app/controllers/OrderController.php';

$order_id = (int)($_GET['order_id'] ?? $_SESSION['order_id'] ?? 0);
$ctrl     = new OrderController();
$message  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $ctrl->saveDelivery($order_id);
    if ($result['success']) {
        header('Location: /pages/orders/CustomOrder.php?order_id=' . $order_id);
        exit;
    } else {
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>معلومات التوصيل</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar light">
    <div class="logo">Craftmen</div>
</nav>

<div class="customize-wrapper">
    <div class="customize-card">

        <div class="card-header">
            <h2>معلومات التوصيل</h2>
            <a href="#" class="btn-close">✕</a>
        </div>

        <?php if ($message): ?>
            <div style="padding:12px 24px; color:#e74c3c; font-size:13px;">⚠️ <?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="card-body" style="grid-template-columns:1fr;">
                <div style="max-width:480px; width:100%; margin:0 auto;">

                    <div class="form-group">
                        <label>الاسم الكامل:</label>
                        <input type="text" name="full_name" required placeholder="مثال: أحمد بن علي">
                    </div>

                    <div class="form-group">
                        <label>رقم الهاتف:</label>
                        <input type="tel" name="phone" required placeholder="0550 000 000">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>الولاية:</label>
                            <select name="wilaya" required>
                                <option value="">اختر ولاية...</option>
                                <option>الجزائر</option>
                                <option>البليدة</option>
                                <option>وهران</option>
                                <option>قسنطينة</option>
                                <option>عنابة</option>
                                <option>تيزي وزو</option>
                                <option>سطيف</option>
                                <option>بجاية</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>المدينة:</label>
                            <input type="text" name="city" required placeholder="المدينة">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>العنوان التفصيلي:</label>
                        <textarea name="address" rows="3" required
                                  placeholder="الشارع، الحي، رقم البناية..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>ملاحظات إضافية: <span style="color:var(--gray)">(اختياري)</span></label>
                        <input type="text" name="notes" placeholder="مثال: قرب المسجد...">
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-next">تأكيد الطلب ✓</button>
            </div>
        </form>

    </div>
</div>

<footer class="footer">
    <div class="footer-bottom">
        <p>© 2025 Craftmen. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
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
 <button><</button>
                <h3>enter your delivery information to proceed</h3>
  </div>
  <div class="card-section">
  <p>Order:</p>
</div>
  <div class="info-upgrade">
<div class="form-group">
            <label>First Name</label>
            <input type="text" placeholder="enter your first name">
            </div>
<div class="form-group">
            <label>Last Name</label>
            <input type="text" placeholder="enter your Last name">
            </div>
            <div class="card-section2"></div>
            <div class="form-group">
            <label>Phone Number</label>
            <input type="text" value="+213">
            </div>
            <div class="address-row">
  <div class="form-group">
    <label>Wilaya</label>
    <select>
      <option>Medea</option>
      <option>Blida</option>
    </select>
  </div>
  <div class="form-group">
    <label>Address</label>
    <input type="text" placeholder="البلدية، الشارع...">
  </div>
</div>

             </div>
         <div class="update">
            <button>Save</button>
            <span> Note: Information will be sent to the craftsman</span>
</div>
</div>
    </body>
</html>