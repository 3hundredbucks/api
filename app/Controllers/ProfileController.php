<?php

namespace Controllers;

use Slim\Http\Response;

class ProfileController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function index($id)
    {
        $msg = [
            'id' => $id->getAttribute('id'),
            'name' => 'Tony',
            'gender' => 'male',
        ];

        return $this->response->withStatus(201)->write(json_encode($msg));
    }
}

