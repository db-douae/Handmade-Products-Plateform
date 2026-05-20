<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Deliveryinfo.php';
require_once __DIR__ . '/../models/notification.php';
require_once __DIR__ . '/../models/user.php'; 

class OrderController {
    private $orderModel;
    private $deliveryModel;
    private $pdo;

    public function __construct($pdo) {
        $this->orderModel    = new Order($pdo);
        $this->deliveryModel = new DeliveryInfo($pdo);
        $this->pdo = $pdo; 
    }

    
        

   public function placeOrder() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $buyerId   = $_SESSION['userId'];
        
$checkStmt = $this->pdo->prepare(
    "SELECT a.id FROM artisans a 
     JOIN products p ON p.shop_id = a.shop_id 
     WHERE p.id = ?"
);
$checkStmt->execute([$productId]);
$check = $checkStmt->fetch();
if ($check && $check['id'] == $buyerId) {
    $_SESSION['error'] = "You cannot order your own products.";
    header("Location: /Handmade-Products-Plateform/project/pages/index.php");
    exit();
}
        $productId = $_POST['product_id'];
        $quantity  = $_POST['quantity'] ?? 1;

        $deliveryData = [
            'client_number' => trim($_POST['client_number']),
            'address'       => trim($_POST['address']),
            'wilaya'        => trim($_POST['wilaya']),
            'delivery_date' => null
        ];
        $deliveryId = $this->deliveryModel->addDeliveryInfo($deliveryData);
        $orderId = $this->orderModel->placeOrder($buyerId, $productId, $deliveryId, $quantity);

        $buyerStmt = $this->pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
        $buyerStmt->execute([$buyerId]);
        $buyer = $buyerStmt->fetch();

        $artisanStmt = $this->pdo->prepare(
            "SELECT a.id FROM artisans a 
             JOIN products p ON p.shop_id = a.shop_id 
             WHERE p.id = ?"
        );
        $artisanStmt->execute([$productId]);
        $artisan = $artisanStmt->fetch();

        if ($artisan) {
            $productStmt = $this->pdo->prepare("SELECT product_name FROM products WHERE id = ?");
            $productStmt->execute([$productId]);
            $product = $productStmt->fetch();

            $notifModel = new Notification($this->pdo);
            $notifModel->create([
                'user_id'    => $artisan['id'],
                'first_name' => $buyer['first_name'],
                'last_name'  => $buyer['last_name'],
                'message'    => $buyer['first_name'] . ' ' . $buyer['last_name'] . ' ordered: ' . $product['product_name'] . ' | order_id:' . $orderId,
                'type'       => 'normal_order'
            ]);
        }

        $_SESSION['success'] = "Order placed successfully!";
        header("Location: /Handmade-Products-Plateform/project/pages/index.php");
        exit();
    }
}

   
public function placeCustomOrder() {
    startSession();
    //requireRole('buyer');
    $userId             = $_SESSION['userId'];
    $checkStmt = $this->pdo->prepare(
    "SELECT a.id FROM artisans a 
     JOIN products p ON p.shop_id = a.shop_id 
     JOIN customize_products cp ON cp.product_id = p.id
     WHERE cp.id = ?"
);
$checkStmt->execute([$customizeProductId]);
$check = $checkStmt->fetch();
if ($check && $check['id'] == $userId) {
    $_SESSION['error'] = "You cannot order your own products.";
    header("Location: /Handmade-Products-Plateform/project/pages/index.php");
    exit();
}

    $customizeProductId = $_POST['customize_product_id'];
    $orderName          = trim($_POST['order_name']);
    $selectedColor   = $_POST['selected_color'] ?? '';
$selectedSize    = $_POST['selected_size'] ?? '';
$orderDefinition = trim($_POST['order_definition'] ?? '');


if ($selectedColor || $selectedSize) {
    $orderDefinition = "Color: $selectedColor | Size: $selectedSize\n" . $orderDefinition;
}
    

    $orderId = $this->orderModel->placeCustomOrder($userId, $customizeProductId, $orderName, $orderDefinition);
    $buyerStmt = $this->pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$buyerStmt->execute([$userId]);
$buyer = $buyerStmt->fetch();

$cpStmt = $this->pdo->prepare(
    "SELECT p.product_name, cp.color, cp.size, cp.text 
     FROM customize_products cp 
     JOIN products p ON cp.product_id = p.id 
     WHERE cp.id = ?"
);
$cpStmt->execute([$customizeProductId]);
$cp = $cpStmt->fetch();

$artisanStmt = $this->pdo->prepare(
    "SELECT a.id FROM artisans a 
     JOIN products p ON p.shop_id = a.shop_id 
     JOIN customize_products cp ON cp.product_id = p.id
     WHERE cp.id = ?"
);
$artisanStmt->execute([$customizeProductId]);
$artisan = $artisanStmt->fetch();


if ($artisan) {
    $message = $buyer['first_name'] . ' ' . $buyer['last_name'] . ' requested a custom order for: ' . $cp['product_name'];
if ($orderDefinition) {
    $message .= ' | Details: ' . $orderDefinition;
}
$message .= ' | order_id:' . $orderId;

    $notifModel = new Notification($this->pdo);
    $notifModel->create([
        'user_id'    => $artisan['id'],
        'first_name' => $buyer['first_name'],
        'last_name'  => $buyer['last_name'],
        'message'    => $message,
        'type'       => 'customize_order'
    ]);
}
    header("Location: /Handmade-Products-Plateform/project/pages/orders/delivery-info.php?order_id=" . $orderId . "&type=customize");
    exit();
    
}


    public function myOrders() {
        startSession();
        $buyerId = $_SESSION['userId'];
        return $this->orderModel->getOrdersByBuyer($buyerId);
    }


    public function myCustomOrders() {
        startSession();
        $userId = $_SESSION['userId'];
        return $this->orderModel->getCustomOrdersByUser($userId);
    }


    public function cancelOrder($orderId) {
        startSession();
        //requireRole('buyer');
        $buyerId = $_SESSION['userId'];
        $this->orderModel->cancelOrder($orderId, $buyerId);
        $_SESSION['success'] = "Order cancelled.";
        header("Location: /Handmade-Products-Plateform/project/pages/orders/delivery-info.php");
        exit();
    }


