<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../vendor/autoload.php';

use OpenApi\Generator;

$openapi = Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../routes'
]);

header('Content-Type: application/json');
echo $openapi->toJson();
