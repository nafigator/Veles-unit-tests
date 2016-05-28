<?php
namespace Veles\Tests\DataBase\Adapters;

use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-10 at 15:41:03.
 * @group database
 */
class PdoAdapterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PdoAdapter
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new PdoAdapter;
	}

	/**
	 * @covers Veles\DataBase\Adapters\PdoAdapter::getPool
	 */
	public function testGetPool()
	{
		$expected = new ConnectionPool();
		$this->object->setPool($expected);

		$result = $this->object->getPool();
		$msg = 'Wrong PdoAdapterTest::getPool() behavior';
		$this->assertSame($expected, $result, $msg);
		$this->assertAttributeEquals(null, 'connection_name', $this->object, $msg);
	}

	/**
	 * @covers Veles\DataBase\Adapters\PdoAdapter::setPool
	 */
	public function testSetPool()
	{
		$pool = new ConnectionPool;

		$this->object->setPool($pool);
		$msg = 'Wrong PdoAdapterTest::setPool() behavior';
		$this->assertAttributeEquals($pool, 'pool', $this->object, $msg);
		$this->assertAttributeEquals(null, 'connection_name', $this->object, $msg);

		$pool = new ConnectionPool;
		$connection = new PdoConnection('conn-name');
		$pool->addConnection($connection, true);
		$this->object->setPool($pool);

		$this->assertAttributeEquals('conn-name', 'connection_name', $this->object, $msg);
	}

	/**
	 * @covers Veles\DataBase\Adapters\PdoAdapter::setConnection
	 */
	public function testSetConnection()
	{
		$expected = 'conn-name';
		$actual = $this->object->setConnection($expected);
		$msg = 'Wrong PdoAdapter::setConnection() behavior';
		$this->assertAttributeEquals(null, 'resource', $this->object, $msg);
		$this->assertAttributeEquals('conn-name', 'connection_name', $this->object, $msg);

		$msg = 'Wrong PdoAdapter::setConnection() return value';
		$this->assertSame($this->object, $actual, $msg);
	}

	/**
	 * @covers Veles\DataBase\Adapters\PdoAdapter::getConnection
	 */
	public function testGetConnection()
	{
		$expected = 100;
		$conn = $this->getMockBuilder('\Veles\DataBase\ConnectionPools\ConnectionPool')
			->setMethods(['getResource'])
			->getMock();
		$conn->method('getResource')->willReturn($expected);

		$pool = $this->getMockBuilder('\Veles\DataBase\ConnectionPools\ConnectionPool')
			->setMethods(['getConnection'])
			->getMock();
		$pool->method('getConnection')->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->getConnection();
		$msg = 'Wrong PdoAdapter::getConnection() return value';
		$this->assertSame($expected, $actual, $msg);
	}
}
