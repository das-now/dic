<?php

namespace Test\DevCoder;


use DevCoder\DependencyInjection\Container;
use DevCoder\DependencyInjection\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Test\DevCoder\TestClass\Database;
use Test\DevCoder\TestClass\LazyService;

/**
 * Class AutoWireTest
 * @package Test\DevCoder
 */
class ContainerTest extends TestCase
{

    public function testDefinition()
    {
        $container = new Container([
            'database.host' => '127.0.0.1',
            'database.port' => null,
            Database::class => static function (ContainerInterface $container) {
                return new Database();
            },
            LazyService::class => static function (ContainerInterface $container) {
                return new LazyService($container->get(Database::class));
            }
        ]);


        $database = $container->get(Database::class);
        /**
         * @var LazyService $service
         */
        $service = $container->get(LazyService::class);

        $this->assertEquals('127.0.0.1', $container->get('database.host'));
        $this->assertEquals(null, $container->get('database.port'));
        $this->assertInstanceOf(Database::class, $database);
        $this->assertInstanceOf(LazyService::class, $service);

        $this->assertSame($database, $service->getDatabase());
        $this->assertTrue($container->has(LazyService::class));
        $this->assertFalse($container->has('database.user'));
    }

    public function testNotFoundClass()
    {

        $container = new Container([]);

        $this->expectException(NotFoundException::class);
        $container->get(LazyService::class);
    }

    public function testNotFoundParameter()
    {

        $container = new Container([]);

        $this->expectException(NotFoundException::class);
        $container->get('database.user');
    }
}
