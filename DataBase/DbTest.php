<?php
namespace Veles\Tests\DataBase;

use Exception;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\Db;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-11 at 15:34:36.
 * @group db
 */
class DbTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PdoAdapter
	 */
	protected $adapter;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->adapter = new PdoAdapter;
	}

	protected function tearDown()
	{
		DbCopy::unsetAdapter();
	}

	/**
	 * @covers Veles\DataBase\Db::setAdapter
	 */
	public function testSetAdapter()
	{
		$expected = $this->adapter;
		Db::setAdapter($expected);

		$msg = 'Wrong Db::setAdapter() behavior!';
		$this->assertAttributeEquals(
			$expected, 'adapter', 'Veles\DataBase\Db', $msg
		);
	}

	/**
	 * @covers Veles\DataBase\Db::getAdapter
	 */
	public function testGetAdapter()
	{
		Db::setAdapter($this->adapter);

		$actual = Db::getAdapter();

		$msg = 'Db::getAdapter() returns wrong result!';
		$this->assertSame($actual, $this->adapter, $msg);
	}

	/**
	 * @covers Veles\DataBase\Db::getAdapter
	 * @expectedException Exception
	 * @expectedExceptionMessage Adapter not set!
	 */
	public function testGetAdapterException()
	{
		Db::getAdapter();
	}

	/**
	 * @covers Veles\DataBase\Db::connection
	 */
	public function testConnection()
	{
		$expected = 'connection name';

		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['setConnection'])
			->getMock();
		$adapter->expects($this->once())
			->method('setConnection')
			->with($expected)
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::connection($expected);
	}

	/**
	 * @covers       Veles\DataBase\Db::value
	 *
	 * @dataProvider valueProvider
	 *
	 * @param $adapter
	 * @param $sql
	 * @param $params
	 * @param $types
	 */
	public function testValue($adapter, $sql, $params, $types)
	{
		Db::setAdapter($adapter);

		if ($types)
			Db::value($sql, $params, $types);
		elseif ($params)
			Db::value($sql, $params);
		else
			Db::value($sql);
	}

	public function valueProvider()
	{
		$sql1    = 'SELECT * FROM table_one';
		$params1 = [1, 1];
		$types1  = 'is';

		$adapter1 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['value'])
			->getMock();
		$adapter1->expects($this->once())
			->method('value')
			->with($sql1, $params1, $types1)
			->willReturn($adapter1);

		$sql2    = 'SELECT * FROM table_two';
		$params2 = [1, 2];
		$types2  = null;

		$adapter2 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['value'])
			->getMock();
		$adapter2->expects($this->once())
			->method('value')
			->with($sql2, $params2, $types2)
			->willReturn($adapter2);

		$sql3    = 'SELECT * FROM table_three';
		$params3 = [];
		$types3  = null;

		$adapter3 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['value'])
			->getMock();
		$adapter3->expects($this->once())
			->method('value')
			->with($sql3, $params3, $types3)
			->willReturn($adapter3);

		return [
			[$adapter1, $sql1, $params1, $types1],
			[$adapter2, $sql2, $params2, $types2],
			[$adapter3, $sql3, $params3, $types3]
		];
	}

	/**
	 * @covers       Veles\DataBase\Db::row
	 *
	 * @dataProvider rowProvider
	 *
	 * @param $adapter
	 * @param $sql
	 * @param $params
	 * @param $types
	 */
	public function testRow($adapter, $sql, $params, $types)
	{
		Db::setAdapter($adapter);

		if ($types)
			Db::row($sql, $params, $types);
		elseif ($params)
			Db::row($sql, $params);
		else
			Db::row($sql);
	}

	public function rowProvider()
	{
		$sql1    = 'SELECT * FROM table_one';
		$params1 = [1, 1];
		$types1  = 'is';

		$adapter1 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter1->expects($this->once())
			->method('row')
			->with($sql1, $params1, $types1)
			->willReturn($adapter1);

		$sql2    = 'SELECT * FROM table_two';
		$params2 = [1, 2];
		$types2  = null;

		$adapter2 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter2->expects($this->once())
			->method('row')
			->with($sql2, $params2, $types2)
			->willReturn($adapter2);

		$sql3    = 'SELECT * FROM table_three';
		$params3 = [];
		$types3  = null;

		$adapter3 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter3->expects($this->once())
			->method('row')
			->with($sql3, $params3, $types3)
			->willReturn($adapter3);

		return [
			[$adapter1, $sql1, $params1, $types1],
			[$adapter2, $sql2, $params2, $types2],
			[$adapter3, $sql3, $params3, $types3]
		];
	}

	/**
	 * @covers       Veles\DataBase\Db::rows
	 *
	 * @dataProvider rowsProvider
	 *
	 * @param $adapter
	 * @param $sql
	 * @param $params
	 * @param $types
	 */
	public function testRows($adapter, $sql, $params, $types)
	{
		Db::setAdapter($adapter);

		if ($types)
			Db::rows($sql, $params, $types);
		elseif ($params)
			Db::rows($sql, $params);
		else
			Db::rows($sql);
	}

	public function rowsProvider()
	{
		$sql1    = 'SELECT * FROM table_one';
		$params1 = [1, 1];
		$types1  = 'is';

		$adapter1 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['rows'])
			->getMock();
		$adapter1->expects($this->once())
			->method('rows')
			->with($sql1, $params1, $types1)
			->willReturn($adapter1);

		$sql2    = 'SELECT * FROM table_two';
		$params2 = [1, 2];
		$types2  = null;

		$adapter2 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['rows'])
			->getMock();
		$adapter2->expects($this->once())
			->method('rows')
			->with($sql2, $params2, $types2)
			->willReturn($adapter2);

		$sql3    = 'SELECT * FROM table_three';
		$params3 = [];
		$types3  = null;

		$adapter3 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['rows'])
			->getMock();
		$adapter3->expects($this->once())
			->method('rows')
			->with($sql3, $params3, $types3)
			->willReturn($adapter3);

		return [
			[$adapter1, $sql1, $params1, $types1],
			[$adapter2, $sql2, $params2, $types2],
			[$adapter3, $sql3, $params3, $types3]
		];
	}

	/**
	 * @covers       Veles\DataBase\Db::query
	 *
	 * @dataProvider queryProvider
	 *
	 * @param $adapter
	 * @param $sql
	 * @param $params
	 * @param $types
	 */
	public function testQuery($adapter, $sql, $params, $types)
	{
		Db::setAdapter($adapter);

		if ($types)
			Db::query($sql, $params, $types);
		elseif ($params)
			Db::query($sql, $params);
		else
			Db::query($sql);
	}

	public function queryProvider()
	{
		$sql1    = 'SELECT * FROM table_one';
		$params1 = [1, 1];
		$types1  = 'is';

		$adapter1 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['query'])
			->getMock();
		$adapter1->expects($this->once())
			->method('query')
			->with($sql1, $params1, $types1)
			->willReturn($adapter1);

		$sql2    = 'SELECT * FROM table_two';
		$params2 = [1, 2];
		$types2  = null;

		$adapter2 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['query'])
			->getMock();
		$adapter2->expects($this->once())
			->method('query')
			->with($sql2, $params2, $types2)
			->willReturn($adapter2);

		$sql3    = 'SELECT * FROM table_three';
		$params3 = [];
		$types3  = null;

		$adapter3 = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['query'])
			->getMock();
		$adapter3->expects($this->once())
			->method('query')
			->with($sql3, $params3, $types3)
			->willReturn($adapter3);

		return [
			[$adapter1, $sql1, $params1, $types1],
			[$adapter2, $sql2, $params2, $types2],
			[$adapter3, $sql3, $params3, $types3]
		];
	}

	/**
	 * @covers Veles\DataBase\Db::begin
	 */
	public function testBegin()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['begin'])
			->getMock();
		$adapter->expects($this->once())
			->method('begin')
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::begin();
	}

	/**
	 * @covers Veles\DataBase\Db::rollback
	 */
	public function testRollback()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['rollback'])
			->getMock();
		$adapter->expects($this->once())
			->method('rollback')
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::rollback();
	}

	/**
	 * @covers Veles\DataBase\Db::commit
	 */
	public function testCommit()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['commit'])
			->getMock();
		$adapter->expects($this->once())
			->method('commit')
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::commit();
	}

	/**
	 * @covers Veles\DataBase\Db::getLastInsertId
	 */
	public function testGetLastInsertId()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['getLastInsertId'])
			->getMock();
		$adapter->expects($this->once())
			->method('getLastInsertId')
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::getLastInsertId();
	}

	/**
	 * @covers Veles\DataBase\Db::getFoundRows
	 */
	public function testGetFoundRows()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['getFoundRows'])
			->getMock();
		$adapter->expects($this->once())
			->method('getFoundRows')
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::getFoundRows();
	}

	/**
	 * @covers Veles\DataBase\Db::escape
	 */
	public function testEscape()
	{
		$expected = 'string';

		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['escape'])
			->getMock();
		$adapter->expects($this->once())
			->method('escape')
			->with($expected)
			->willReturn($adapter);

		Db::setAdapter($adapter);
		Db::escape($expected);
	}
}
