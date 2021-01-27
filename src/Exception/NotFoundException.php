<?php
namespace DevCoder\DependencyInjection\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * TestClass NotFoundException
 * @package DevCoder\DependencyInjection\Exception
 */
class NotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}
