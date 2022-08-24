<?php
/**
 * NotFoundExceptionInterface implementation.
 *
 * @package DasNow\dic
 */

namespace DasNow\dic\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException.
 */
class NotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface {

}
