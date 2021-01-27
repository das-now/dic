<?php

namespace DevCoder\DependencyInjection\Interfaces;

use Psr\Container\ContainerInterface;

/**
 * Interface ResolverClassInterface
 * @package DevCoder\DependencyInjection\Interfaces
 */
interface ResolverClassInterface
{
    /**
     * @param string $class
     * @param ContainerInterface $container
     * @return object
     * @throws \Exception if can't resolve class
     */
    public function resolve(string $class, ContainerInterface $container): object;
}
