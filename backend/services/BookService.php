<?php
require_once __DIR__ . '/../dao/BookDao.php';
require_once __DIR__ . '/BaseService.php';

class BookService extends BaseService {
    public function __construct() {
        parent::__construct(new BookDao());
    }
}
