
<?php
require_once __DIR__ . '/BaseDao.php';

class OrderItemDao extends BaseDao {
    public function __construct() {
        parent::__construct("order_items");
    }

    public function get_by_id($id, $id_column = "order_item_id"): mixed {
        $stmt = $this->conn->prepare("SELECT * FROM order_items WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $id_column = "order_item_id"): array {
        $stmt = $this->conn->prepare("DELETE FROM order_items WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "Order item with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = 'order_item_id'): mixed {
        parent::update($entity, $id, $id_column);
        return $this->get_by_id($id);
    }

    public function add($entity): mixed {
        $newId = parent::add($entity);
        return $this->get_by_id($newId);
    }
}
