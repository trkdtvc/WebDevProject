
<?php
require_once __DIR__ . '/BaseDao.php';

class ReviewDao extends BaseDao {
    public function __construct() {
        parent::__construct("reviews");
    }

    public function get_by_id($id, $id_column = "review_id"): mixed {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $id_column = "review_id"): array {
        $stmt = $this->conn->prepare("DELETE FROM reviews WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "Review with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = "review_id"): mixed {
        parent::update($entity, $id, $id_column);
        return $this->get_by_id($id);
    }

    public function add($entity): mixed {
        $newId = parent::add($entity);
        return $this->get_by_id($newId);
    }

    public function get_by_user_id($user_id): array {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_book_id($book_id): array {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE book_id = :book_id");
        $stmt->execute(['book_id' => $book_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
