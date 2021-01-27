<?php

namespace Test\DevCoder;



use DevCoder\DependencyInjection\Container;
use DevCoder\DependencyInjection\ReflectionResolver;
use PHPUnit\Framework\TestCase;
use Test\DevCoder\TestClass\Database;
use Test\DevCoder\TestClass\LazyService;

/**
 * Class AutoWireTest
 * @package Test\DevCoder
 */
class AutoWireTest extends TestCase {

    public function testAutoWire()
    {
        $container = new Container([], new ReflectionResolver());

        $database = $container->get(Database::class);
        /**
         * @var LazyService $service
         */
        $service = $container->get(LazyService::class);
        $this->assertInstanceOf(LazyService::class, $service);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertSame($database, $service->getDatabase());
    }

    public function testAutoWireInverse()
    {
        $container = new Container([], new ReflectionResolver());

        /**
         * @var LazyService $service
         */
        $service = $container->get(LazyService::class);
        $this->assertInstanceOf(LazyService::class, $service);

        $database = $container->get(Database::class);

        $this->assertSame($database, $service->getDatabase());
    }

}