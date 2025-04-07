
<?php
require_once __DIR__ . '/../dao/BaseDao.php';

class OrderItemDao extends BaseDao {
    public function __construct() {
        parent::__construct("order_items");
    }

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, book_id, quantity) VALUES (?, ?, ?)");
        return $stmt->execute([
            $data['order_id'],
            $data['book_id'],
            $data['quantity']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE order_items SET order_id = ?, book_id = ?, quantity = ? WHERE id = ?");
        return $stmt->execute([
            $data['order_id'],
            $data['book_id'],
            $data['quantity'],
            $id
        ]);
    }
}
