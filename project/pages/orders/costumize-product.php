<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';

startSession();
//requireRole('buyer');

$customizeProductId = $_GET['id'] ?? null;
if (!$customizeProductId) {
    header("Location: /Handmade-Products-Plateform/project/pages/products.php");
    exit();
}

// نجيب بيانات الـ customize product
$stmt = $pdo->prepare("
    SELECT cp.*, p.product_name, p.price, p.image_product 
    FROM customize_products cp
    JOIN products p ON cp.product_id = p.id
    WHERE cp.id = ?
");
$stmt->execute([$customizeProductId]);
$customProduct = $stmt->fetch();

if (!$customProduct) {
    header("Location: /Handmade-Products-Plateform/project/pages/products.php");
    exit();
}
?>
<!DOCTYPE html>
<!--html lang="ar" dir="rtl"-->
<html lang="ar" >
<head>
    <meta charset="UTF-8">
    <title>customize order</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>
<style>
  
    input, textarea,label, .form-control {
        text-align: left !important;
        direction: ltr !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    ::placeholder {
        text-align: left !important;
    }
</style>

    <!-- NAVBAR -->
     <?php include '../../layouts/header.php'; ?>

    <!-- CUSTOMIZE WRAPPER -->
    <div class="customize-wrapper">
        <div class="customize-card">

            <!-- HEADER -->
            <div class="card-header">
                <h2><?= htmlspecialchars($customProduct['product_name']) ?> — Customization</h2>
                <button onclick="window.location.href='../products.php';" class="btn-close">✕</button>
            </div>

            <!-- BODY -->
            <div class="card-body">

                <!-- الجانب الأيسر -->
                <div class="card-right">

                    <!-- شبكة الصور -->
                    <div class="form-group">
                        <!--label>الألوان المتاحة / الأشكال المتاحة:</label-->
                        <label>Available colors / Available shapes:</label>
                        <div class="shapes-grid">
<?php 
$colors = explode(',', $customProduct['color'] ?? '');
foreach ($colors as $color): ?>
    <div class="shape-item">
        <span><?= htmlspecialchars($color) ?></span>
    </div>
<?php endforeach; ?>
</div>
                    </div>

                    <!-- اختيار المقاس -->
                    <div class="form-group">
                        <label>Choosing the size:</label>
                        <div class="sizes-row">
<?php 
$sizes = explode(',', $customProduct['size'] ?? '');
foreach ($sizes as $size): ?>
    <button type="button" class="size-btn"><?= htmlspecialchars($size) ?></button>
<?php endforeach; ?>
</div>
                    </div>

                    <!-- اختيار حجم ملف -->
                    <!--div class="form-group">
                        <label>اختيار حجم منتج:</label>
                        <div class="size-product-row">
                            <select>
                                <option>420 × 103</option>
                                <option>500 × 200</option>
                                <option>300 × 300</option>
                            </select>
                            <span>في حالة المنتج يطلع عن نفسه</span>
                        </div>
                    </div-->

                </div>

                <!-- الجانب الأيمن -->
                <div class="card-left">

                    <!-- Preview الصورة -->
                    <!--div class="preview-box">
                        <div class="preview-img">
                            <span>preview</span>
                        </div>
                    </div-->

                    <!-- إضافة خلفية على منتج -->
                    <!--div class="form-group">
                        <label>إضافة خلفية على منتج:</label>
                        <input type="file" accept="image/*">
                    </div-->

                    <!-- النص الذي تريد إضافته -->
                    <?php if (!empty($customProduct['text'])): ?>
                    <div class="form-group">
                          <!--placeholder="النص الذي تريد إضافته..."-->
                          <label>Choosing the text:</label>
                        <input type="text" id="customText" placeholder="The text you want to add...">
                       
                    </div>
<?php endif; ?>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer">
               <button type="button" class="btn-next" 
    onclick="goNext()">→ Next</button>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer>
 <?php include '../../layouts/footer.php'; ?>
 </footer>

    <script>
        // اختيار شكل
        document.querySelectorAll('.shape-item').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelectorAll('.shape-item').forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
            });
        });

        // اختيار مقاس
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
        
function goNext() {
    const color = document.querySelector('.shape-item.selected span')?.textContent || '';
    const size  = document.querySelector('.size-btn.active')?.textContent || '';
    const text  = document.getElementById('customText')?.value || '';
    window.location.href = '/Handmade-Products-Plateform/project/pages/orders/delivery-info.php?id=<?= $customizeProductId ?>&type=customize_product&color=' + encodeURIComponent(color) + '&size=' + encodeURIComponent(size) + '&text=' + encodeURIComponent(text);
}
    </script>

</body>
</html>
