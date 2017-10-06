<?php
namespace Veles\Tests\DataBase\Adapters;

use PDOStatement;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\ConnectionPools\ConnectionPool;
use Veles\DataBase\Connections\PdoConnection;
use \PDO;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-10 at 15:41:03.
 *
 * @group database
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
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
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::getPool
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
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::setPool
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
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::setConnection
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
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::getResource
	 */
	public function testGetResource()
	{
		$expected = 100;
		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($expected);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->getResource();
		$msg = 'Wrong PdoAdapter::getResource() return value';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::value
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::prepare
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::bindParams
	 */
	public function testValue()
	{
		$expected = 100;
		$params = [];
		$types = null;

		$stmt1 = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['fetchColumn'])
			->getMock();
		$stmt1->expects($this->once())
			->method('fetchColumn')
			->willReturn($expected);



		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->willReturn($stmt1);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->value('sql query', $params, $types);
		$msg = 'PdoAdapter::value() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::value
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::prepare
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::bindParams
	 */
	public function testValue1()
	{
		$expected = 100;
		$params = [200, 'string'];
		$types = 'is';

		$stmt2 = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['fetchColumn', 'bindValue'])
			->getMock();
		$stmt2->expects($this->once())
			->method('fetchColumn')
			->willReturn($expected);
		$stmt2->expects($this->exactly(2))
			->method('bindValue')
			->withConsecutive(
				[1, 200, PDO::PARAM_INT],
				[2, 'string', PDO::PARAM_STR]
			)
			->willReturn($expected);

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->willReturn($stmt2);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->value('sql query', $params, $types);
		$msg = 'PdoAdapter::value() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::value
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::prepare
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::throwExceptionWithInfo
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testValueException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);
		$sql    = 'SELECT * FROM users';
		$params = [300, 'string-value'];
		$types  = 'is';

		$this->object->value($sql, $params, $types);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::row
	 */
	public function testRow()
	{
		$expected = 100;

		$stmt = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['fetch'])
			->getMock();
		$stmt->expects($this->once())
			->method('fetch')
			->willReturn($expected);

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->willReturn($stmt);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->row('sql query', [], null);
		$msg = 'PdoAdapter::row() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::row
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testRowException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);
		$sql    = 'SELECT * FROM users';
		$params = [300, 'string-value'];
		$types  = 'is';

		$this->object->row($sql, $params, $types);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::rows
	 */
	public function testRows()
	{
		$expected = 100;

		$stmt = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['fetchAll'])
			->getMock();
		$stmt->expects($this->once())
			->method('fetchAll')
			->willReturn($expected);

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->willReturn($stmt);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->rows('sql query', [], null);
		$msg = 'PdoAdapter::rows() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::rows
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testRowsException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);
		$sql    = 'SELECT * FROM users';
		$params = [300, 'string-value'];
		$types  = 'is';

		$this->object->rows($sql, $params, $types);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::begin
	 */
	public function testBegin()
	{
		$expected = 100;

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['beginTransaction'])
			->getMock();
		$resource->expects($this->once())
			->method('beginTransaction')
			->willReturn($expected);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->begin();
		$msg = 'PdoAdapter::begin() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::begin
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testBeginException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['beginTransaction'])
			->getMock();
		$resource->expects($this->once())
			->method('beginTransaction')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$this->object->begin();
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::rollback
	 */
	public function testRollback()
	{
		$expected = 100;

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['rollBack'])
			->getMock();
		$resource->expects($this->once())
			->method('rollBack')
			->willReturn($expected);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->rollback();
		$msg = 'PdoAdapter::rollBack() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::rollback
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testRollbackException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['rollBack'])
			->getMock();
		$resource->expects($this->once())
			->method('rollBack')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$this->object->rollBack();
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::commit
	 */
	public function testCommit()
	{
		$expected = 100;

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['commit'])
			->getMock();
		$resource->expects($this->once())
			->method('commit')
			->willReturn($expected);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->commit();
		$msg = 'PdoAdapter::commit() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::commit
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testCommitException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['commit'])
			->getMock();
		$resource->expects($this->once())
			->method('commit')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$this->object->commit();
	}

	/**
	 * @covers       \Veles\DataBase\Adapters\PdoAdapter::query
	 *
	 * @dataProvider queryProvider
	 *
	 * @param $resource
	 * @param $expected
	 * @param $params
	 * @param $types
	 *
	 * @internal     param $stmt
	 */
	public function testQuery($resource, $expected, $params, $types)
	{
		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->query('sql query', $params, $types);
		$msg = 'PdoAdapter::query() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function queryProvider()
	{
		$stmt1 = $expected = true;

		$resource1 = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['query'])
			->getMock();
		$resource1->expects($this->once())
			->method('query')
			->willReturn($stmt1);

		$stmt2 = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['execute'])
			->getMock();
		$stmt2->expects($this->once())
			->method('execute')
			->willReturn($expected);

		$resource2 = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource2->expects($this->once())
			->method('prepare')
			->willReturn($stmt2);

		$stmt3 = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['bindValue', 'execute'])
			->getMock();
		$stmt3->expects($this->exactly(2))
			->method('bindValue')
			->withConsecutive(
				[$this->equalTo(1), $this->equalTo(200), $this->equalTo(PDO::PARAM_INT)],
				[$this->equalTo(2), $this->equalTo('string'), $this->equalTo(PDO::PARAM_STR)]
			);
		$stmt3->expects($this->once())
			->method('execute')
			->willReturn($expected);

		$resource3 = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource3->expects($this->once())
			->method('prepare')
			->willReturn($stmt3);

		return [
			[$resource1, $expected, [], null],
			[$resource2, $expected, ['string'], null],
			[$resource3, $expected, [200, 'string'], 'is']
		];
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::query
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testQueryException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['query'])
			->getMock();
		$resource->expects($this->once())
			->method('query')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);
		$sql    = 'DELETE FROM users';
		$params = [];
		$types  = null;

		$this->object->query($sql, $params, $types);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::getLastInsertId
	 */
	public function testGetLastInsertId()
	{
		$expected = 100;

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['lastInsertId'])
			->getMock();
		$resource->expects($this->once())
			->method('lastInsertId')
			->willReturn($expected);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->getLastInsertId();
		$msg = 'PdoAdapter::getLastInsertId() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::getLastInsertId
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testGetLastInsertIdException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['lastInsertId'])
			->getMock();
		$resource->expects($this->once())
			->method('lastInsertId')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$this->object->getLastInsertId();
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::getFoundRows
	 */
	public function testGetFoundRows()
	{
		$expected = 100;

		$stmt = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['fetchColumn'])
			->getMock();
		$stmt->expects($this->once())
			->method('fetchColumn')
			->willReturn($expected);

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->willReturn($stmt);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->getFoundRows();
		$msg = 'PdoAdapter::getFoundRows() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::getStmt
	 */
	public function testGetStmt()
	{
		$stmt = $this->getMockBuilder(PDOStatement::class)
			->setMethods(['fetchColumn'])
			->getMock();
		$stmt->expects($this->once())
			->method('fetchColumn');

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['prepare'])
			->getMock();
		$resource->expects($this->once())
			->method('prepare')
			->willReturn($stmt);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$this->object->value('sql query', [], null);

		$actual = $this->object->getStmt();
		$msg = 'PdoAdapter::getStmt() returns wrong result!';
		$this->assertSame($stmt, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::escape
	 */
	public function testEscape()
	{
		$expected = 'escaped string';

		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['quote'])
			->getMock();
		$resource->expects($this->once())
			->method('quote')
			->willReturn($expected);

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$actual = $this->object->escape('string');
		$msg    = 'PdoAdapter::escape() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Adapters\PdoAdapter::escape
	 *
	 * @expectedException \Veles\DataBase\Exceptions\DbException
	 */
	public function testEscapeException()
	{
		$exception_msg = 'SQLSTATE[22P02]: Invalid text representation: 7 ERROR: invalid input syntax for integer';
		$resource = $this->getMockBuilder(PDO::class)
			->disableOriginalConstructor()
			->setMethods(['quote'])
			->getMock();
		$resource->expects($this->once())
			->method('quote')
			->will($this->throwException(new \PDOException($exception_msg)));

		$conn = $this->getMockBuilder(PdoConnection::class)
			->setConstructorArgs(['master'])
			->setMethods(['getResource'])
			->getMock();
		$conn->expects($this->once())
			->method('getResource')
			->willReturn($resource);

		$pool = $this->getMockBuilder(ConnectionPool::class)
			->setMethods(['getConnection'])
			->getMock();
		$pool->expects($this->once())
			->method('getConnection')
			->willReturn($conn);

		$this->object->setPool($pool);

		$this->object->escape('string');
	}
}
