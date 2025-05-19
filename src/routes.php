<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Hello, World!");
        return $response;
    });
    
    $app->get('/users', function (Request $request, Response $response) {
        $users = ['Alice', 'Bob', 'Charlie'];
        $response->getBody()->write(json_encode($users));
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    $app->post('/users', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        // You would save $data to the database here
        $response->getBody()->write(json_encode(['status' => 'User created']));
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    $app->get('/users/{id}', function (Request $request, Response $response, array $args) {
        $id = $args['id'];
        $response->getBody()->write("User ID: $id");
        return $response;
    });
};