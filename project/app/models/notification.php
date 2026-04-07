<?php
class Notification {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

public function create($data){

        $stmt = $this->pdo->prepare(
        "INSERT INTO notifications (user_id, first_name, last_name, message, date, type) 
         VALUES (?, ?, ?, ?, ?, ?)"
    );
   $stmt->execute([
        $data['user_id'],
        $data['first_name'],
        $data['last_name'],
        $data['message'],
        $data['date'],
        $data['type']
    ]); 
}

public function getByUserId($userId){
    $stmt = $this->pdo->prepare(
        "SELECT * FROM notifications WHERE user_id = ? ORDER BY date DESC"
    );
       $stmt->execute([$userId]);
       return $stmt->fetchAll();
}

public function markAsRead($id){
    $stmt=$this->pdo->prepare(
        "UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->execute([$id]);
}

}
 
?>