<?php

namespace Controllers;

use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;
use DateTime;
use Models\User;
use Components\AuthForm;

class AuthController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function index(Request $request): Response
    {
        $user = $request->getParsedBody();
        $validator = new AuthForm($user);

        $data['token'] = $this->getToken();

        $errors = $validator->validate();

        if (!empty($errors)) {
            return $this->response->withStatus(401)->write(json_encode($errors));
        }

        $user = User::where('email', $user['email'])->first();

        if ($user && $user->getAttribute('password') === $user['password']) {
            return $this->response->withStatus(201)->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        }

        return $this->response->withStatus(401)->write(json_encode(['msg' => 'Wrong mail or password']));
    }

    public function logout(): Response
    {
        $msg = [
            'success' => true,
        ];

        return $this->response->withStatus(201)->write(json_encode($msg));
    }

    public function getToken(): string
    {
        $now = new DateTime();
        $jti = base64_encode(random_bytes(16));

        $secret = $_ENV['SECRET_KEY'];

        $payload = [
            'jti' => $jti,
            'iat' => $now->getTimestamp()
        ];

        return 'Bearer ' . JWT::encode($payload, $secret);
    }
}

