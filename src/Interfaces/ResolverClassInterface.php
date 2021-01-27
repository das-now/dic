<?php

namespace DevCoder\DependencyInjection\Interfaces;


use Psr\Container\ContainerInterface;

interface ResolverClassInterface
{
    /**
     * @param string $class
     * @param ContainerInterface $container
     * @return object
     * @throws \Exception
     */
    public function resolve(string $class, ContainerInterface $container): object;
}