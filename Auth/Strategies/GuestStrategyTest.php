<?php
namespace Veles\Auth\Strategies;

use PHPUnit\Framework\TestCase;
use Veles\Auth\UsrGroup;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-25 at 22:56:19.
 * @group auth
 */
class GuestStrategyTest extends TestCase
{
	/**
	 * @var GuestStrategy
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new GuestStrategy(new User);
	}

	/**
	 * @covers \Veles\Auth\Strategies\GuestStrategy::identify
	 */
	public function testIdentify()
	{
		$expected = false;
		$result = $this->object->identify();
		$msg = 'GuestStrategy::identify() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$expected = ['group' => UsrGroup::GUEST];
		$result = ['group' => ''];
		$this->object->getUser()->getProperties($result);
		$msg = 'Wrong GuestStrategy::identify() behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\Auth\Strategies\GuestStrategy::errorHandle()
	 */
	public function testErrorHandle()
	{
		$expected = null;
		$actual = $this->object->errorHandle([]);
		$msg = 'Wrong GuestStrategy::errorHandle() behavior!';
		$this->assertSame($expected, $actual, $msg);
	}
}
