
<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/dao/CategoryDao.php';
require_once __DIR__ . '/dao/BookDao.php';
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/OrderDao.php';
require_once __DIR__ . '/dao/OrderItemDao.php';
require_once __DIR__ . '/dao/ReviewDao.php';

$entity = $_GET['entity'] ?? 'user';
$method = $_GET['method'] ?? 'GET';

switch (strtolower($entity)) {
    case 'category':
        $dao = new CategoryDao();
        break;
    case 'book':
        $dao = new BookDao();
        break;
    case 'user':
        $dao = new UserDao();
        break;
    case 'order':
        $dao = new OrderDao();
        break;
    case 'order_item':
        $dao = new OrderItemDao();
        break;
    case 'review':
        $dao = new ReviewDao();
        break;
    default:
        echo json_encode(['error' => 'Unknown entity']);
        exit;
}

switch (strtoupper($method)) {
    case 'POST':
        switch ($entity) {
            case 'category':
                echo json_encode($dao->add(['name' => $_GET['name'] ?? '']));
                break;
            case 'book':
                echo json_encode($dao->add([
                    'title' => $_GET['title'] ?? '',
                    'author' => $_GET['author'] ?? '',
                    'category_id' => $_GET['category_id'] ?? null,
                    'price' => $_GET['price'] ?? 0,
                    'stock' => $_GET['stock'] ?? 0,
                    'description' => $_GET['description'] ?? ''
                ]));
                break;
            case 'user':
                echo json_encode($dao->add([
                    'name' => $_GET['name'] ?? '',
                    'email' => $_GET['email'] ?? '',
                    'password' => $_GET['password'] ?? ''
                ]));
                break;
            case 'order':
                echo json_encode($dao->add([
                    'user_id' => $_GET['user_id'] ?? null,
                    'order_date' => date('Y-m-d H:i:s'),
                    'total_price' => $_GET['total_price'] ?? 0
                ]));
                break;
            case 'order_item':
                echo json_encode($dao->add([
                    'order_id' => $_GET['order_id'] ?? null,
                    'book_id' => $_GET['book_id'] ?? null,
                    'quantity' => $_GET['quantity'] ?? 1,
                    'price' => $_GET['price'] ?? 0
                ]));
                break;
            case 'review':
                echo json_encode($dao->add([
                    'user_id' => $_GET['user_id'] ?? null,
                    'book_id' => $_GET['book_id'] ?? null,
                    'rating' => $_GET['rating'] ?? null,
                    'comment' => $_GET['comment'] ?? '',
                    'review_date' => date('Y-m-d H:i:s')
                ]));
                break;
        }
        break;

    case 'GET':
        echo json_encode($dao->get_all());
        break;

    case 'UPDATE':
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'Missing ID']);
            break;
        }

        switch ($entity) {
            case 'category':
                echo json_encode($dao->update(['name' => $_GET['name'] ?? ''], $id));
                break;
            case 'book':
                echo json_encode($dao->update([
                    'title' => $_GET['title'] ?? '',
                    'author' => $_GET['author'] ?? '',
                    'category_id' => $_GET['category_id'] ?? null,
                    'price' => $_GET['price'] ?? 0,
                    'stock' => $_GET['stock'] ?? 0,
                    'description' => $_GET['description'] ?? ''
                ], $id));
                break;
            case 'user':
                echo json_encode($dao->update([
                    'name' => $_GET['name'] ?? '',
                    'email' => $_GET['email'] ?? '',
                    'password' => $_GET['password'] ?? ''
                ], $id));
                break;
            case 'order':
                echo json_encode($dao->update([
                    'user_id' => $_GET['user_id'] ?? null,
                    'order_date' => $_GET['order_date'] ?? date('Y-m-d H:i:s'),
                    'total_price' => $_GET['total_price'] ?? 0
                ], $id));
                break;
            case 'order_item':
                echo json_encode($dao->update([
                    'order_id' => $_GET['order_id'] ?? null,
                    'book_id' => $_GET['book_id'] ?? null,
                    'quantity' => $_GET['quantity'] ?? 1,
                    'price' => $_GET['price'] ?? 0
                ], $id));
                break;
            case 'review':
                echo json_encode($dao->update([
                    'user_id' => $_GET['user_id'] ?? null,
                    'book_id' => $_GET['book_id'] ?? null,
                    'rating' => $_GET['rating'] ?? null,
                    'comment' => $_GET['comment'] ?? ''
                ], $id));
                break;
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        echo $id ? json_encode($dao->delete($id)) : json_encode(['error' => 'Missing ID']);
        break;

    default:
        echo json_encode(['error' => 'Unsupported method']);
}
