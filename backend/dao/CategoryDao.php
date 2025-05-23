
<?php
require_once __DIR__ . '/BaseDao.php';

class CategoryDao extends BaseDao {
    public function __construct() {
        parent::__construct("categories");
    }

    public function get_by_id($id): mixed {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id): array {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE category_id = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "Category with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = 'category_id'): mixed {
        parent::update($entity, $id, id_column: "category_id");
        return $this->get_by_id($id);
    }

    public function add($entity): mixed {
        $newId = parent::add($entity);
        return $this->get_by_id($newId);
    }
}
