
<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    public function get_by_id($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "User with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = 'user_id') {
        parent::update($entity, $id, $id_column);
        return $this->get_by_id($id);
    }

    public function add($entity): mixed {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $entity['email']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        return ['error' => 'Email already exists.'];
    }

    $newId = parent::add($entity);
    return $this->get_by_id($newId);
}

}
