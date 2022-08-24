<?php
/**
 * Class resolver.
 *
 * @package DasNow\dic
 */

namespace DasNow\dic;

use DasNow\dic\Interfaces\ResolverClassInterface;
use DasNow\dic\Exception\ContainerException;
use \Psr\Container\ContainerInterface;

/**
 * ReflectionResolver class.
 */
class ReflectionResolver implements ResolverClassInterface {

	/**
	 * Auto-wire class.
	 *
	 * @param string             $class       Class name.
	 * @param ContainerInterface $container   Container object.
	 *
	 * @return object        Instance of class.
	 *
	 * @throws ReflectionException   If the class constructor is not public.
	 * @throws ContainerException    If the param type is not defined.
	 */
	public function resolve( string $class, ContainerInterface $container ): object {
		$reflection_class = new \ReflectionClass( $class );

		$constructor = $reflection_class->getConstructor();
		if ( empty( $constructor ) ) {
			return $reflection_class->newInstance();
		}

		$params = $constructor->getParameters();
		if ( empty( $params ) ) {
			return $reflection_class->newInstance();
		}

		$new_instance_params = array();
		foreach ( $params as $param ) {

			$param_type = $param->getType();
			if ( $param->isDefaultValueAvailable() ) {

				$new_instance_params[ $param->getName() ] = $param->getDefaultValue();

			} else {

				if ( null === $param_type ) {
					throw new ContainerException( "Undefined type of '{$param->getName()}' parameter in constructor of '{$class}'." );
				}

				$new_instance_params[ $param->getName() ] = $container->get( $param_type->getName() );

			}
		}

		return $reflection_class->newInstanceArgs( $new_instance_params );
	}

}
