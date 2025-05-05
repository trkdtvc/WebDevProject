<?php
require_once __DIR__ . '/../dao/AuthorDao.php';
require_once __DIR__ . '/BaseService.php';

class AuthorService extends BaseService {
    public function __construct() {
        parent::__construct(new AuthorDao());
    }
}
