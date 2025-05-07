<?php
class DB {
    private static $host = "localhost";
    private static $db = "book_library";
    private static $user = "root";
    private static $password = "root";
    private static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    public static function connect() {
        return new PDO(
            "mysql:host=" . self::$host . ";dbname=" . self::$db,
            self::$user,
            self::$password,
            self::$options
        );
    }
}
