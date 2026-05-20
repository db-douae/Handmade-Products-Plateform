<?php


require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/helpers/session.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/models/notification.php';

startSession();


if(isset($_SESSION['userId'])) {
    $notifModel = new Notification($pdo);
    $notifications = $notifModel->getByUserId($_SESSION['userId']);
    $unread = array_filter($notifications, fn($n) => !$n['is_read']);
    $hasRead = array_filter($notifications, fn($n) => $n['is_read']);

}
?>
  <nav class="navbar">
    <div class="logo">Craftmen</div>
    <ul class="nav-links">
      <li><a href="/Handmade-Products-Plateform/project/pages/index.php">Home</a></li>
      <li><a href="/Handmade-Products-Plateform/project/pages/artisans.php">Artisans</a></li>
      <li><a href="/Handmade-Products-Plateform/project/pages/products.php">Products</a></li>
      <li><a href="/Handmade-Products-Plateform/project/pages/About.php">About</a></li>
      <li><a href="/Handmade-Products-Plateform/project/pages/Contact.php">Contact</a></li>
    </ul>
<div class="nav-actions">


  <?php if(isset($_SESSION['userId'])): ?>
  <div class="notif-wrapper">
    <a href="#" class="btn-notif" id="notifBtn">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
    </a>
<div class="dropdown notif-dropdown" id="notifDropdown">
  <p class="dropdown-title">Notifications</p>
  <?php if(empty($notifications)): ?>
    <p style="padding:14px 16px;font-size:13px;color:var(--gray)">No notifications</p>
  <?php else: ?>
<!---->
<?php foreach($notifications as $notif): ?>
  <?php
  $oid = '';
  $otype = $notif['type'];
  preg_match('/order_id:(\d+)/', $notif['message'], $m);
  $oid = $m[1] ?? '';
  if (str_contains($notif['message'], 'order_type:scratch')) {
      $otype = 'scratch_order';
  }
  $orderInfoUrl = '/Handmade-Products-Plateform/project/pages/orders/order-info.php?order_id=' . $oid . '&type=' . $otype;
  $cleanMessage = htmlspecialchars(preg_replace('/\s*\|\s*order_id:\d+(\s*\|\s*order_type:\w+)?/', '', $notif['message']));
  ?>
  <div class="notif-item <?= $notif['is_read'] ? '' : 'unread' ?>">
    <span>
      <?= $cleanMessage ?>
      <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'artisan' && !empty($oid)): ?>
  : <a href="<?= $orderInfoUrl ?>">order informations</a>
<?php endif; ?>
    </span>
    <?php if($notif['type'] === 'normal_order' || $notif['type'] === 'customize_order'): ?>
      <?php if(!$notif['is_read'] && isset($_SESSION['role']) && $_SESSION['role'] === 'artisan'): ?>
        <div class="notif-actions">
          <button class="btn-accepti" onclick="handleOrder(this, <?= $notif['id'] ?>, 'confirmed')">✓</button>
          <button class="btn-deleti" onclick="handleOrder(this, <?= $notif['id'] ?>, 'refused')">✕</button>
        </div>
      <?php endif; ?>
    <?php elseif(!$notif['is_read']): ?>
      <div class="notif-actions">
        <button class="btn-accepti" onclick="markAsRead(<?= $notif['id'] ?>)">✓</button>
      </div>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
  <?php endif; ?>
  <?php //if(isset($_SESSION['role']) && $_SESSION['role'] === 'buyer' && !empty($hasRead)): ?>
  <a class="clear" onclick="deleteReadNotifications()">Clear read</a>
<?php //endif; ?>
</div>
  </div>


  <div class="profile-wrapper">
    <a href="#" class="btn-login" id="profileBtn">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
      </svg>
    </a>
    <div class="dropdown profile-dropdown" id="profileDropdown">
      <a href="/Handmade-Products-Plateform/project/pages/account/settings.php" class="dropdown-item">Settings</a>
      <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'artisan'): ?>
      <a href="/Handmade-Products-Plateform/project/pages/shop/my-shop.php" class="dropdown-item">My shop</a>
<?php endif; ?>
<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
 <a href="/Handmade-Products-Plateform/project/pages/admin/admin.php" class="dropdown-item">Admin Panel</a>
<?php endif; ?>
      <a href="/Handmade-Products-Plateform/project/pages/auth/logout.php" class="dropdown-item logout">Log out</a>
    </div>
  </div>
 <?php else: ?>

  <div class="nav-actions">
    <a href="/Handmade-Products-Plateform/project/pages/auth/login.php" class="btn-outline">Login</a>
    <a href="/Handmade-Products-Plateform/project/pages/auth/signin.php" class="btn-filled">Sign Up</a>
  </div>

<?php endif; ?>

</div>

  </nav>
  
  <style>
  /* ===== VARIABLES ===== */
:root {
  --brown: #876B5D;
  --dark:  #2F1F1B;
  --light: #F5F2EE;
  --white: #FFFFFF;
  --gray:  #A89080;
}


/* ===== RESET ===== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'poppins', sans-serif;
  background-color: var(--light);
  color: var(--dark);
}

/* ===== NAVBAR ===== */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 18px 60px;
  background-color: var(--dark);
  position: sticky;
  top: 0;
  z-index: 100;
}

