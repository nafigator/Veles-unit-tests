<?php
namespace Veles\Tests\Routing;

use Controllers\Frontend\Home;
use DomainException;
use Exception;
use PHPUnit\Framework\TestCase;
use Veles\Application\Application;
use Veles\Routing\Exceptions\NotFoundException;
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
	protected function setUp(): void
	{
		$this->object = $this->getMockBuilder(Route::class)
			->onlyMethods(['parseUri'])
			->getMock();

		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object->setConfigHandler($config);
	}

	protected function tearDown(): void
	{
		unset($_SERVER['HTTP_X_REQUESTED_WITH']);
	}

	public function testNotFoundException(): void
	{
		$this->expectException(NotFoundException::class);
		$this->object->method('parseUri')->willReturn(['/not-found', 'not-found']);

		$this->object->init();
	}

	public function testSetNotFoundException(): void
	{
		$this->expectException(DomainException::class);
		$this->object->setNotFoundException(DomainException::class);
		$this->object->method('parseUri')->willReturn(['/not-found', 'not-found']);

		$this->object->init();
	}

	/**
	 * @dataProvider isAjaxProvider
	 */
	public function testIsAjax($parse_result, $expected): void
	{
		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object->setConfigHandler($config);
		$this->object->method('parseUri')->willReturn($parse_result);

		$actual = $this->object->init()->isAjax();

		$msg = 'Wrong Route::isAjax() result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function isAjaxProvider(): array
	{
		return [
			[['/', ''], false],
			[['/contacts', 'contacts'], true]
		];
	}

	public function testGetController(): void
	{
		$this->object->method('parseUri')->willReturn(['/', '']);

		$expected = $controller = new Home;
		$result = $this->object->init()->getController();

		$msg = 'Route::getController() returns wrong result!';
		self::assertEquals($expected, $result, $msg);
	}

	public function testGetControllerException(): void
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('Controller name not set!');

		$route = $this->getMockBuilder(Route::class)
			->onlyMethods(['parseUri'])
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

	public function testGetActionName(): void
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = 'index';
		$result = $this->object->init()->getActionName();

		$msg = 'Route::getActionName() returns wrong result!';
		self::assertEquals($expected, $result, $msg);
	}

	public function testGetActionNameException(): void
	{
		$this->expectExceptionMessage(Exception::class);
		$this->expectExceptionMessage('Action not set!');

		$this->object->method('parseUri')->willReturn(['/user', 'user']);
		$this->object->init()->getActionName();
	}

	public function testGetAdapter(): void
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = NativeAdapter::instance();
		$result = $this->object->init()->getAdapter();

		$msg = 'Route::getAdapter() returns wrong result!';
		self::assertEquals($expected, $result, $msg);
	}

	public function testGetAdapterException(): void
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('Route adapter not set');

		$this->object->method('parseUri')->willReturn(['/user', 'user']);
		$this->object->init()->getAdapter();
	}

	public function testGetName(): void
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = 'Home';
		$result = $this->object->init()->getName();

		$msg = 'Route::getName() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	/**
	 * @dataProvider getParamsProvider
	 */
	public function testGetParams($parse_result, $expected): void
	{
		$this->object->method('parseUri')->willReturn($parse_result);
		$this->object->init();

		$result = $this->object->init()->getParams();

		$msg = 'Route::getParams() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	public function getParamsProvider(): array
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

	public function testGetTemplate(): void
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = 'Frontend/index.phtml';
		$result = $this->object->init()->getTemplate();

		$msg = 'Route::getTemplate() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	public function testGetUri(): void
	{
		$this->object->method('parseUri')->willReturn(['/', '']);
		$expected = '/';
		$result = $this->object->init()->getUri();

		$msg = 'Route::getUri() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}
}
