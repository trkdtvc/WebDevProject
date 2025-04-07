
<?php
require_once __DIR__ . '/../dao/BaseDao.php';

class OrderDao extends BaseDao {
    public function __construct() {
        parent::__construct("orders");
    }

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, ?)");
        return $stmt->execute([
            $data['user_id'],
            $data['order_date'] ?? date('Y-m-d H:i:s')
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE orders SET user_id = ?, order_date = ? WHERE id = ?");
        return $stmt->execute([
            $data['user_id'],
            $data['order_date'],
            $id
        ]);
    }
}
