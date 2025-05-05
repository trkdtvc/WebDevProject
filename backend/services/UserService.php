<?php
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/BaseService.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }
}
