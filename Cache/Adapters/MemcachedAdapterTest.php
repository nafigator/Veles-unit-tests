<?php
namespace Veles\Tests\Cache\Adapters;

use Memcached;
use PHPUnit\Framework\TestCase;
use Veles\Cache\Adapters\MemcachedAdapter;
use Veles\Cache\Adapters\MemcacheRaw;

require_once 'fsockopen_stub.php';
require_once 'fclose_stub.php';
require_once 'fgets_stub.php';
require_once 'fwrite_stub.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-06 at 15:06:37.
 * @group memcached
 */
class MemcachedAdapterTest extends TestCase
{
	/**
	 * @var MemcachedAdapter
	 */
	protected $object;

	public static function setUpBeforeClass(): void
	{
		MemcachedAdapterChild::unsetInstance();
	}

	public function testGet(): void
	{
		$key = uniqid();
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['get'])
			->getMock();

		$driver->method('get')
			->with($key)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->get($key);

		$msg = 'Wrong MemcachedAdapter::get() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testSet(): void
	{
		$key = uniqid();
		$value = uniqid();
		$ttl = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['set'])
			->getMock();

		$driver->method('set')
			->with($key, $value, $ttl)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->set($key, $value, $ttl);

		$msg = 'Wrong MemcachedAdapter::set() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testAdd(): void
	{
		$key = uniqid();
		$value = uniqid();
		$ttl = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['add'])
			->getMock();

		$driver->method('add')
			->with($key, $value, $ttl)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->add($key, $value, $ttl);

		$msg = 'Wrong MemcachedAdapter::add() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testHas(): void
	{
		$key = uniqid();
		$return = uniqid();
		$expected = (bool) $return;

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['get'])
			->getMock();

		$driver->method('get')
			->with($key)
			->willReturn($return);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->has($key);

		$msg = 'Wrong MemcachedAdapter::has() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testDel(): void
	{
		$key = uniqid();
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['delete'])
			->getMock();

		$driver->method('delete')
			->with($key)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->del($key);

		$msg = 'Wrong MemcachedAdapter::del() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testIncrement(): void
	{
		$key = uniqid();
		$offset = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['increment'])
			->getMock();

		$driver->method('increment')
			->with($key, $offset)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->increment($key, $offset);

		$msg = 'Wrong MemcachedAdapter::increment() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testDecrement(): void
	{
		$key = uniqid();
		$offset = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['decrement'])
			->getMock();

		$driver->method('decrement')
			->with($key, $offset)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->decrement($key, $offset);

		$msg = 'Wrong MemcachedAdapter::decrement() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testClear(): void
	{
		$expected = true;

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['flush'])
			->getMock();

		$driver->method('flush')
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->clear();

		$msg = 'Wrong MemcachedAdapter::clear() result!';
		self::assertSame($expected, $actual, $msg);
	}

	/**
	 * @dataProvider delByTemplateProvider
	 */
	public function testDelByTemplate($host, $port, $tpl, $expected): void
	{
		MemcacheRaw::setConnectionParams($host, $port);

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)->getMock();

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->delByTemplate($tpl);

		$msg = 'Wrong MemcachedAdapter::delByTemplate() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function delByTemplateProvider(): array
	{
		return [
			[
				'VELES_UNIT_TEST_MEMCACHED_ADAPTER',
				rand(10600, 15000),
				uniqid(),
				true
			],
			[
				'localhost',
				rand(10600, 15000),
				uniqid(),
				false
			]
		];
	}
}
