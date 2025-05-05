<?php
require_once __DIR__ . '/../dao/OrderDao.php';
require_once __DIR__ . '/BaseService.php';

class OrderService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderDao());
    }
}
