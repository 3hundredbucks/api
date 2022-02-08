<?php

namespace Controllers;

use Components\RegisterForm;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\User;
use Models\Role;
use Illuminate\Database\Capsule\Manager as DB;

class RegistrationController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function __invoke(Request $request): Response
    {
        $user = $request->getParsedBody();
        $validator = new RegisterForm($user);
        $errors = $validator->validate();

        if (!empty($errors)) {
            return $this->response->withStatus(401)->write(json_encode($errors));
        }

        $userId = DB::table('users')->insertGetId(
            ['name' => $user['name'], 'email' => $user['email'], 'password' => $user['password']]
        );

        $role = Role::where('role', $user['role'])->first();
        User::find($userId)->roles()->save($role);

        return $this->response->withStatus(201)->write(json_encode(['msg' => 'Registration success!']));
    }
}
