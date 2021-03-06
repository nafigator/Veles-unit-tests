<?php
/**
 * Юнит-тест для класса UsrGroup
 * @file    UsrGroupTest.php
 *
 * PHP version 7.1+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Птн Янв 25 20:56:16 2013
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\Auth;

use PHPUnit\Framework\TestCase;
use Veles\Auth\UsrGroup;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-25 at 20:55:11.
 * @covers \Veles\Auth\UsrGroup
 * @group auth
 */
class UsrGroupTest extends TestCase
{
	/**
	 * Unit-test for UsrGroup class
	 */
	public function testConstants()
	{
		$msg = 'Wrong UsrGroup::ADMIN value';
		self::assertSame(1, UsrGroup::ADMIN, $msg);

		$msg = 'Wrong UsrGroup::MANAGER value';
		self::assertSame(2, UsrGroup::MANAGER, $msg);

		$msg = 'Wrong UsrGroup::MODERATOR value';
		self::assertSame(4, UsrGroup::MODERATOR, $msg);

		$msg = 'Wrong UsrGroup::REGISTERED value';
		self::assertSame(8, UsrGroup::REGISTERED, $msg);

		$msg = 'Wrong UsrGroup::GUEST value';
		self::assertSame(16, UsrGroup::GUEST, $msg);

		$msg = 'Wrong UsrGroup::DELETED value';
		self::assertSame(32, UsrGroup::DELETED, $msg);
	}
}
