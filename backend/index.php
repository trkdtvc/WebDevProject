
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/rest/config/config.php';

// DAO includes
require_once __DIR__ . '/dao/BaseDao.php';
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/BookDao.php';
require_once __DIR__ . '/dao/CategoryDao.php';
require_once __DIR__ . '/dao/OrderDao.php';
require_once __DIR__ . '/dao/OrderItemDao.php';
require_once __DIR__ . '/dao/ReviewDao.php';

// Service includes
require_once __DIR__ . '/services/BaseService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/BookService.php';
require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/OrderService.php';
require_once __DIR__ . '/services/OrderItemService.php';
require_once __DIR__ . '/services/ReviewService.php';

// Register services
Flight::register('user_service', 'UserService', [new UserDao()]);
Flight::register('book_service', 'BookService', [new BookDao()]);
Flight::register('category_service', 'CategoryService', [new CategoryDao()]);
Flight::register('order_service', 'OrderService', [new OrderDao()]);
Flight::register('order_item_service', 'OrderItemService', [new OrderItemDao()]);
Flight::register('review_service', 'ReviewService', [new ReviewDao()]);

// Auth Service
require_once __DIR__ . '/rest/services/AuthService.php';
Flight::register('auth_service', 'AuthService');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Middleware for JWT Auth (excludes /auth/* and /api-docs)
Flight::route('/*', function () {
    // CORS headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, Authentication');

    if (Flight::request()->method === 'OPTIONS') {
        Flight::halt(200);
    }

    $url = Flight::request()->url;
    // 🔍 DEBUG: Log what Flight sees as the path
    error_log("DEBUG URL: $url");

    // Try matching a broader prefix (fallback for nested routes)
    if (
        str_contains($url, '/auth') ||
        str_contains($url, '/api-docs')
    ) {
        return true;
    }

    try {
        $token = Flight::request()->getHeader("Authentication");
        if (!$token) {
            Flight::halt(401, "Missing token");
        }

        $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('user', $decoded->user);
        Flight::set('jwt_token', $token);
    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

// Route includes
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/BookRoutes.php';
require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderItemRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';
require_once __DIR__ . '/rest/routes/AuthRoutes.php';

// Swagger / OpenAPI docs
Flight::route('GET /api-docs', function () {
    $path = __DIR__ . '/openapi.yaml';
    if (!file_exists($path)) {
        Flight::halt(404, "OpenAPI file not found.");
    }
    if (!function_exists('yaml_parse_file')) {
        Flight::halt(500, "Missing PHP yaml extension.");
    }
    $yaml = yaml_parse_file($path);
    Flight::json($yaml);
});

// Start the app
Flight::start();
