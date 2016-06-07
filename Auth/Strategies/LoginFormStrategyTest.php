<?php
namespace Veles\Tests\Auth\Strategies;

use Veles\Auth\Strategies\LoginFormStrategy;
use Veles\DataBase\Db;
use Veles\Model\User;
use Veles\Tests\DataBase\DbCopy;

require_once 'setcookie_stub.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-25 at 23:09:50.
 * @group auth
 */
class LoginFormStrategyTest extends \PHPUnit_Framework_TestCase
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
	 * @covers       Veles\Auth\Strategies\LoginFormStrategy::identify
	 * @covers       Veles\Auth\Strategies\AbstractAuthStrategy::setCookie
	 * @covers       Veles\Auth\Strategies\AbstractAuthStrategy::delCookie
	 * @dataProvider identifyProvider
	 *
	 * @param $mail
	 * @param $pass
	 * @param $expected
	 */
	public function testIdentify($mail, $pass, $expected)
	{
		$user_result = [
			'id'         => 1,
			'email'      => 'mail@mail.org',
			'hash'       => '$2a$07$usesomesillystringforeGlOaUExBSD9HxuEYk2ZFaeDhggU716O',
			'group'      => 'uzzy',
			'last_login' => '1980-12-12'
		];
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter->expects($this->once())
			->method('row')
			->willReturn($user_result);

		Db::setAdapter($adapter);

		$object = new LoginFormStrategy($mail, $pass, new User);
		$result = $object->identify();

		$msg = 'LoginFormStrategy::identify() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function identifyProvider()
	{
		return [
			['mail@mail.org', 'superpass', true],
			['mail500@mail.org', 'asf1900', false],
			['mail@mail.org', 'superpasslakj()', false],
			['mail@mail.org', 'usell', false]
		];
	}

	/**
	 * @covers       Veles\Auth\Strategies\LoginFormStrategy::__construct
	 * @dataProvider constructProvider
	 *
	 * @param $mail
	 * @param $pass
	 */
	public function testConstruct($mail, $pass)
	{
		$object = new LoginFormStrategy($mail, $pass, new User);

		$msg = 'Wrong behavior of LoginFormStrategy::__construct()!';
		$this->assertAttributeSame($mail, 'login', $object, $msg);

		$msg = 'Wrong behavior of LoginFormStrategy::__construct()!';
		$this->assertAttributeSame($pass, 'password', $object, $msg);
	}

	public function constructProvider()
	{
		return [
			['mail200@mail.org', 'superpass3'],
			['mail300@mail.org', 'superpass2'],
			['mail500@mail.org', 'superpass1']
		];
	}

	/**
	 * @covers       Veles\Auth\Strategies\LoginFormStrategy::setLogin
	 */
	public function testSetLogin()
	{
		$expected = 'info@mail.ru';
		$pass = uniqid();

		$object = new LoginFormStrategy($expected, $pass, new User);

		$msg = 'Wrong behavior of LoginFormStrategy::setLogin()!';
		$this->assertAttributeSame($expected, 'login', $object, $msg);
	}

	/**
	 * @covers       Veles\Auth\Strategies\LoginFormStrategy::getLogin
	 * @depends testSetLogin
	 */
	public function testGetLogin()
	{
		$expected = 'info@mail.ru';
		$pass = uniqid();

		$object = new LoginFormStrategy($expected, $pass, new User);
		$result = $object->getLogin();

		$msg = 'LoginFormStrategy::getLogin() wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       Veles\Auth\Strategies\LoginFormStrategy::setPassword
	 */
	public function testSetPassword()
	{
		$login = 'info@mail.ru';
		$expected = uniqid();

		$object = new LoginFormStrategy($login, $expected, new User);

		$msg = 'LoginFormStrategy::setPassword() wrong behavior!';
		$this->assertAttributeSame($expected, 'password', $object, $msg);
	}

	/**
	 * @covers       Veles\Auth\Strategies\LoginFormStrategy::getPassword
	 * @depends testSetPassword
	 */
	public function testGetPassword()
	{
		$login = 'info@mail.ru';
		$expected = uniqid();

		$object = new LoginFormStrategy($login, $expected, new User);
		$result = $object->getPassword();

		$msg = 'LoginFormStrategy::getLogin() wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}
}
