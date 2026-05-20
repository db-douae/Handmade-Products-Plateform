<?php
class DeliveryInfo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addDeliveryInfo($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO delivery_info (client_number, address, wilaya, delivery_date)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['client_number'],
            $data['address'],
            $data['wilaya'],
            $data['delivery_date'] ?? null
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateDeliveryStatus($deliveryId, $deliveryDate) {
        $stmt = $this->pdo->prepare(
            "UPDATE delivery_info SET delivery_date=? WHERE id=?"
        );
        $stmt->execute([$deliveryDate, $deliveryId]);
    }

    public function getById($deliveryId) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM delivery_info WHERE id=?"
        );
        $stmt->execute([$deliveryId]);
        return $stmt->fetch();
    }
}
?>