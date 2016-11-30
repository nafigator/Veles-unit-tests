<?php
namespace Tests\Controllers;

use Controllers\Frontend\Home;
use Veles\Application\Application;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-10-24 at 10:20:22.
 * @group controllers
 */
class BaseControllerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Home
	 */
	protected $object;
	protected $application;
	/** @var Route */
	protected $route;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->route = $this->getMockBuilder('\Veles\Routing\Route')
			->setMethods(['parseUri'])
			->getMock();

		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->route->setConfigHandler($config);

		$this->application = (new Application)->setRoute($this->route);
		$this->object = new Home($this->application);
	}

	/**
	 * @covers \Veles\Controllers\BaseController::getApplication
	 * @covers \Veles\Controllers\BaseController::__construct
	 */
	public function testGetApplication()
	{
		$expected = $this->application;
		$actual   = $this->object->getApplication();

		$msg = 'BaseController::getApplication() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Controllers\BaseController::setApplication
	 */
	public function testSetApplication()
	{
		$expected = (new Application)->setVersion('0.0.234');
		$this->object->setApplication($expected);

		$msg = 'BaseController::setApplication() wrong behavior!';
		$this->assertAttributeSame($expected, 'application', $this->object, $msg);
	}

	/**
	 * @covers       \Veles\Controllers\BaseController::getParam
	 *
	 * @param $parse_result
	 * @param $expected
	 *
	 * @dataProvider getParamProvider
	 */
	public function testGetParam($parse_result, $expected)
	{
		$this->route->method('parseUri')->willReturn($parse_result);
		$this->route->init();

		$actual = $this->object->book();

		$msg = 'BaseController::getParams() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function getParamProvider()
	{
		return [
			[
				['/book/5/user/8', 'book'],
				['book' => '5', 'user' => '8']
			],
			[
				['/book/575/user/82', 'book'],
				['book' => '575', 'user' => '82']
			]
		];
	}
}
