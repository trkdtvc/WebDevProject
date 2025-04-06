
<?php
require_once __DIR__ . '/../core/BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    public function insert($data) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT), 
            $data['role'] ?? 'member'
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['role'],
            $id
        ]);
    }
}
