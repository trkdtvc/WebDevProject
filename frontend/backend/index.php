

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once 'dao/BookDao.php';
require_once 'dao/UserDao.php';
require_once 'dao/AuthorDao.php';
require_once 'dao/OrderDao.php';
require_once 'dao/OrderItemDao.php';

$bookDao = new BookDao();
$userDao = new UserDao();
$authorDao = new AuthorDao();
$orderDao = new OrderDao();
$orderItemDao = new OrderItemDao();

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_GET['url'] ?? '';

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function route($entity, $dao) {
    global $method, $uri;

    switch (true) {
        case $uri === $entity && $method === 'GET':
            echo json_encode($dao->getAll());
            break;

        case $uri === $entity && $method === 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $dao->insert($data);
            echo json_encode(["message" => "$entity inserted."]);
            break;

        case preg_match("/^$entity\/(\d+)$/", $uri, $matches) && $method === 'GET':
            echo json_encode($dao->getById($matches[1]));
            break;

        case preg_match("/^$entity\/(\d+)$/", $uri, $matches) && $method === 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);
            $dao->update($matches[1], $data);
            echo json_encode(["message" => "$entity updated."]);
            break;

        case preg_match("/^$entity\/(\d+)$/", $uri, $matches) && $method === 'DELETE':
            $dao->delete($matches[1]);
            echo json_encode(["message" => "$entity deleted."]);
            break;

        default:
            return false;
    }

    return true;
}

if (
    route("books", $bookDao) ||
    route("users", $userDao) ||
    route("authors", $authorDao) ||
    route("orders", $orderDao) ||
    route("order_items", $orderItemDao)
) {
    
} else {
    http_response_code(404);
    echo json_encode(["error" => "Route not found: $uri"]);
}
