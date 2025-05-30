
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

class Config {
    public static function DB_HOST() {
        return "localhost";
    }

    public static function DB_PORT() {
        return 3306;
    }

    public static function DB_NAME() {
        return "webdev2025";
    }

    public static function DB_USER() {
        return "root";
    }

    public static function DB_PASSWORD() {
        return "root";
    }

    
    public static function JWT_SECRET() {
        return '2c9d82b1f2a940fc9fe0f8dc86a8c5ad5fda5ff7e92aee9a74c02de7f8fbd1d9';
    }
}
