<?php
require_once __DIR__ . '/../dao/OrderItemDao.php';
require_once __DIR__ . '/BaseService.php';

class OrderItemService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderItemDao());
    }
}
