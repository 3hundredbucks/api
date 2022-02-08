<?php

namespace Controllers;

use GuzzleHttp\Client;
use Slim\Http\Response;

class PostmanController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __invoke($response): Response
    {
        $client = new Client();
        $headers = getallheaders();

        $r = $client->request('GET', 'http://postman-echo.com/basic-auth',
            [
                'headers' => [
                    'Authorization' => $headers['Authorization'],
                ]
            ]
        );
        return $this->response->withStatus(201)->write($r->getBody()->getContents());
    }
}

