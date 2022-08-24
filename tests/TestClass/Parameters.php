<?php
/**
 * Test Parameters class.
 *
 * @package DasNow\Tests
 */

namespace DasNow\Tests\TestClass;

class Parameters {
	/**
	 * @var array
	 */
	private $parameters = array();

	public function __construct( array $parameters = array() ) {
		$this->parameters = $parameters;
	}

}
