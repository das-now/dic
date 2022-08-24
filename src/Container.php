<?php
/**
 * Dependency Injection Container.
 *
 * @package DasNow\dic
 */

namespace DasNow\dic;

use \Psr\Container\ContainerInterface;
use \Psr\Container\ContainerExceptionInterface;
use \Psr\Container\NotFoundExceptionInterface;

use DasNow\dic\Exception\ContainerException;
use DasNow\dic\Exception\NotFoundException;
use DasNow\dic\Interfaces\ResolverClassInterface;

/**
 * Container class
 */
class Container implements ContainerInterface {

	/**
	 * Classes and params.
	 *
	 * @var array
	 */
	private $definitions = array();

	/**
	 * Resolved services.
	 *
	 * @var array
	 */
	private $resolved_entries = array();

	/**
	 * Auto-wiring resolver.
	 *
	 * @var ResolverClassInterface|null
	 */
	private $resolver;

	/**
	 * Constructor.
	 *
	 * @param array                       $definitions     Initial definitions.
	 * @param ResolverClassInterface|null $resolver        Auto-wiring resolver.
	 */
	public function __construct( array $definitions, ?ResolverClassInterface $resolver = null ) {

		$this->definitions = array_merge( $definitions, array( ContainerInterface::class => $this ) );
		$this->resolver    = $resolver;

	}

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return mixed Entry.
	 *
	 * @throws ContainerExceptionInterface    Error while retrieving the entry.
	 * @throws NotFoundExceptionInterface     No entry was found for **this** identifier.
	 */
	public function get( $id ) {

		if ( false === $this->has( $id ) ) {
			throw new NotFoundException( "No entry or class found for '$id'" );
		}

		if ( array_key_exists( $id, $this->resolved_entries ) ) {
			return $this->resolved_entries[ $id ];
		}

		if ( array_key_exists( $id, $this->definitions ) ) {

			$value = $this->definitions[ $id ];

			if ( $value instanceof \Closure ) {

				$value = $value( $this );

			}
		} else {

			$value = $this->resolve( $id );

		}

		$this->resolved_entries[ $id ] = $value;

		return $value;

	}

	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
	 * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has( $id ): bool {

		if ( array_key_exists( $id, $this->definitions ) || array_key_exists( $id, $this->resolved_entries ) ) {
			return true;
		}

		return class_exists( $id ) && $this->resolver instanceof ResolverClassInterface;
	}

	/**
	 * Auto-wire resolver.
	 *
	 * @param string $class   Class name.
	 *
	 * @return object                          Instance of class.
	 *
	 * @throws ContainerException    On absence of resolver or on failed auto-wiring.
	 */
	private function resolve( string $class ): object {

		if ( $this->resolver instanceof ResolverClassInterface ) {

			try {

				return $this->resolver->resolve( $class, $this );

			} catch ( \Exception $e ) {
				throw new ContainerException( sprintf( 'Cannot auto-wire entry "%s" : %s', $class, $e->getMessage() ) );
			}
		}

		throw new ContainerException( 'Auto-wiring is disabled, resolver is missing' );
	}

}
