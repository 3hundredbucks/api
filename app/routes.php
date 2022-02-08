<?php

return [
    '/api/v1/auth' => [
        'method' => ['POST'], // Обработка только POST-запросов
        'action' => 'AuthController@index', // Какой метод контроллера будет запускаться
    ],
    '/api/v1/logout' => [
        'method' => ['GET'],
        'action' => 'AuthController@logout',
    ],
    '/api/v1/profile' => [
        'method' => ['GET'],
        'action' => 'ProfileController@index',
        'parameters' => [
            'id'
        ]
    ],
];
