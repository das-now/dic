<?php

namespace DevCoder\DependencyInjection;

use DevCoder\DependencyInjection\Interfaces\ResolverClassInterface;
use Psr\Container\ContainerInterface;

class ReflectionResolver implements ResolverClassInterface
{
    /**
     * @param string $class
     * @param ContainerInterface $container
     * @return object
     * @throws \Exception
     */
    public function resolve(string $class, ContainerInterface $container): object
    {
        $reflectionClass = new \ReflectionClass($class);

        if (($constructor = $reflectionClass->getConstructor()) === null) {
            return $reflectionClass->newInstance();
        }

        if (($params = $constructor->getParameters()) === []) {
            $reflectionClass->newInstance();
        }

        $newInstanceParams = [];
        foreach ($params as $param) {
            $newInstanceParams[] = $param->getClass() === null ? $param->getDefaultValue() : $container->get(
                $param->getClass()->getName()
            );
        }
//        var_dump($newInstanceParams);

        return $reflectionClass->newInstanceArgs(
            $newInstanceParams
        );
    }
}
