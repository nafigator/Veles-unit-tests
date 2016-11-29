<?php
namespace Veles\Tests\DataBase\Connections;

use Exception;
use PDO;
use Veles\DataBase\Connections\PdoConnection;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-11-27 at 17:40:33.
 * @group database
 */
class PdoConnectionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PdoConnection
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new PdoConnection('conn-name');
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::getDsn
	 * @expectedException Exception
	 * @expectedExceptionMessage Connection DSN not set.
	 */
	public function testGetDsnException()
	{
		$this->object->getDsn();
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::create
	 */
	public function testCreate()
	{
		$this->object->setDriver('\Veles\Tests\DataBase\Connections\PDOStub');
		$dsn = 'mysql:host=host;dbname=db_name;charset=utf8';
		$this->object->setDsn($dsn)
			->setUserName('user_name')
			->setPassword('password');

		$this->object->create();

		$msg = 'Wrong PdoConnection::create() result!';
		$this->assertAttributeInstanceOf('\PDO', 'resource', $this->object, $msg);

		$this->object->setCallback(
			'setAttribute', [PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ]
		);

		$this->object->create();

		$msg = 'Wrong PdoConnection::create() behavior!';
		$this->assertAttributeInstanceOf('\PDO', 'resource', $this->object, $msg);

		$expected = PDO::FETCH_OBJ;
		$actual = $this->object->getResource()->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);

		$msg = 'Wrong PdoConnection::create() behavior!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::setDsn
	 */
	public function testSetDsn()
	{
		$expected = 'mysql:dbname=testdb;host=127.0.0.1';
		$result = $this->object->setDsn($expected);

		$msg = 'Wrong PdoConnection::$dsn property value!';
		$this->assertAttributeEquals($expected, 'dsn', $this->object, $msg);

		$msg = 'Wrong PdoConnection::setDsn return value!';
		$this->assertSame($this->object, $result, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::getDsn
	 * @depends testSetDsn
	 */
	public function testGetDsn()
	{
		$expected = 'mysql:dbname=testdb;host=127.0.0.1';
		$this->object->setDsn($expected);

		$result = $this->object->getDsn();

		$msg = 'Wrong Connection::getDsn return result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::setOptions
	 */
	public function testSetOptions()
	{
		$expected = ['option-1', 'option-1'];
		$result = $this->object->setOptions($expected);

		$msg = 'Wrong PdoConnection::$options property value!';
		$this->assertAttributeEquals($expected, 'options', $this->object, $msg);

		$msg = 'Wrong PdoConnection::setOptions return value!';
		$this->assertSame($this->object, $result, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::getOptions
	 * @depends testSetOptions
	 */
	public function testGetOptions()
	{
		$expected = ['option-1', 'option-1'];
		$this->object->setOptions($expected);

		$result = $this->object->getOptions();

		$msg = 'Wrong PdoConnection::getOptions return result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Connections\PdoConnection::setCallback
	 */
	public function testSetCallback()
	{
		$callback_name = 'callback';
		$args = ['argument 1', 'argument 2'];
		$expected = [
			['method' => $callback_name, 'arguments' => $args]
		];

		$this->object->setCallback($callback_name, $args);

		$this->object->getCallbacks();

		$msg = 'Wrong PdoConnection::setCallback behavior!';
		$this->assertAttributeSame($expected, 'callbacks', $this->object, $msg);
	}

	public function testGetCallbacks()
	{
		$callback_name = 'callback';
		$args = ['argument 1', 'argument 2'];
		$expected = [
			['method' => $callback_name, 'arguments' => $args]
		];

		$this->object->setCallback($callback_name, $args);

		$result = $this->object->getCallbacks();

		$msg = 'Wrong PdoConnection::setCallback behavior!';
		$this->assertSame($expected, $result, $msg);
	}
}
