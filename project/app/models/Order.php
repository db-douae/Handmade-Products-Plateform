<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Normal Order
    public function placeOrder($buyerId, $productId, $deliveryId, $quantity = 1) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO normal_orders (buyer_id, product_id, delivery_id, quantity)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$buyerId, $productId, $deliveryId, $quantity]);
        return $this->pdo->lastInsertId();
    }

    public function getOrdersByBuyer($buyerId) {
        $stmt = $this->pdo->prepare(
            "SELECT o.*, p.product_name, p.image_product, p.price
             FROM normal_orders o
             JOIN products p ON o.product_id = p.id
             WHERE o.buyer_id = ?
             ORDER BY o.id DESC"
        );
        $stmt->execute([$buyerId]);
        return $stmt->fetchAll();
    }

    public function updateOrderStatus($orderId, $status) {
        $stmt = $this->pdo->prepare(
            "UPDATE normal_orders SET status=? WHERE id=?"
        );
        $stmt->execute([$status, $orderId]);
    }

    public function cancelOrder($orderId, $buyerId) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM normal_orders WHERE id=? AND buyer_id=?"
        );
        $stmt->execute([$orderId, $buyerId]);
    }

    // Customize Order
    public function placeCustomOrder($userId, $customizeProductId, $orderName, $orderDefinition) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO customize_orders (user_id, customize_product_id, order_name, order_definition)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $customizeProductId, $orderName, $orderDefinition]);
        return $this->pdo->lastInsertId();
    }

    public function updateCustomOrderDelivery($orderId, $deliveryId) {
        $stmt = $this->pdo->prepare(
            "UPDATE customize_orders SET delivery_id=? WHERE id=?"
        );
        $stmt->execute([$deliveryId, $orderId]);
    }

    public function updateCustomOrderStatus($orderId, $status) {
        $stmt = $this->pdo->prepare(
            "UPDATE customize_orders SET status=? WHERE id=?"
        );
        $stmt->execute([$status, $orderId]);
    }

    public function getCustomOrdersByUser($userId) {
        $stmt = $this->pdo->prepare(
            "SELECT co.*, cp.color, cp.size, cp.text, p.product_name, p.price
             FROM customize_orders co
             JOIN customize_products cp ON co.customize_product_id = cp.id
             JOIN products p ON cp.product_id = p.id
             WHERE co.user_id = ?
             ORDER BY co.order_date DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
?>