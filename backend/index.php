
<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

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

// Route includes
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/BookRoutes.php';
require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderItemRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';

// Enable CORS
Flight::route('/*', function () {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    if (Flight::request()->method == 'OPTIONS') {
        Flight::halt(200);
    }
});

// Register services
Flight::register('user_service', 'UserService', [new UserDao()]);
Flight::register('book_service', 'BookService', [new BookDao()]);
Flight::register('category_service', 'CategoryService', [new CategoryDao()]);
Flight::register('order_service', 'OrderService', [new OrderDao()]);
Flight::register('order_item_service', 'OrderItemService', [new OrderItemDao()]);
Flight::register('review_service', 'ReviewService', [new ReviewDao()]);

// Optional: Swagger/OpenAPI endpoint
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
