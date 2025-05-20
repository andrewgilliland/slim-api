<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Config\AppConfig;
use Slim\Factory\AppFactory;

$dbConfig = AppConfig::db();
$app = AppFactory::create();

(require __DIR__ . '/../src/routes.php')($app);

$app->run();