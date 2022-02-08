<?php

namespace Components;

use Exception;
use ReflectionClass;

class MyDIContainer
{
    private static $instance;
    private static $services = [];

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function has($name): bool
    {
        return isset(self::$services[$name]);
    }

    /**
     * @throws \ReflectionException
     */
    public function get($name): object
    {
        if (isset(self::$services[$name])) {
            return self::$services[$name];
        }

        $value = $this->resolve($name);
        self::$services[$name] = $value;

        return $value;
    }

    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public function resolve($name): object
    {
        $reflector = new ReflectionClass($name);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class $name is not instantiable");
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @throws Exception
     */
    public function getDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (is_null($dependency)) {
                throw new Exception('Undefined class');
            }

            $dependencies[] = $this->get($dependency->name);
        }

        return $dependencies;
    }

}

