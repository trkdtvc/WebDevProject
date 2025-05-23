
<?php

class BaseDao {
    protected $conn;
    protected $table_name;

    public function __construct($table_name) {
        $host = Config::DB_HOST();
        $dbname = Config::DB_NAME();
        $port = Config::DB_PORT();
        $user = Config::DB_USER();
        $pass = Config::DB_PASSWORD();

        $this->table_name = $table_name;

        $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function get_all() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_id($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table_name WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function add($entity) {
        $keys = array_keys($entity);
        $columns = implode(",", $keys);
        $params = implode(",", array_map(fn($key) => ":$key", $keys));

        $stmt = $this->conn->prepare("INSERT INTO $this->table_name ($columns) VALUES ($params)");
        $stmt->execute($entity);
        return $this->conn->lastInsertId();
    }

    public function update($entity, $id, $id_column = "id") {
        $set_clause = implode(", ", array_map(fn($k) => "$k = :$k", array_keys($entity)));
        $entity[$id_column] = $id;

        $stmt = $this->conn->prepare("UPDATE $this->table_name SET $set_clause WHERE $id_column = :$id_column");
        $stmt->execute($entity);
    }
}
