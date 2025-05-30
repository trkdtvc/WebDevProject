
<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: authorization, Content-Type, authentication");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require 'vendor/autoload.php';

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/dao/BaseDao.php';
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/BookDao.php';
require_once __DIR__ . '/dao/CategoryDao.php';
require_once __DIR__ . '/dao/OrderDao.php';
require_once __DIR__ . '/dao/OrderItemDao.php';
require_once __DIR__ . '/dao/ReviewDao.php';

require_once __DIR__ . '/services/BaseService.php';
require_once __DIR__ . '/services/AuthService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/BookService.php';
require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/OrderService.php';
require_once __DIR__ . '/services/OrderItemService.php';
require_once __DIR__ . '/services/ReviewService.php';

require_once __DIR__ . '/middleware/AuthMiddleware.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::register('auth_service', 'AuthService');
Flight::register('userService', 'UserService');
Flight::register('bookService', 'BookService');
Flight::register('categoryService', 'CategoryService');
Flight::register('orderService', 'OrderService');
Flight::register('orderItemService', 'OrderItemService');
Flight::register('reviewService', 'ReviewService');

Flight::route('/*', function () {
    $path = str_replace('/index.php', '', Flight::request()->url);
    $method = Flight::request()->method;
    $timestamp = date('Y-m-d H:i:s');
    $user = 'GUEST';

    if (
        str_starts_with($path, '/auth/login') ||
        str_starts_with($path, '/auth/register') ||
        str_starts_with($path, '/docs')
    ) {
        $log_line = "[$timestamp] $method $path by $user\n";
        file_put_contents(__DIR__ . '/logs/access.log', $log_line, FILE_APPEND);
        return true;
    }

    $headers = getallheaders();
    file_put_contents(__DIR__ . '/debug_headers.log', print_r($headers, true));

    try {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;
        
        if (!$token) {
            Flight::halt(401, "Missing authentication header");
        }

        if (str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7); 
        }

        $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        $user = $decoded->user->email ?? 'UNKNOWN';

        Flight::set('user', $decoded->user);
        Flight::set('jwt_token', $token);

        $log_line = "[$timestamp] $method $path by $user\n";
        file_put_contents(__DIR__ . '/logs/access.log', $log_line, FILE_APPEND);

    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

require_once __DIR__ . '/routes/AuthRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/BookRoutes.php';
require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/OrderRoutes.php';
require_once __DIR__ . '/routes/OrderItemRoutes.php';
require_once __DIR__ . '/routes/ReviewRoutes.php';

Flight::route('/', function () {
    echo '📚 WebDevProject API is running!';
});

Flight::start();
