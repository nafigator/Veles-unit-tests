<?php
namespace Veles\Tests\Auth\Strategies;

use PHPUnit\Framework\TestCase;
use Veles\Auth\Strategies\GuestStrategy;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-25 at 22:44:14.
 * @group auth
 */
class AbstractAuthStrategyTest extends TestCase
{
	/**
	 * @var GuestStrategy
	 */
	protected $object;

	protected function setUp(): void
	{
		$this->object = new GuestStrategy(new User);
	}

	public function testGetUser(): void
	{
		$expected = User::class;
		$actual = $this->object->getUser();
		$msg = 'AbstractAuthStrategy::getUser() returns wrong result!';
		self::assertInstanceOf($expected, $actual, $msg);
	}

	public function testGetErrors(): void
	{
		$expected = 0;
		$actual = $this->object->getErrors();
		$msg = 'AbstractAuthStrategy::getErrors() returns wrong result!';
		self::assertSame($expected, $actual, $msg);

		$this->object->setError(GuestStrategy::ERR_NOT_VALID_LOGIN);
		$this->object->setError(GuestStrategy::ERR_NOT_VALID_HASH);
		$expected = 40;

		$actual = $this->object->getErrors();
		self::assertSame($expected, $actual, $msg);
	}
}
