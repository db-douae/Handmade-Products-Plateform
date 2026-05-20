<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/helpers/session.php';
require_once __DIR__ . '/../../app/controllers/ProductController.php';

startSession();
requireRole('artisan');
// وضع edit mode إذا جاء ?edit=id
$editProduct = null;
if (isset($_GET['edit'])) {
    $productController = new ProductController($pdo);
    $editProduct = $productController->getProduct($_GET['edit']);
}

// معالجة الـ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController = new ProductController($pdo);
    if (isset($_POST['product_id'])) {
        // تعديل
        $productController->updateProduct($_POST['product_id']);
    } else {
        // إضافة
        $productController->addProduct();
    }
}
?>
<!DOCTYPE html>
<html lang="ar" >
<head>
    <meta charset="UTF-8">
    <title>Add product</title>
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

    <!-- ADD PRODUCT WRAPPER -->
    <div class="customize-wrapper">
        <div class="customize-card">

        

            <!-- HEADER -->
            <div class="card-header">
                <h2>Add new product</h2>
                <button class="btn-close" onclick="window.location.href='../shop/my-shop.php'">✕</button>
            </div>
<form method="POST" enctype="multipart/form-data">
    <?php if ($editProduct): ?>
    <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
<?php endif; ?>

    <input type="hidden" name="color" id="selected-colors">
    <input type="hidden" name="size" id="selected-sizes">
    <input type="hidden" name="text_option" id="text-option-val">
            <!-- TABS -->
            <!--div class="card-tabs">
                <button type="button" class="card-tab active" onclick="switchTab(1)">product info</button>
                <button type="button" class="card-tab" onclick="switchTab(2)">customize</button>

            </div-->

            <!-- TAB 1 — معلومات المنتج -->
            <div class="tab-content" id="tab-1">
                <div class="card-body">

                    <!-- الجانب الأيسر -->
                    <div class="card-right">

                        <div class="form-group">
                            <label>product name:</label>
                            <input type="text" name="product_name" placeholder="example:ceramic Bowl">
                        </div>

                        <div class="form-group">
                            <label>description of product</label>
                            <textarea rows="4" name="product_info" placeholder="explain about the products in details.."></textarea>
                        </div>

                        <!--div class="form-group">
                            <label>category</label>
                            <select>
                                <option value="">choose a category..</option>
                                <option>Pottery</option>
                                <option>wood</option>
                                <option>leather</option>
                                <option>weaving</option>

                                <option>jwelery</option>
                                <option>candles</option>
                                <option>other</option>
                            </select>
                        </div-->

                        <div class="form-row">
                            <div class="form-group">
                                <label>price(DZD):</label>
                                <input type="number" name="price" placeholder="0.00" min="0">
                            </div>
                            <!--div class="form-group">
                                <label>Available Quantity</label>
                                <input type="number" placeholder="0" min="0">
                            </div-->
                        </div>

                        <!-- قابل للتخصيص -->
                        <div class="form-group">
                            <label>customizable:</label>
                            <div class="toggle-row">
                                <span>yes</span>
                                <label class="toggle">
                                    <input type="checkbox" name="customizable" value="1">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- الجانب الأيمن — صورة المنتج -->
                    <div class="card-left">

                        <div class="form-group">
                            <label>the main product</label>
                            <div class="upload-preview" onclick="document.getElementById('product-img').click()">
                            <img id="main-preview-img" src="" style="display:none; width:100%; margin-top:8px; border-radius:8px;">
                                <span>+</span>
                                <small>Open folder / browse</small>
                            </div>
                            <input type="file" name="image_product" id="product-img" accept="image/*"
                                   style="display:none" onchange="previewImg(this)">
                        </div>

                        <!--div class="form-group">
                            <label>other images:</label>
                            <div class="extra-imgs-grid">

                                <div class="extra-img-item" onclick="document.getElementById('extra-img').click()">
                                    <span>+</span>
                                </div>


                            </div>
                            <input type="file" id="extra-img" accept="image/*" style="display:none">
                        </div-->

                    </div>

                </div>
            </div>

            <!-- TAB 2 — التخصيص -->
            <div class="tab-content hidden" id="tab-2">
                <div class="card-body">

                    <!-- الجانب الأيسر -->
                    <div class="card-right">

                        <div class="form-group">
                            <label>>Available colors/shapes</label>
                            <div class="shapes-grid">
                                <div class="shape-item"><span><img value="pink" src="/Handmade-Products-Plateform/project/public/assets/images/colors/1.png"></span></div>
                                <div class="shape-item"><span><img value="violet" src="/Handmade-Products-Plateform/project/public/assets/images/colors/2.png"></span></div>
                                <div class="shape-item"><span><img value="blue" src="/Handmade-Products-Plateform/project/public/assets/images/colors/3.png"></span></div>
                                <div class="shape-item"><span><img value="sky-blue" src="/Handmade-Products-Plateform/project/public/assets/images/colors/4.png"></span></div>
                                <div class="shape-item"><span><img value="green" src="/Handmade-Products-Plateform/project/public/assets/images/colors/5.png"></span></div>
                                <div class="shape-item"><span><img value="red" src="/Handmade-Products-Plateform/project/public/assets/images/colors/9.png"></span></div>
                                <div class="shape-item"><span><img value="orange" src="/Handmade-Products-Plateform/project/public/assets/images/colors/10.png"></span></div>
                                <div class="shape-item"><span><img value="yellow" src="/Handmade-Products-Plateform/project/public/assets/images/colors/8.png"></span></div>
                                <div class="shape-item"><span><img value="black" src="/Handmade-Products-Plateform/project/public/assets/images/colors/6.png"></span></div>
                                <div class="shape-item"><span><img value="white" src="/Handmade-Products-Plateform/project/public/assets/images/colors/7.png"></span></div>
                            </div>
                        </div>

                        <!--div class="form-group">
                            <label>Dimensions / Available product dimensions</label>

                            <div class="dim-btns">
                                <button type="button" class="dim-btn active">xl</button>
                                <button type="button" class="dim-btn">×</button>

                                <button type="button" class="dim-btn">xxl</button>
                                <button type="button" class="dim-btn">s</button>
                                <button type="button" class="dim-btn">L</button>

                                <button type="button" class="dim-btn">M</button>
                                <button type="button" class="dim-btn add-btn">+ Add</button>
                            </div>

                            <div class="form-group">
                        </div-->
                        
 <div class="form-group">
    <label>Dimensions / Available product dimensions</label>
    <div style="display:flex; gap:8px;">
        <input type="text" id="dim-input" placeholder="example: 10cm x 5cm">
        <button type="button" onclick="addDim()">+ Add</button>
    </div>
    <div class="dim-btns" id="dim-list"></div>
