<?php
session_start();
require_once __DIR__ . '/../../app/controllers/ProductController.php';
require_once __DIR__ . '/../../app/controllers/ShopController.php';

$artisan_id = $_SESSION['user_id'] ?? 1;
$shopCtrl   = new ShopController();
$shop       = $shopCtrl->myShop($artisan_id);
$ctrl       = new ProductController();
$categories = $ctrl->categories();

$message = '';
$error   = '';

// تعديل منتج موجود
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_product = $ctrl->show((int)$_GET['edit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST['shop_id'] = $shop['id'];
    $result = $ctrl->store();

    if ($result['success']) {
        header('Location: /pages/shop/my-shop.php');
        exit;
    } else {
        $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة منتج</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar light">
    <div class="logo">Craftmen</div>
    <ul class="nav-links">
        <li><a href="/pages/shop/my-shop.php">My Shop</a></li>
    </ul>
</nav>

<div class="customize-wrapper">
    <div class="customize-card">

        <div class="card-header">
            <h2>إضافة منتج جديد</h2>
            <a href="/pages/shop/my-shop.php" class="btn-close">✕</a>
        </div>

        <div class="card-tabs">
            <button class="card-tab active" onclick="switchTab(1)">1 — معلومات المنتج</button>
            <button class="card-tab" onclick="switchTab(2)">2 — التخصيص</button>
        </div>

        <?php if ($error): ?>
            <div style="padding:12px 24px; color:#e74c3c; font-size:13px;">⚠️ <?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <!-- TAB 1 -->
            <div class="tab-content" id="tab-1">
                <div class="card-body">
                    <div class="card-left">

                        <div class="form-group">
                            <label>اسم المنتج:</label>
                            <input type="text" name="name" required
                                   value="<?= htmlspecialchars($edit_product['name'] ?? '') ?>"
                                   placeholder="مثال: وعاء فخاري مزخرف">
                        </div>

                        <div class="form-group">
                            <label>وصف المنتج:</label>
                            <textarea name="description" rows="4"
                                      placeholder="اشرح المنتج بالتفصيل..."><?= htmlspecialchars($edit_product['description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>التصنيف:</label>
                            <select name="category_id">
                                <option value="">اختر تصنيف...</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= ($edit_product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>السعر ($):</label>
                                <input type="number" name="price" step="0.01" min="0" required
                                       value="<?= $edit_product['price'] ?? '' ?>"
                                       placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label>الكمية:</label>
                                <input type="number" name="stock" min="0"
                                       value="<?= $edit_product['stock'] ?? 0 ?>"
                                       placeholder="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>قابل للتخصيص:</label>
                            <div class="toggle-row">
                                <span>نعم</span>
                                <label class="toggle">
                                    <input type="checkbox" name="is_customizable"
                                           <?= ($edit_product['is_customizable'] ?? 0) ? 'checked' : '' ?>>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="card-right">
                        <div class="form-group">
                            <label>صورة المنتج:</label>
                            <div class="upload-preview" onclick="document.getElementById('product-img').click()">
                                <span>+</span>
                                <small>اضغط لرفع صورة</small>
                            </div>
                            <input type="file" id="product-img" name="image" accept="image/*"
                                   style="display:none" onchange="previewImg(this)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2 -->
            <div class="tab-content hidden" id="tab-2">
                <div class="card-body">
                    <div class="card-left">
                        <div class="form-group">
                            <label>الألوان / الأشكال المتاحة:</label>
                            <div class="shapes-grid">
                                <?php for ($i = 0; $i < 12; $i++): ?>
                                <div class="shape-item"><span>+</span></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-right">
                        <div class="form-group">
                            <label>الكتابة على المنتج:</label>
                            <div class="toggle-row">
                                <span>نعم</span>
                                <label class="toggle">
                                    <input type="checkbox" onchange="toggleSection('text-opt', this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group hidden" id="text-opt">
                            <input type="text" name="custom_text_option" placeholder="مثال: اسم الزبون...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn-next">✓ حفظ المنتج</button>
            </div>

        </form>
    </div>
</div>

<script>
function switchTab(num) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
    document.querySelectorAll('.card-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + num).classList.remove('hidden');
    document.querySelectorAll('.card-tab')[num - 1].classList.add('active');
}

function toggleSection(id, checkbox) {
    document.getElementById(id).classList.toggle('hidden', !checkbox.checked);
}

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
        };
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Add product</title>
    <link rel="stylesheet" href="/Handmade-Products-Plateform/project/public/assets/css/style.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">Craftmen</div>
        <ul class="nav-links">
            <li><a href="#index.html">Home</a></li>
            <li><a href="#Artisans">Artisans</a></li>
            <li><a href="#Product">Products</a></li>
            <li><a href="#About">About</a></li>
            <li><a href="#Contact">Contact</a></li>
        </ul>
        <a href="#" class="btn-login">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </a>
    </nav>

    <!-- ADD PRODUCT WRAPPER -->
    <div class="customize-wrapper">
        <div class="customize-card">

            <!-- HEADER -->
            <div class="card-header">
                <h2>Add new product</h2>
                <button class="btn-close" onclick="window.location.href='my-shop.html'">✕</button>
            </div>

            <!-- TABS -->
            <div class="card-tabs">
                <button class="card-tab active" onclick="switchTab(1)">product info</button>
                <button class="card-tab" onclick="switchTab(2)">customize</button>
            </div>

            <!-- TAB 1 — معلومات المنتج -->
            <div class="tab-content" id="tab-1">
                <div class="card-body">

                    <!-- الجانب الأيسر -->
                    <div class="card-left">

                        <div class="form-group">
                            <label>product name:</label>
                            <input type="text" placeholder="example:ceramic Bowl">
                        </div>

                        <div class="form-group">
                            <label>description of product</label>
                            <textarea rows="4" placeholder="explain about the products in details.."></textarea>
                        </div>

                        <div class="form-group">
                            <label>category</label>
                            <select>
                                <option value="">choose a category..</option>
                                <option>pottery</option>
                                <option>wood</option>
                                <option>leather</option>
                                <option>weaving</option>
                                <option>jwelery</option>
                                <option>candles</option>
                                <option>other</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>price($):</label>
                                <input type="number" placeholder="0.00" min="0">
                            </div>
                            <div class="form-group">
                                <label>Available Quantity</label>
                                <input type="number" placeholder="0" min="0">
                            </div>
                        </div>

                        <!-- قابل للتخصيص -->
                        <div class="form-group">
                            <label>customizable:</label>
                            <div class="toggle-row">
                                <span>yes</span>
                                <label class="toggle">
                                    <input type="checkbox">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- الجانب الأيمن — صورة المنتج -->
                    <div class="card-right">

                        <div class="form-group">
                            <label>the main product</label>
                            <div class="upload-preview" onclick="document.getElementById('product-img').click()">
                                <span>+</span>
                                <small>Open folder / browse</small>
                            </div>
                            <input type="file" id="product-img" accept="image/*"
                                   style="display:none" onchange="previewImg(this)">
                        </div>

                        <div class="form-group">
                            <label>other images:</label>
                            <div class="extra-imgs-grid">
                                <div class="extra-img-item" onclick="document.getElementById('extra-img').click()">
                                    <span>+</span>
                                </div>
                                <div class="extra-img-item">
                                    <span>+</span>
                                </div>
                                <div class="extra-img-item">
                                    <span>+</span>
                                </div>
                            </div>
                            <input type="file" id="extra-img" accept="image/*" style="display:none">
                        </div>

                    </div>

                </div>
            </div>

            <!-- TAB 2 — التخصيص -->
            <div class="tab-content hidden" id="tab-2">
                <div class="card-body">

                    <!-- الجانب الأيسر -->
                    <div class="card-left">

                        <div class="form-group">
                            <label>>Available colors/shapes</label>
                            <div class="shapes-grid">
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                                <div class="shape-item"><span>+</span></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Dimensions / Available product dimensions</label>
                            <div class="dim-btns">
                                <button class="dim-btn active">xl</button>
                                <button class="dim-btn">×</button>
                                <button class="dim-btn">xxl</button>
                                <button class="dim-btn">s</button>
                                <button class="dim-btn">L</button>
                                <button class="dim-btn">M</button>
                                <button class="dim-btn add-btn">+ Add</button>
                            </div>
                        </div>

                    </div>

                    <!-- الجانب الأيمن -->
                    <div class="card-right">

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
                            <input type="text" placeholder="example:customer's Name..">
                        </div>

                        <div class="form-group">
                            <label>Ring Engraving</label>
                            <div class="toggle-row">
                                <span>yes</span>
                                <label class="toggle">
                                    <input type="checkbox" onchange="toggleSection('stamp-opt', this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group hidden" id="stamp-opt">
                            <input type="text" placeholder="text Engraving..">
                        </div>

                    </div>

                </div>
            </div>

            <!-- CARD FOOTER -->
            <div class="card-footer">
                <button class="btn-next" onclick="submitProduct()">
                    ✓ Save product
                </button>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-top">
            <div class="footer-col">
                <h4>Quick links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Artisans</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Extra link</h4>
                <ul>
                    <li><a href="#">my account</a></li>
                    <li><a href="#">my order</a></li>
                    <li><a href="#">my favorite</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Location</h4>
                <ul>
                    <li><a href="#">Algeria</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact info</h4>
                <ul>
                    <li><a href="#">+213-783 45 23 59</a></li>
                    <li><a href="#">contact@logo.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Craftmen. All rights reserved.</p>
        </div>
    </footer>

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
    </script>

</body>
</html>