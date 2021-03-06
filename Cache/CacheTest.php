<?php
namespace Veles\Tests\Cache;

use Exception;
use Memcached;
use PHPUnit\Framework\TestCase;
use Veles\Cache\Adapters\CacheAdapterInterface;
use Veles\Cache\Adapters\MemcachedAdapter;
use Veles\Cache\Adapters\MemcacheRaw;
use Veles\Tests\Cache\Adapters\MemcachedAdapterChild;

require_once 'Adapters/fsockopen_stub.php';
require_once 'Adapters/fclose_stub.php';
require_once 'Adapters/fgets_stub.php';
require_once 'Adapters/fwrite_stub.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-02 at 17:46:39.
 * @group cache
 */
class CacheTest extends TestCase
{
	public static function setUpBeforeClass(): void
	{
		MemcachedAdapterChild::unsetInstance();
	}

	public function testGetAdapter(): void
	{
		Cache::setAdapter(MemcachedAdapter::instance());
		$result = Cache::getAdapter();

		self::assertInstanceOf(MemcachedAdapter::class, $result);
	}

	public function testSetAdapterException(): void
	{
		$this->expectException(Exception::class);

		Cache::unsetAdapter();
		Cache::getAdapter();
	}

	/**
	 * @dataProvider setProvider
	 */
	public function testSet($key, $value, $ttl, $expected): void
	{
		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['set'])
			->getMock();

		$driver->method('set')
			->with($key, $value, $ttl)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);

		$actual = (0 === $ttl)
			? Cache::set($key, $value)
			: Cache::set($key, $value, $ttl);

		$msg = 'Wrong Cache::set() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function setProvider(): array
	{
		return [
			[
				uniqid('VELES::UNIT-TEST::'),
				uniqid(),
				rand(1, 100),
				true
			],
			[
				uniqid('VELES::UNIT-TEST::'),
				uniqid(),
				null,
				true
			]
		];
	}

	/**
	 * @dataProvider setProvider
	 */
	public function testAdd($key, $value, $ttl, $expected): void
	{
		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['add'])
			->getMock();

		$driver->method('add')
			->with($key, $value, $ttl)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);

		$actual = (0 === $ttl)
			? Cache::add($key, $value)
			: Cache::add($key, $value, $ttl);

		$msg = 'Wrong Cache::add() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testGet(): void
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$expected = uniqid();

		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['get'])
			->getMock();

		$driver->method('get')
			->with($key)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = Cache::get($key);

		$msg = 'Wrong Cache::get() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testHas(): void
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$expected = true;

		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['get'])
			->getMock();

		$driver->method('get')
			->with($key)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = Cache::has($key);

		$msg = 'Wrong Cache::has() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testDel(): void
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$expected = true;

		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['delete'])
			->getMock();

		$driver->method('delete')
			->with($key)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = Cache::del($key);

		$msg = 'Wrong Cache::del() result!';
		self::assertSame($expected, $actual, $msg);
	}

	/**
	 * @dataProvider incrementProvider
	 */
	public function testIncrement($key, $offset, $expected): void
	{
		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['increment'])
			->getMock();

		$driver->method('increment')
			->with($key, $offset)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = ($offset > 1)
			? Cache::increment($key, $offset)
			: Cache::increment($key);

		$msg = 'Wrong Cache::increment() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function incrementProvider(): array
	{
		return [
			[
				uniqid('VELES::UNIT-TEST::'),
				rand(2, 100),
				true
			],
			[
				uniqid('VELES::UNIT-TEST::'),
				1,
				true
			]
		];
	}

	/**
	 * @dataProvider incrementProvider
	 */
	public function testDecrement($key, $offset, $expected): void
	{
		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['decrement'])
			->getMock();

		$driver->method('decrement')
			->with($key, $offset)
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = ($offset > 1)
			? Cache::decrement($key, $offset)
			: Cache::decrement($key);

		$msg = 'Wrong Cache::decrement() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testClear(): void
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$expected = true;

		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)
			->onlyMethods(['flush'])
			->getMock();

		$driver->method('flush')
			->willReturn($expected);

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = Cache::clear($key);

		$msg = 'Wrong Cache::clear() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testDelByTemplate(): void
	{
		$host = 'VELES_UNIT_TEST_MEMCACHED_ADAPTER';
		$port = rand(10600, 15000);

		MemcacheRaw::setConnectionParams($host, $port);

		$tpl = uniqid('VELES::UNIT-TEST::');
		$expected = true;

		/** @var Memcached $driver */
		$driver = $this->getMockBuilder(Memcached::class)->getMock();

		$adapter = (new MemcachedAdapterChild())->setDriver($driver);
		Cache::setAdapter($adapter);
		$actual = Cache::delByTemplate($tpl);

		$msg = 'Wrong Cache::delByTemplate() result!';
		self::assertSame($expected, $actual, $msg);
	}
}