/*    public function updateOrderStatus($orderId, $status) {
        startSession();
        $this->orderModel->updateOrderStatus($orderId, $status);
        
        // notification للـ buyer
$orderStmt = $this->pdo->prepare(
    "SELECT buyer_id FROM normal_orders WHERE id = ?"
);
$orderStmt->execute([$orderId]);
$order = $orderStmt->fetch();

if ($order) {
    $notifModel = new Notification($this->pdo);
    $notifModel->create([
        'user_id'    => $order['buyer_id'],
        'first_name' => 'System',
        'last_name'  => 'Notification',
        'message'    => 'Your order has been ' . $status . '.',
        'type'       => $status === 'confirmed' ? 'accept_order' : 'refuse_order'
    ]);
}
    }*/
    public function updateOrderStatus($orderId, $status) {
    startSession();
    $this->orderModel->updateOrderStatus($orderId, $status);


    $buyerId = null;


    $stmt = $this->pdo->prepare("SELECT buyer_id FROM normal_orders WHERE id = ?");
    $stmt->execute([$orderId]);
    $row = $stmt->fetch();
    if ($row) $buyerId = $row['buyer_id'];


    if (!$buyerId) {
        $stmt = $this->pdo->prepare("SELECT user_id FROM customize_orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $row = $stmt->fetch();
        if ($row) $buyerId = $row['user_id'];
    }


    if (!$buyerId) {
        $stmt = $this->pdo->prepare("SELECT user_id FROM scratch_orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $row = $stmt->fetch();
        if ($row) $buyerId = $row['user_id'];
    }

    if ($buyerId) {
        $notifModel = new Notification($this->pdo);
        $notifModel->create([
            'user_id'    => $buyerId,
            'first_name' => 'System',
            'last_name'  => 'Notification',
            'message'    => 'Your order has been ' . $status . '.',
            'type'       => $status === 'confirmed' ? 'accept_order' : 'refuse_order'
        ]);
    }
}


    public function updateCustomOrderStatus($orderId, $status) {
        startSession();
        $this->orderModel->updateCustomOrderStatus($orderId, $status);
    }


    public function addDeliveryToCustomOrder($orderId) {
        startSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $deliveryData = [
                'client_number' => trim($_POST['client_number']),
                'address'       => trim($_POST['address']),
                'wilaya'        => trim($_POST['wilaya']),
                'delivery_date' => null
            ];
            $deliveryId = $this->deliveryModel->addDeliveryInfo($deliveryData);
            $this->orderModel->updateCustomOrderDelivery($orderId, $deliveryId);

            $_SESSION['success'] = "Delivery info saved!";
            header("Location: /Handmade-Products-Plateform/project/pages/index.php");
            exit();
        }
    }
    public function placeCustomProductOrder() {
    startSession();
    //requireRole('buyer');
    $userId             = $_SESSION['userId'];
    $customizeProductId = $_POST['customize_product_id'];
$selectedColor      = $_POST['selected_color'] ?? '';
$selectedSize       = $_POST['selected_size'] ?? '';
$selectedText       = $_POST['selected_text'] ?? '';
$orderDefinition    = "Color: $selectedColor | Size: $selectedSize";
if ($selectedText) {
    $orderDefinition .= " | Text: $selectedText";
}


    $deliveryData = [
        'client_number' => trim($_POST['client_number']),
        'address'       => trim($_POST['address']),
        'wilaya'        => trim($_POST['wilaya']),
        'delivery_date' => null
    ];
    $deliveryId = $this->deliveryModel->addDeliveryInfo($deliveryData);


    $stmt = $this->pdo->prepare(
        "INSERT INTO customize_orders (user_id, customize_product_id, delivery_id, order_name, order_definition, status)
         VALUES (?, ?, ?, ?, ?, 'pending')"
    );
    $stmt->execute([
        $userId,
        $customizeProductId,
        $deliveryId,
        'Customize Product Order',
        $orderDefinition
    ]);

  $orderId = $this->pdo->lastInsertId();


$buyerStmt = $this->pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$buyerStmt->execute([$userId]);
$buyer = $buyerStmt->fetch();


$artisanStmt = $this->pdo->prepare("
    SELECT a.id, p.product_name
    FROM artisans a
    JOIN products p ON p.shop_id = a.shop_id
    JOIN customize_products cp ON cp.product_id = p.id
    WHERE cp.id = ?
");
$artisanStmt->execute([$customizeProductId]);
$artisan = $artisanStmt->fetch();

if ($artisan) {
    $message = $buyer['first_name'] . ' ' . $buyer['last_name']
             . ' ordered a customized product: ' . $artisan['product_name']
             . ' | Details: ' . $orderDefinition
             . ' | order_id:' . $orderId;

    $notifModel = new Notification($this->pdo);
    $notifModel->create([
        'user_id'    => $artisan['id'],
        'first_name' => $buyer['first_name'],
        'last_name'  => $buyer['last_name'],
        'message'    => $message,
        'type'       => 'customize_order'
    ]);
}

$_SESSION['success'] = "Order placed successfully!";
header("Location: /Handmade-Products-Plateform/project/pages/index.php");
exit();
}
public function placeCustomOrderFromScratch() {
    startSession();
    //requireRole('buyer');

    $userId    = $_SESSION['userId'];
    $artisanId = $_POST['artisan_id'];
    if ($artisanId == $userId) {
    $_SESSION['error'] = "You cannot send a request to yourself.";
    header("Location: /Handmade-Products-Plateform/project/pages/artisans.php");
    exit();
}

    $orderName = trim($_POST['order_name']);
    $orderDef  = trim($_POST['order_definition'] ?? '');

    $_SESSION['scratch_order'] = [
        'artisan_id'       => $artisanId,
        'order_name'       => $orderName,
        'order_definition' => $orderDef,
    ];

    header("Location: /Handmade-Products-Plateform/project/pages/orders/delivery-info.php?type=scratch");
    exit();
}
public function saveScratchOrderWithDelivery() {
    startSession();
    //requireRole('buyer');

    $userId = $_SESSION['userId'];
    $scratch = $_SESSION['scratch_order'] ?? null;

    if (!$scratch) {
        header("Location: /Handmade-Products-Plateform/project/pages/index.php");
        exit();
    }


    $deliveryData = [
        'client_number' => trim($_POST['client_number']),
        'address'       => trim($_POST['address']),
        'wilaya'        => trim($_POST['wilaya']),
        'delivery_date' => null
    ];
    $deliveryId = $this->deliveryModel->addDeliveryInfo($deliveryData);


    $stmt = $this->pdo->prepare(
        "INSERT INTO scratch_orders (user_id, artisan_id, delivery_id, order_name, order_definition, status)
         VALUES (?, ?, ?, ?, ?, 'pending')"
    );
    $stmt->execute([
        $userId,
        $scratch['artisan_id'],
        $deliveryId,
        $scratch['order_name'],
        $scratch['order_definition']
    ]);
    $orderId = $this->pdo->lastInsertId();


    $buyerStmt = $this->pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
    $buyerStmt->execute([$userId]);
    $buyer = $buyerStmt->fetch();


    $message = $buyer['first_name'] . ' ' . $buyer['last_name'] 
             . ' sent a custom request: ' . $scratch['order_name'];
    if ($scratch['order_definition']) {
        $message .= ' | Details: ' . $scratch['order_definition'];
    }
    $message .= ' | order_id:' . $orderId . ' | order_type:scratch';

    $notifModel = new Notification($this->pdo);
    $notifModel->create([
        'user_id'    => $scratch['artisan_id'],
        'first_name' => $buyer['first_name'],
        'last_name'  => $buyer['last_name'],
        'message'    => $message,
        'type'       => 'customize_order'
    ]);

    unset($_SESSION['scratch_order']);

    $_SESSION['success'] = "Your request was sent!";
    header("Location: /Handmade-Products-Plateform/project/pages/index.php");
    exit();
}
}
?>
