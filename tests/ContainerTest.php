<?php
/**
 * @package DasNow\Tests
 */

namespace DasNow\Tests;

use PHPUnit\Framework\TestCase;

use Psr\Container\ContainerInterface;

use DasNow\dic\Container;
use DasNow\dic\Exception\NotFoundException;
use DasNow\Tests\TestClass\Database;
use DasNow\Tests\TestClass\LazyService;

/**
 * Class AutoWireTest.
 */
class ContainerTest extends TestCase {

	/**
	 * Test definition.
	 *
	 * @return void
	 */
	public function testDefinition() {
		$container = new Container(
			array(
				'database.host'    => '127.0.0.1',
				'database.port'    => null,
				Database::class    => static function ( ContainerInterface $container ) {
					return new Database();
				},
				LazyService::class => static function ( ContainerInterface $container ) {
					return new LazyService( $container->get( Database::class ) );
				},
			)
		);

		$database = $container->get( Database::class );
		$service  = $container->get( LazyService::class );

		$this->assertEquals( '127.0.0.1', $container->get( 'database.host' ) );
		$this->assertEquals( null, $container->get( 'database.port' ) );
		$this->assertInstanceOf( Database::class, $database );
		$this->assertInstanceOf( LazyService::class, $service );

		$this->assertSame( $database, $service->getDatabase() );
		$this->assertTrue( $container->has( LazyService::class ) );
		$this->assertFalse( $container->has( 'database.user' ) );
	}

	/**
	 * Test Not Found Class.
	 *
	 * @return void
	 */
	public function testNotFoundClass() {

		$container = new Container( array() );

		$this->expectException( NotFoundException::class );
		$container->get( LazyService::class );
	}

	/**
	 * Test Not Found Parameter.
	 *
	 * @return void
	 */
	public function testNotFoundParameter() {

		$container = new Container( array() );

		$this->expectException( NotFoundException::class );
		$container->get( 'database.user' );
	}

}
