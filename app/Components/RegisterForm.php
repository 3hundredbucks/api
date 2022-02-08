<?php

namespace Components;

class RegisterForm extends AbstractForm
{
    private array $request = [];
    const MIN_PAS = 5;
    const MAX_PAS = 20;

    public function __construct($request)
    {
        $this->request = $request;
    }

    function validate(): array
    {
        if (!$this->request['name']) {
            $this->addError('Name cannot be empty!');
        }

        if ((strlen($this->request['name']) < self::MIN_PAS || strlen($this->request['name']) > self::MAX_PAS)) {
            $this->addError('Name length should not be more than 20 and less than 5');
        }

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
