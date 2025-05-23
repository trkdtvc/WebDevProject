
<?php

require __DIR__ . '/../../../vendor/autoload.php';

use OpenApi\Generator;

header('Content-Type: application/json');

$openapi = Generator::scan([
    realpath(__DIR__ . '/doc_setup.php'),
    realpath(__DIR__ . '/../../../routes')
]);

echo $openapi->toJson();
