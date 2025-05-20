<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Config\AppConfig;
use App\Database\Database;
use Slim\Factory\AppFactory;
use DI\Container;

// 1. Create container first
$container = new Container();

// 2. Set PDO in container
$dbConfig = AppConfig::db();
$db = new Database();
$pdo = $db->getConnection();
$container->set(PDO::class, $pdo);

// 3. Attach container to Slim before creating app
AppFactory::setContainer($container);
$app = AppFactory::create();

// 4. Pass app only to routes
(require __DIR__ . '/../src/routes.php')($app);

$app->run();