<?php

namespace Test\DevCoder;



use DevCoder\DependencyInjection\Container;
use DevCoder\DependencyInjection\Exception\ContainerException;
use DevCoder\DependencyInjection\Exception\NotFoundException;
use DevCoder\DependencyInjection\ReflectionResolver;
use PHPUnit\Framework\TestCase;
use Test\DevCoder\TestClass\Database;
use Test\DevCoder\TestClass\LazyService;
use Test\DevCoder\TestClass\Mailer;
use Test\DevCoder\TestClass\Parameters;

/**
 * Class AutoWireTest
 * @package Test\DevCoder
 */
class AutoWireTest extends TestCase {

    public function testAutoWire()
    {
        $container = new Container([], new ReflectionResolver());

        $this->assertTrue($container->has(LazyService::class));
        $this->assertTrue($container->has(Database::class));

        $database = $container->get(Database::class);
        /**
         * @var LazyService $service
         */
        $service = $container->get(LazyService::class);
        $this->assertInstanceOf(LazyService::class, $service);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertSame($database, $service->getDatabase());
    }

    public function testAutoWireDefaultParameter()
    {
        $container = new Container([], new ReflectionResolver());
        $this->assertInstanceOf(Parameters::class, $container->get(Parameters::class));

        $this->expectException(ContainerException::class);
        $container->get(Mailer::class);
    }

    public function testAutoWireInverse()
    {
        $container = new Container([], new ReflectionResolver());

        /**
         * @var LazyService $service
         */
        $service = $container->get(LazyService::class);
        $this->assertSame($container->get(Database::class), $service->getDatabase());
    }

}