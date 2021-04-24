<?php
namespace Veles\Tests\Auth;

use PHPUnit\Framework\TestCase;
use Veles\Auth\Strategies\CookieStrategy;
use Veles\Auth\Strategies\GuestStrategy;
use Veles\Auth\Strategies\LoginFormStrategy;
use Veles\Auth\UsrAuthFactory;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-18 at 21:41:45.
 * @group auth
 */
class UsrAuthFactoryTest extends TestCase
{
	/**
	 * @var UsrAuthFactory
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = $this->getMockBuilder(UsrAuthFactory::class)
			->setMethods(['getPost', 'getCookies'])
			->getMock();
	}

	protected function tearDown()
	{
		unset($_COOKIE, $_POST);
	}

	/**
	 * @covers \Veles\Auth\UsrAuthFactory::create
	 * @covers \Veles\Auth\Strategies\LoginFormStrategy::errorHandle
	 * @covers \Veles\Auth\Strategies\CookieStrategy::errorHandle
	 */
	public function testCreate()
	{
		/** @var UsrAuthFactory $object */
		$object = $this->getMockBuilder(UsrAuthFactory::class)
			->setMethods(['getPost', 'getCookies'])
			->getMock();

		$result = $object->create();
		$expected = GuestStrategy::class;

		$msg = 'UsrAuthFactory::create() return wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);

		$object->expects($this->once())
			->method('getPost')
			->willReturn(['ln' => 'login', 'pw' => 'password']);

		$result = $object->create();
		$expected = LoginFormStrategy::class;

		$msg = 'UsrAuthFactory::create() return wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);

		$object = $this->getMockBuilder(UsrAuthFactory::class)
			->setMethods(['getPost', 'getCookies'])
			->getMock();

		$object->expects($this->once())
			->method('getCookies')
			->willReturn(['id' => 1111, 'pw' => 'password']);

		$result = $object->create();
		$expected = CookieStrategy::class;

		$msg = 'UsrAuthFactory::create() return wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);
	}
}
