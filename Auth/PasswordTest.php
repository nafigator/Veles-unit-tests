<?php
/**
 * Юнит-тест для класса Password
 * @file    PasswordTest.php
 *
 * PHP version 5.6+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Вск Янв 20 15:58:07 2013
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\Auth;

use PHPUnit\Framework\TestCase;
use Veles\Auth\Password;
use Veles\Helper;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-22 at 08:31:29.
 * @group auth
 */
class PasswordTest extends TestCase
{
	/**
	 * Unit-test for Password::checkCookieHash
	 * @covers \Veles\Auth\Password::checkCookieHash
	 * @dataProvider checkCookieHashProvider
	 * @see \Veles\Auth\Password::checkCookieHash
	 */
	public function testCheckCookieHash($user, $cookie_hash, $expected)
	{
		$result = Password::checkCookieHash($user, $cookie_hash);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('bool', $result, $msg);

		$txt_result = $result ? 'true' : 'false';
		$msg = "CheckCookieHash \"$cookie_hash\" has wrong result: $txt_result";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for PasswordTest::testCheckCookieHash
	 */
	public function checkCookieHashProvider()
	{
		$user = new User;
		$user->hash = crypt('password', '$2a$07$' . Helper::genStr() . '$');

		return [
			[$user, $user->getCookieHash(), true],
			[$user, 'wrongHash', false]
		];
	}

	/**
	 * Unit-test for Password::check
	 *
	 * @covers       \Veles\Auth\Password::check
	 * @dataProvider checkProvider
	 * @see          \Veles\Auth\Password::check
	 *
	 * @param $user
	 * @param $password
	 * @param $expected
	 */
	public function testCheck($user, $password, $expected)
	{
		$result = Password::check($user, $password);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('bool', $result, $msg);

		$txt_result = $result ? 'true' : 'false';
		$msg = "Password::check \"$password\" has wrong result: $txt_result";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for PasswordTest::testCheck
	 */
	public function checkProvider()
	{
		$user = new User;
		$user->hash = crypt('password', '$2y$07$' . Helper::genStr());

		return [
			[$user, 'password', true],
			[$user, 'wrongPassword', false]
		];
	}
}
