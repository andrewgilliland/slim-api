<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) {
        $payload = json_encode(['message' => 'Hello, World!']);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    // $app->get('/users', function (Request $request, Response $response) {
    //     $users = ['Alice', 'Bob', 'Charlie'];
    //     $response->getBody()->write(json_encode($users));
    //     return $response->withHeader('Content-Type', 'application/json');
    // });
    
    // $app->post('/users', function (Request $request, Response $response) {
    //     $data = $request->getParsedBody();
    //     // You would save $data to the database here
    //     $response->getBody()->write(json_encode(['status' => 'User created']));
    //     return $response->withHeader('Content-Type', 'application/json');
    // });
    
    $app->get('/customers/{id}', function (Request $request, Response $response, array $args) use ($container) {
        $id = $args['id'];
        
        $pdo = $container->get(PDO::class);

        $stmt = $pdo->prepare("SELECT * FROM `customers` WHERE `id` = $id");
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        $payload = json_encode($customer);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post( '/login', function ($request, $response) {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

        // Here you would check the credentials against your database
        if ($username === 'admin' && $password === 'password') {
            $response->getBody()->write(json_encode(['status' => 'Login successful']));
        } else {
            $response->getBody()->write(json_encode(['status' => 'Invalid credentials']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    });
};