</div>

                    </div>

                    <!-- الجانب الأيمن -->
                    <div class="card-left">

                        <div class="form-group">
                            <label>wrinting on product</label>
                            <div class="toggle-row">
                                <span>yes</span>
                                <label class="toggle">
                                    <input type="checkbox" onchange="toggleSection('text-opt', this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group hidden" id="text-opt">
    <input type="text" name="text_placeholder" placeholder="example: customer's Name..">
</div>

                        <!--div class="form-group">
                            <label>Ring Engraving</label>
                            <div class="toggle-row">
                                <span>yes</span>
                                <label class="toggle">
                                    <input type="checkbox" onchange="toggleSection('stamp-opt', this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div-->

                        <!--div class="form-group hidden" id="stamp-opt">
                            <input type="text" placeholder="text Engraving..">
                        </div-->

                    </div>

                </div>
            </div>

            <!-- CARD FOOTER -->
            <div class="card-footer">
                <button type="submit" class="btn-next">
                    ✓ Save product
                </button>
            </div>
</form>
        </div>

    </div>


    <!-- FOOTER -->
  <?php include '../../layouts/footer.php'; ?>

    <script>
        // تبديل التابس
        function switchTab(num) {

            document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
            document.querySelectorAll('.card-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-' + num).classList.remove('hidden');

            document.querySelectorAll('.card-tab')[num - 1].classList.add('active');
        }

        // toggle
        function toggleSection(id, checkbox) {
            document.getElementById(id).classList.toggle('hidden', !checkbox.checked);
        }

        // preview صورة
function previewImg(input) {
    const file = input.files[0];

    if (file) {

        const reader = new FileReader();
        reader.onload = e => {

            const box = document.querySelector('.upload-preview');
            box.style.backgroundImage = `url(${e.target.result})`;

            box.style.backgroundSize = 'cover';
            box.style.backgroundPosition = 'center';

            box.querySelector('span').style.display = 'none';
            box.querySelector('small').style.display = 'none';


            const img = document.getElementById('main-preview-img');

            img.src = e.target.result;
            img.style.display = 'block';

        };

        reader.readAsDataURL(file);
    }

}

        // أزرار الأبعاد
        document.querySelectorAll('.dim-btn:not(.add-btn)').forEach(btn => {

            btn.addEventListener('click', () => {
                document.querySelectorAll('.dim-btn:not(.add-btn)').forEach(b => b.classList.remove('active'));

                btn.classList.add('active');
            });

        });

        // حفظ المنتج
        function submitProduct() {

            alert('تم حفظ المنتج بنجاح! ✅');

            window.location.href = 'my_shop.html';

        }
        
document.querySelectorAll('.shape-item').forEach(item => {
    item.addEventListener('click', () => {
        item.classList.toggle('selected');
    });

});

function addDim() {
    const input = document.getElementById('dim-input');

    const val = input.value.trim();

    if (!val) return;

    const btn = document.createElement('button');
    btn.type = 'button';

    btn.classList.add('dim-btn');
    btn.textContent = val;
    btn.addEventListener('click', () => btn.classList.toggle('active'));


    document.getElementById('dim-list').appendChild(btn);
    input.value = '';
}
document.querySelector('form').addEventListener('submit', function() {
    // الألوان المختارة
    const colors = [...document.querySelectorAll('.shape-item.selected img')]

        .map(img => img.getAttribute('value')).join(',');
    document.getElementById('selected-colors').value = colors;


    // الأحجام
    const sizes = [...document.querySelectorAll('#dim-list .dim-btn')]

        .map(btn => btn.textContent).join(',');
    document.getElementById('selected-sizes').value = sizes;


    // النص

    const checkbox = document.querySelector('#text-opt').previousElementSibling
                     .querySelector('input[type="checkbox"]');
    const isEnabled = checkbox && checkbox.checked;

    const placeholder = document.querySelector('#text-opt input').value;
    document.getElementById('text-option-val').value = isEnabled ? (placeholder || 'yes') : '';

});
    </script>

</body>
</html>
