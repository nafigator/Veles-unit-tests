<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcachedAdapter;

class MemcachedAdapterChild extends MemcachedAdapter
{
	public function __construct()
	{
	}

	public static function unsetInstance()
	{
		static::$instance = null;
	}
}
