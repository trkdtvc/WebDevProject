
<?php
require_once __DIR__ . '/../dao/BaseDao.php';

class BookDao extends BaseDao {
    public function __construct() {
        parent::__construct("books");
    }

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO books (title, author_id, description, available_quantity) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['title'],
            $data['author_id'],
            $data['description'],
            $data['available_quantity']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE books SET title = ?, author_id = ?, description = ?, available_quantity = ? WHERE id = ?");
        return $stmt->execute([
            $data['title'],
            $data['author_id'],
            $data['description'],
            $data['available_quantity'],
            $id
        ]);
    }
}
