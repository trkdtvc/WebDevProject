
<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    public function get_by_id($id, $id_column = "user_id") {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $id_column = "user_id") {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return ['status' => 'success', 'message' => "User with ID $id deleted."];
    }

    public function update($entity, $id, $id_column = 'user_id') {
        parent::update($entity, $id, $id_column);
        return $this->get_by_id($id);
    }

    public function add($entity): mixed {
        return parent::add($entity); 
    }

    public function get_by_email($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
