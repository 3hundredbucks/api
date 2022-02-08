<?php

namespace Components;

class AuthForm extends AbstractForm
{
    private array $request = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    function validate(): array
    {
        if (!$this->request['password']) {
            $this->addError('Password cannot be empty!');
        }

        if (!$this->request['email']) {
            $this->addError('Email cannot be empty!');
        }

        if (!filter_var($this->request['email'], FILTER_VALIDATE_EMAIL)) {
            $this->addError('Incorrect email');
        }

        return $this->getErrors();
    }
}

