<?php
/**
 * @package DasNow\Tests
 */

namespace DasNow\Tests\TestClass;

class LazyService {
	/**
	 * @var Database
	 */
	private $database;

	public function __construct(Database $database)
	{
		$this->database = $database;
	}

	/**
	 * @return Database
	 */
	public function getDatabase(): Database
	{
		return $this->database;
	}


}
