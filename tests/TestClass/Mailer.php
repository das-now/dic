<?php
/**
 * @package DasNow\Tests
 */

namespace DasNow\Tests\TestClass;

class Mailer {
	/**
	 * @var string
	 */
	private $user;
	/**
	 * @var string
	 */
	private $password;

	public function __construct(string $user, string $password)
	{
		$this->user = $user;
		$this->password = $password;
	}
}
