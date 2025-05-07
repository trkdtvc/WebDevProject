
<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/services/UserService.php';

Flight::register('user_service', 'UserService');

require_once __DIR__ . '/routes/UserRoutes.php';

Flight::route('GET /test', function () {
    echo "Test OK";
});

Flight::start();
