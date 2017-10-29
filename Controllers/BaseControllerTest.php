<?php
namespace Tests\Controllers;

use Controllers\Frontend\Home;
use PHPUnit\Framework\TestCase;
use Veles\Application\Application;
use Veles\Request\HttpGetRequest;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-10-24 at 10:20:22.
 * @group controllers
 */
class BaseControllerTest extends TestCase
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
		$this->route = $this->getMockBuilder(Route::class)
			->setMethods(['parseUri'])
			->getMock();

		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->route->setConfigHandler($config);

		$this->application = (new Application)->setRoute($this->route);
		$this->object = (new Home)->setApplication($this->application);
	}

	protected function tearDown()
	{
		unset($_POST);
	}

	/**
	 * @covers \Veles\Controllers\BaseController::getApplication
	 * @covers \Veles\Application\ApplicationTrait::getApplication
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
	 * @covers \Veles\Application\ApplicationTrait::setApplication
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

	/**
	 * @covers       \Veles\Controllers\BaseController::getData
	 */
	public function testGetData()
	{
		$_POST       = [
			'email'    => 'mail@mail.ru',
			'password' => 'superpass'
		];
		$definitions = [
			'email'    => [
				'filter'  => FILTER_VALIDATE_EMAIL,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => ['required' => true]
			],
			'password' => [
				'filter'  => FILTER_VALIDATE_REGEXP,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => [
					'required' => true,
					'regexp'   => '/.{6,32}/'
				]
			]
		];
		$expected    = [
			[
				'email'    => 'mail@mail.ru',
				'password' => 'superpass'
			]
		];

		$request = $this->getMockBuilder(HttpGetRequest::class)
			->setMethods(['getData'])
			->getMock();

		$request->expects($this->once())
			->method('getData')
			->with($definitions)
			->willReturn($expected);

		$this->application->setRequest($request);


		$actual = $this->object->read();

		$msg = 'BaseController::getData() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}
}
