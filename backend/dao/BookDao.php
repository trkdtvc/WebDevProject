
<?php
require_once __DIR__ . '/BaseDao.php';

class BookDao extends BaseDao {
    public function __construct() {
        parent::__construct("books");
    }

    public function get_by_id($id): mixed {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE book_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id): array {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE book_id = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "Book with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = "book_id"): mixed {
        parent::update($entity, $id, $id_column);
        return $this->get_by_id($id);
    }


    public function add($entity): mixed {
        $newId = parent::add($entity);
        return $this->get_by_id($newId);
    }
}
