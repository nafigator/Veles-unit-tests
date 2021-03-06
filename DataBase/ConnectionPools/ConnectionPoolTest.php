<?php
namespace Veles\Tests\DataBase\ConnectionPools;

use PHPUnit\Framework\TestCase;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-10 at 13:36:51.
 * @group database
 */
class ConnectionPoolTest extends TestCase
{
	/**
	 * @var ConnectionPool
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new ConnectionPool;
	}

	public function testGetDefaultConnectionName(): void
	{
		$expected = 'test-name';
		$conn = new PdoConnection($expected);
		$this->object->addConnection($conn, true);

		$actual = $this->object->getDefaultConnectionName();

		$msg = 'Wrong ConnectionPool::getDefaultConnectionName() result';
		self::assertSame($expected, $actual, $msg);
	}

	public function testGetConnection(): void
	{
		$expected = null;

		$result = $this->object->getConnection('some-name');
		$msg = 'Wrong behavior of ConnectionPool::getConnection';
		self::assertSame($expected, $result, $msg);

		$expected = new PdoConnection('some-name');
		$this->object->addConnection($expected, true);

		$result = $this->object->getConnection('some-name');
		$msg = 'Wrong behavior of ConnectionPool::getConnection';
		self::assertSame($expected, $result, $msg);
	}
}