.navbar {
  background-color: var(--dark);
}

.navbar.light .logo,
.navbar.light .nav-links a,
.navbar.light .btn-login {
  color: var(--light);
}

.navbar.light .nav-links a:hover,
.navbar.light .btn-login:hover {
  color: var(--brown);
}


.logo {
  font-family: 'Playfair Display', serif;
  font-size: 26px;
  color: var(--light);
  letter-spacing: 2px;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 36px;
}

.nav-links a {
  text-decoration: none;
  color: var(--light);
  font-size: 14px;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: color 0.3s;
}

.nav-links a:hover {
  color: var(--brown);
}

.btn-login {
  color: var(--light);
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: color 0.2s;
}

.btn-login:hover {
  color: var(--brown);
}
/*I add this code because we need it*/
.btn-notif {
  color: var(--light);
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: color 0.2s;
  position: relative;
}
.btn-notif:hover {
  color: var(--brown);
}
.nav-actions {
  display: flex;
  align-items: center;
  gap: 20px;
  position: relative;
}

.notif-wrapper, .profile-wrapper {
  position: relative;
}

.btn-notif {
  color: var(--light);
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: color 0.2s;
}

.btn-notif:hover {
  color: var(--brown);
}

/* ===== DROPDOWN ===== */
.dropdown {
  display: none;
  position: absolute;
  top: 40px;
  right: 0;
  background-color: var(--white);
  border-radius: 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  min-width: 350px;
  z-index: 200;
  overflow: hidden;
}

.dropdown.open {
  display: block;
}

.dropdown-title {
  font-size: 13px;
  font-weight: 600;
  color: var(--gray);
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 14px 16px 8px;
}

/* NOTIFICATIONS */
.notif-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 16px;
  border-top: 1px solid #f0ebe6;
  font-size: 13px;
  color: var(--dark);
}
.notif-item span{
font-size: 13px;
}

.notif-actions {
  display: flex;
  gap: 6px;
}

.btn-accepti, .btn-deleti {
  border: none;
  border-radius: 6px;
  width: 28px;
  height: 28px;
  cursor: pointer;
  font-size: 13px;
  transition: background 0.2s;
}

.btn-accepti {
  background-color: #e8f5e9;
  color: #2e7d32;
}

.btn-accepti:hover {
  background-color: #c8e6c9;
}

.btn-deleti {
  background-color: #fdecea;
  color: #c62828;
}

.btn-deleti:hover {
  background-color: #ffcdd2;
}

/* PROFILE */
.dropdown-item {
  display: block;
  padding: 12px 16px;
  text-decoration: none;
  color: var(--dark);
  font-size: 14px;
  transition: background 0.2s;
}

.dropdown-item:hover {
  background-color: var(--light);
}

.dropdown-item.logout {
  color: #c62828;
  border-top: 1px solid #f0ebe6;
}

.btn-outline {
  color: var(--light);
  border: 1px solid var(--light);
  padding: 8px 20px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 14px;
  transition: all 0.2s;
}

.btn-outline:hover {
  background-color: var(--light);
  color: var(--dark);
}

.btn-filled {
  background-color: var(--brown);
  color: var(--white);
  padding: 8px 20px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 14px;
  transition: background 0.2s;
}

.btn-filled:hover {
  background-color: #6e5549;
}

.dropdown .clear {
color: var(--brown);
font-size: x-small;
cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 14px 16px 8px;

}
  </style>
  
  <script>
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');
const notifBtn = document.getElementById('notifBtn');
const notifDropdown = document.getElementById('notifDropdown');

if (profileBtn && notifBtn) {
  profileBtn.addEventListener('click', (e) => {
    e.preventDefault();
    profileDropdown.classList.toggle('open');
    notifDropdown.classList.remove('open');
  });

  notifBtn.addEventListener('click', (e) => {
    e.preventDefault();
    notifDropdown.classList.toggle('open');
    profileDropdown.classList.remove('open');
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.profile-wrapper') && !e.target.closest('.notif-wrapper')) {
      profileDropdown.classList.remove('open');
      notifDropdown.classList.remove('open');
    }
  });
}

function markAsRead(id) {
  fetch('/Handmade-Products-Plateform/project/app/actions/mark_notification_read.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id })
  }).then(() => location.reload());
}

function updateOrder(notifId, status) {
  fetch('/Handmade-Products-Plateform/project/app/actions/update_order_status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ notif_id: notifId, status: status })
  }).then(() => location.reload());
}
function handleOrder(btn, notifId, status) {
  const item = btn.closest('.notif-item');
  const form = new FormData();
  form.append('notif_id', notifId);
  form.append('status', status);
  
  fetch('/Handmade-Products-Plateform/project/app/actions/update_order_status.php', {
    method: 'POST',
    body: form
  }).then(r => {
    if(r.ok) item.remove();
  });
}
function deleteReadNotifications() {
  fetch('/Handmade-Products-Plateform/project/app/actions/delete_notif.php', {
    method: 'POST',
  }).then(() => location.reload());
}

</script>
  
