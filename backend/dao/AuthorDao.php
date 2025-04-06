
<?php
require_once __DIR__ . '/../core/BaseDao.php';

class AuthorDao extends BaseDao {
    public function __construct() {
        parent::__construct("authors");
    }

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO authors (name, bio) VALUES (?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['bio']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE authors SET name = ?, bio = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['bio'],
            $id
        ]);
    }
}
