<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Config\AppConfig;
use Slim\Factory\AppFactory;
use App\Database\Database;

$dbConfig = AppConfig::db();
$app = AppFactory::create();
$db = new Database();
$pdo = $db->getConnection();

(require __DIR__ . '/../src/routes.php')($app);

$app->run();