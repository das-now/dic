<?php
/**
 * Resolver interface.
 *
 * @package DasNow\dic
 */

namespace DasNow\dic\Interfaces;

use Psr\Container\ContainerInterface;

/**
 * Interface ResolverClassInterface.
 */
interface ResolverClassInterface {
	/**
	 * Resolving class.
	 *
	 * @param string             $class          Class name.
	 * @param ContainerInterface $container      Container object.
	 *
	 * @return object       Resolved class.
	 *
	 * @throws \Exception   If can't resolve class.
	 */
	public function resolve( string $class, ContainerInterface $container ): object;
}
