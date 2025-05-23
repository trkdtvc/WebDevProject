
<?php
require_once __DIR__ . '/../../dao/BaseDao.php';

class AuthDao extends BaseDao {
    public function __construct() {
        parent::__construct("users"); // assumes you have a 'users' table
    }

    public function get_user_by_email($email) {
        return $this->query_unique("SELECT * FROM users WHERE email = :email", ["email" => $email]);
    }
}
