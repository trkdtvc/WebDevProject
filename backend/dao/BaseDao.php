
<?php

require_once __DIR__ . '/../config.php';

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . Config::DB_HOST() . ";port=" . Config::DB_PORT() . ";dbname=" . Config::DB_NAME(),
                    Config::DB_USER(),
                    Config::DB_PASSWORD(),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

class BaseDao {
    protected $conn;
    protected $table_name;

    public function __construct($table_name) {
        $this->table_name = $table_name;
        $this->conn = Database::connect();
    }

    public function get_all() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_id($id, $id_column = "id") {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name WHERE $id_column = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $id_column = "id") {
        $stmt = $this->conn->prepare("DELETE FROM $this->table_name WHERE $id_column = :id");
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

    
    public function query($query, $params) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function query_unique($query, $params) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
