<?php
namespace Veles\Tests\Routing;

use Controllers\Frontend\Home;
use Exception;
use PHPUnit\Framework\TestCase;
use Veles\Application\Application;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;
use Veles\View\Adapters\NativeAdapter;

include_once 'filter_input.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-22 at 09:52:48.
 * @group route
 */
class RouteTest extends TestCase
{
	/** @var  Route */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = $this->getMockBuilder('\Veles\Routing\Route')
			->setMethods(['parseUri'])
			->getMock();

		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object->setConfigHandler($config);
	}

	public function tearDown()
	{
		unset($_SERVER['HTTP_X_REQUESTED_WITH']);
	}

	/**
	 * @covers \Veles\Routing\Route::init
	 * @covers \Veles\Routing\Route::execNotFoundHandler
	 * @covers \Veles\Routing\Route::parseUri
	 *
	 * @expectedException \Veles\Routing\Exceptions\NotFoundException
	 */
	public function testNotFoundException()
	{
		$this->object->method('parseUri')->willReturn(['/not-found', 'not-found']);

		$this->object->init();
	}

	/**
	 * @covers       \Veles\Routing\Route::isAjax
	 * @covers       \Veles\Routing\Route::parseUri
	 *
	 * @dataProvider isAjaxProvider
	 *
	 * @param $parse_result
	 * @param $expected
	 */
	public function testIsAjax($parse_result, $expected)
	{
		$this->object = $this->getMockBuilder('\Veles\Routing\Route')
			->setMethods(['parseUri', 'checkAjax'])
			->getMock();
		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object->setConfigHandler($config);
		$this->object->method('parseUri')->willReturn($parse_result);
		$this->object->method('checkAjax')->willReturn($expected);

		$result = $this->object->init()->isAjax();

		$msg = 'Wrong Route::isAjax() result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function isAjaxProvider()
	{
		return [
			[['/', ''], false],
			[['/contacts', 'contacts'], true]
		];
	}

	/**
	 * @covers \Veles\Routing\Route::getController
	 */
	public function testGetController()
	{
		$this->object->method('parseUri')->willReturn(['/', '']);

		$expected = $controller = new Home;
		$result = $this->object->init()->getController();

		$msg = 'Route::getController() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Controller name not set!
	 */
	public function testGetControllerException()
	{
		$route = $this->getMockBuilder('\Veles\Routing\Route')
			->setMethods(['parseUri'])
			->getMock();

		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$route->method('parseUri')->willReturn(['/', '']);
		$route->setConfigHandler($config)->init();
		$application = (new Application)->setRoute($route);

		$this->object->method('parseUri')->willReturn(['/user', 'user']);
		$this->object->init()->getController($application);
	}

	/**
	 * @covers \Veles\Routing\Route::getActionName
	 */
	public function testGetActionName()
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = 'index';
		$result = $this->object->init()->getActionName();

		$msg = 'Route::getActionName() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Action not set!
	 */
	public function testGetActionNameException()
	{
		$this->object->method('parseUri')->willReturn(['/user', 'user']);
		$this->object->init()->getActionName();
	}

	/**
	 * @covers \Veles\Routing\Route::getAdapter
	 */
	public function testGetAdapter()
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = NativeAdapter::instance();
		$result = $this->object->init()->getAdapter();

		$msg = 'Route::getAdapter() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Route adapter not set
	 */
	public function testGetAdapterException()
	{
		$this->object->method('parseUri')->willReturn(['/user', 'user']);
		$this->object->init()->getAdapter();
	}

	/**
	 * @covers \Veles\Routing\Route::getName
	 */
	public function testGetName()
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = 'Home';
		$result = $this->object->init()->getName();

		$msg = 'Route::getName() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       \Veles\Routing\Route::getParams
	 * @covers       \Veles\Routing\Route::init
	 * @covers       \Veles\Routing\Route::process
	 * @dataProvider getParamsProvider
	 *
	 * @param $parse_result
	 * @param $expected
	 */
	public function testGetParams($parse_result, $expected)
	{
		$this->object->method('parseUri')->willReturn($parse_result);
		$this->object->init();

		$msg = 'Route::$params wrong value!';
		$this->assertAttributeSame($expected, 'params', $this->object, $msg);

		$result = $this->object->init()->getParams();

		$msg = 'Route::getParams() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function getParamsProvider()
	{
		return [
			[['/page/2', 'page'], ['page' => '2']],
			[['/page/8', 'page'], ['page' => '8']],
			[['/book/5/user/4', 'book'], ['book_id' => '5', 'user_id' => '4']],
			[['/book/5000/user/43', 'book'], ['book_id' => '5000', 'user_id' => '43']],
			[['/book/15/user/14', 'book'], ['book_id' => '15', 'user_id' => '14']],
			[['/book/500/user/143', 'book'], ['book_id' => '500', 'user_id' => '143']]
		];
	}

	/**
	 * @covers \Veles\Routing\Route::getTemplate
	 * @covers \Veles\Routing\Route::init
	 */
	public function testGetTemplate()
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = 'Frontend/index.phtml';
		$result = $this->object->init()->getTemplate();

		$msg = 'Route::getTemplate() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}
