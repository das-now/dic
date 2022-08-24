<?php
/**
 * @package DasNow\Tests
 */

namespace DasNow\Tests;

use PHPUnit\Framework\TestCase;

use DasNow\dic\Container;
use DasNow\dic\ReflectionResolver;
use DasNow\dic\Exception\ContainerException;
use DasNow\dic\Exception\NotFoundException;
use DasNow\Tests\TestClass\Database;
use DasNow\Tests\TestClass\LazyService;
use DasNow\Tests\TestClass\Mailer;
use DasNow\Tests\TestClass\Parameters;

/**
 * Class AutoWireTest.
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
