
<?php
require_once __DIR__ . '/BaseDao.php';

class OrderDao extends BaseDao {
    public function __construct() {
        parent::__construct("orders");
    }

    public function get_by_id($id, $id_column = "order_id"): mixed {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $id_column = "order_id"): array {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "Order with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = "order_id"): mixed {
        parent::update($entity, $id, $id_column);
        return $this->get_by_id($id);
    }

    public function add($entity): mixed {
        $newId = parent::add($entity);
        return $this->get_by_id($newId);
    }
}
