<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Adapters\MemcachedAdapter;

class MemcachedAdapterChild extends MemcachedAdapter
{
	public function __construct($driver)
	{
		$this->driver = $driver;
	}
}
