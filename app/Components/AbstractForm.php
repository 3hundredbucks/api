<?php

namespace Components;

abstract class AbstractForm
{
    private array $errors = [];

    abstract public function validate();

    public function addError($message)
    {
        $this->errors[] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
