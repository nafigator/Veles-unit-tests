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

	/**
	 * For each test set up adapter
	 */
	public function setUp()
	{

		//$this->object = Cache::getAdapter();
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::__construct
	 */
	public function testConstruct()
	{
		$object = MemcachedAdapter::instance();
		$expected = 'Memcached';

		$msg = 'Wrong result driver inside MemcachedAdapter!';
		$this->assertAttributeInstanceOf($expected, 'driver', $object, $msg);

	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::get
	 */
	public function testGet()
	{
		$key = uniqid();
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['get'])
			->getMock();

		$driver->method('get')
			->with($key)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->get($key);

		$msg = 'Wrong MemcachedAdapter::get() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::set
	 */
	public function testSet()
	{
		$key = uniqid();
		$value = uniqid();
		$ttl = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['set'])
			->getMock();

		$driver->method('set')
			->with($key, $value, $ttl)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->set($key, $value, $ttl);

		$msg = 'Wrong MemcachedAdapter::set() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::add
	 */
	public function testAdd()
	{
		$key = uniqid();
		$value = uniqid();
		$ttl = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['add'])
			->getMock();

		$driver->method('add')
			->with($key, $value, $ttl)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->add($key, $value, $ttl);

		$msg = 'Wrong MemcachedAdapter::add() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::has
	 */
	public function testHas()
	{
		$key = uniqid();
		$return = uniqid();
		$expected = (bool) $return;

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['get'])
			->getMock();

		$driver->method('get')
			->with($key)
			->willReturn($return);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->has($key);

		$msg = 'Wrong MemcachedAdapter::has() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::del
	 */
	public function testDel()
	{
		$key = uniqid();
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['delete'])
			->getMock();

		$driver->method('delete')
			->with($key)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->del($key);

		$msg = 'Wrong MemcachedAdapter::del() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::increment
	 */
	public function testIncrement()
	{
		$key = uniqid();
		$offset = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['increment'])
			->getMock();

		$driver->method('increment')
			->with($key, $offset)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->increment($key, $offset);

		$msg = 'Wrong MemcachedAdapter::increment() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::decrement
	 */
	public function testDecrement()
	{
		$key = uniqid();
		$offset = mt_rand(0, 100);
		$expected = uniqid();

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['decrement'])
			->getMock();

		$driver->method('decrement')
			->with($key, $offset)
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->decrement($key, $offset);

		$msg = 'Wrong MemcachedAdapter::decrement() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcachedAdapter::clear
	 */
	public function testClear()
	{
		$expected = true;

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)
			->setMethods(['flush'])
			->getMock();

		$driver->method('flush')
			->willReturn($expected);

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->clear();

		$msg = 'Wrong MemcachedAdapter::clear() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers       \Veles\Cache\Adapters\MemcachedAdapter::delByTemplate
	 *
	 * @dataProvider delByTemplateProvider
	 *
	 * @param $host
	 * @param $port
	 * @param $tpl
	 * @param $expected
	 */
	public function testDelByTemplate($host, $port, $tpl, $expected)
	{
		MemcacheRaw::setConnectionParams($host, $port);

		/** @var Memcached $route */
		$driver = $this->getMockBuilder(Memcached::class)->getMock();

		$object = (new MemcachedAdapterChild())->setDriver($driver);
		$actual = $object->delByTemplate($tpl);

		$msg = 'Wrong MemcachedAdapter::delByTemplate() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function delByTemplateProvider()
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
