<?php
namespace Veles\Tests\Cache\Adapters;

use Exception;
use Veles\Cache\Adapters\MemcachedAdapter;
use Veles\Cache\Adapters\MemcacheRaw;
use Veles\Cache\Cache;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-10-23 at 18:02:03.
 * @group memcacheraw
 */
class MemcacheRawTest extends \PHPUnit_Framework_TestCase
{
	protected static $tpl;

	/**
	 * Cache adapter can be reset in other tests
	 */
	public static function setUpBeforeClass()
	{
		Cache::setAdapter(MemcachedAdapter::instance());

		$prefix = uniqid();
		self::$tpl = uniqid("$prefix::VELES::UNIT-TEST::");
		Cache::set(self::$tpl, uniqid(), 10);
	}

	public static function tearDownAfterClass()
	{
		Cache::del(self::$tpl);
	}

	/**
	 * Restore correct memcache settings for next tests
	 */
	public function tearDown()
	{
		MemcacheRaw::setConnectionParams('localhost', 11211);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::__construct
	 * @expectedException Exception
	 * @expectedExceptionMessage Can not connect to Memcache. Host: localhost Port: 11213
	 */
	public function testConstructor()
	{
		$object = new MemcacheRawChild;

		$connection = $object->getConnection();

		$msg = 'Wrong type of connection property';
		$this->assertInternalType('resource', $connection, $msg);

		MemcacheRaw::setConnectionParams('localhost', 11213);
		new MemcacheRawChild;
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::setConnectionParams
	 */
	public function testSetConnectionParams()
	{
		$object = new MemcacheRawChild;

		$host = uniqid();
		$port = mt_rand(55000, 56000);

		MemcacheRaw::setConnectionParams($host, $port);

		$result = $object->getHost();

		$msg = 'Wrong MemcacheRaw::$host result';
		$this->assertSame($host, $result, $msg);
		$this->assertInternalType('string', $result, $msg);

		$result = $object->getPort();

		$msg = 'Wrong MemcacheRaw::$port result';
		$this->assertSame($port, $result, $msg);
		$this->assertInternalType('integer', $result, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::disconnect
	 */
	public function testDisconnect()
	{
		$object = new MemcacheRawChild;
		$result = $object->disconnect();

		$msg = 'MemcacheRaw::disconnect return wrong result!';
		$this->assertSame(true, $result, $msg);

		 // @FIXME There is difference between PHP and HHVM in variables types cleanup at runtime. HHVM shows that $this->connection type is stream.
		if (!defined('HHVM_VERSION')) {
			$result = get_resource_type($object->getConnection());

			$msg = 'Wrong type of MemcacheRaw::$connection!';
			$this->assertSame('Unknown', $result, $msg);
		}
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::command
	 */
	public function testCommand()
	{
		$key   = uniqid('VELES::UNIT-TEST::');
		$value = uniqid();
		Cache::set($key, $value, 10);

		$object = new MemcacheRawChild;
		$result = $object->command("delete $key");

		$actual = Cache::has($key);
		$msg = 'MemcacheRaw::command() malfunction!';
		$this->assertSame(false, $actual, $msg);
		$msg = 'MemcacheRaw::command() returns wrong result!';
		$this->assertSame("DELETED\r\n", $result, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::getSlabs
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::delByTemplate
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::delete
	 */
	public function testDelByTemplate()
	{
		$keys     = [];
		$postfix  = uniqid();
		$template = "VELES::UNIT-TEST::$postfix::";

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid($template);
			Cache::set($key, uniqid(), 10);
			$keys[] = $key;
		}

		$object = new MemcacheRaw;
		$result = $object->delByTemplate($template);

		$msg = 'MemcacheRaw::delByTemplate return wrong result!';
		$this->assertTrue($result instanceof MemcacheRaw, $msg);

		$expected = $actual = false;
		foreach ($keys as $key) {
			if (Cache::has($key)) {
				$actual = true;
				break;
			}
		}

		$msg = 'MemcacheRaw::delByTemplate malfunction!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Cache\Adapters\MemcacheRaw::query
	 */
	public function testQuery()
	{
		$key    = uniqid("VELES::UNIT-TEST::");
		$value  = mt_rand(0, 1000);
		Cache::set($key, $value, 100);

		$object = new MemcacheRaw;

		$output = $object->query("get $key");
		$expr = "/^VALUE $key [\d\s]+$value\s$/";
		$result = preg_match($expr, $output);

		$msg = 'MemcacheRaw::query return wrong result!';
		$this->assertSame(1, $result, $msg);
	}
}
