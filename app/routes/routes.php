<?php

use Slim\App;
use Controllers\PostmanController;
use Controllers\AuthController;
use Controllers\ProfileController;
use Tuupola\Middleware\JwtAuthentication;
use Controllers\RegistrationController;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new App(['settings' => $config]);

$app->add(new JwtAuthentication([
    'path' => '/api/v1',
    'ignore' => ['/api/v1/register', '/api/v1/auth', '/api/v1/postman/auth'],
    'secure' => false,
    'secret' => $_ENV['SECRET_KEY'],
    'algorithm' => ["HS256"],
    'error' => function ($response, $arguments) {
        $data['status'] = 'error';
        $data['message'] = $arguments['message'];
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->getBody()->write(json_encode($data));
    }
]));

$app->get('/api/v1/logout', AuthController::class . ':logout');

$app->get('/api/v1/profile/{id}', ProfileController::class . ':index');

$app->get('/api/v1/postman/auth', PostmanController::class);

$app->post('/token', AuthController::class . ':getToken');

$app->post('/api/v1/auth', AuthController::class . ':index');

$app->post('/api/v1/register', RegistrationController::class);

$app->run();