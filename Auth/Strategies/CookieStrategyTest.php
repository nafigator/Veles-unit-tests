<?php
namespace Veles\Tests\Auth\Strategies;

use Veles\Auth\Strategies\CookieStrategy;
use Veles\DataBase\Db;
use Veles\Model\User;
use Veles\Tests\DataBase\DbCopy;

require_once 'setcookie_stub.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-25 at 23:09:16.
 * @group auth
 */
class CookieStrategyTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		DbCopy::unsetAdapter();
	}

	/**
	 * @covers       \Veles\Auth\Strategies\CookieStrategy::identify
	 * @covers       \Veles\Auth\Strategies\AbstractAuthStrategy::findUser
	 * @dataProvider identifyProvider
	 *
	 * @param $id
	 * @param $hash
	 * @param $expected
	 * @param $user_result
	 */
	public function testIdentify($id, $hash, $expected, $user_result)
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter->expects($this->once())
			->method('row')
			->willReturn($user_result);

		Db::setAdapter($adapter);

		$object = new CookieStrategy($id, $hash, new User);
		$actual = $object->identify();

		$msg = 'CookieStrategy::identify() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function identifyProvider()
	{
		$found = [
			'id'         => 1,
			'email'      => 'mail@mail.org',
			'hash'       => '$2a$07$usesomesillystringforeGlOaUExBSD9HxuEYk2ZFaeDhggU716O',
			'group'      => 'uzzy',
			'last_login' => '1980-12-12'
		];

		$not_found = [];

		return [
			[1, 'GlOaUExBSD9HxuEYk2ZFaeDhggU716O', true, $found],
			[2, 'GlOaUExBSD9HxuEYk3ZFaeDhggU716O', false, $not_found],
			[1, 'GlOaUExBSD9HxuEYk3ZFaeDhggU716O', false, $found]
		];
	}

	/**
	 * @covers       \Veles\Auth\Strategies\CookieStrategy::__construct
	 * @dataProvider constructProvider
	 *
	 * @param $id
	 * @param $hash
	 */
	public function testConstruct($id, $hash)
	{
		$object = new CookieStrategy($id, $hash, new User);

		$msg = 'Wrong behavior of CookieStrategy::__construct!';
		$this->assertAttributeSame($id, 'identifier', $object, $msg);

		$msg = 'Wrong behavior of CookieStrategy::__construct!';
		$this->assertAttributeSame($hash, 'password_hash', $object, $msg);
	}

	public function constructProvider()
	{
		return [
			[1, 'GlOaUExBSD9HxuEYk2ZFaeDhggU716O'],
			[5, 'GlOaUExBSD9HxuEYk2ZFaeDhggU7162'],
			[5555, 'GlOaUExBSD9HxuEYk2fFaeDhggU7162']
		];
	}

	/**
	 * @covers \Veles\Auth\Strategies\CookieStrategy::setPasswordHash
	 */
	public function testSetPasswordHash()
	{
		$id	  = rand();
		$expected = uniqid();

		$object = new CookieStrategy($id, $expected, new User);
		$object->setPasswordHash($expected);

		$msg = 'CookieStrategy::setPasswordHash() wrong behavior!';
		$this->assertAttributeSame($expected, 'password_hash', $object, $msg);
	}

	/**
	 * @covers \Veles\Auth\Strategies\CookieStrategy::getPasswordHash
	 * @depends testSetPasswordHash
	 */
	public function testGetPasswordHash()
	{
		$id	  = rand();
		$expected = uniqid();

		$object = new CookieStrategy($id, $expected, new User);

		$result = $object->getPasswordHash();

		$msg = 'CookieStrategy::getPasswordHash() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\Auth\Strategies\CookieStrategy::setId
	 */
	public function testSetId()
	{
		$expected = rand();
		$hash = uniqid();

		$object = new CookieStrategy($expected, $hash, new User);
		$object->setId($expected);

		$msg = 'CookieStrategy::setId() wrong behavior!';
		$this->assertAttributeSame($expected, 'identifier', $object, $msg);
	}

	/**
	 * @covers \Veles\Auth\Strategies\CookieStrategy::getId
	 * @depends testSetId
	 */
	public function testGetId()
	{
		$expected = rand();
		$hash = uniqid();

		$object = new CookieStrategy($expected, $hash, new User);

		$result = $object->getId();

		$msg = 'CookieStrategy::getId() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}
