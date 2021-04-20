<?php
/**
 * Юнит-тест для класса RestApplication
 *
 * @file    RestApplicationTest.php
 *
 * PHP version 7.1+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Втр Янв 22 22:53:39 2013
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\Application;

use Veles\Application\RestApplication;
use Exception;
use PHPUnit\Framework\TestCase;
use Veles\Request\HttpGetRequest;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-22 at 22:53:39.
 * @group application
 */
class RestApplicationTest extends TestCase
{
	/**
	 * Unit-test for RestApplication::run
	 *
	 * @covers       \Veles\Application\RestApplication::run
	 * @dataProvider runProvider
	 *
	 * @param $url
	 * @param $parse_result
	 * @param $expected
	 *
	 * @throws Exception
	 */
	public function testRun($url, $parse_result, $expected): void
	{
		$this->expectOutputString($expected['output']);

		$route = $this->getMockBuilder(Route::class)
			->setMethods(['parseUri'])
			->getMock();
		$route->method('parseUri')->willReturn($parse_result);

		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$route->setConfigHandler($config)->init();

		$app = new RestApplication;
		$app->setRoute($route)->run();

		$actual = $app->getRoute()->getParams();

		$msg = "Wrong Route::params in $url";
		self::assertSame($expected['params'], $actual, $msg);
	}

	/**
	 * DataProvider for RestApplication::run
	 */
	public function runProvider(): array
	{
		$uri = '/page/2';
		$parse_result = [$uri, 'page'];
		$expected = [
			'params' => ['page' => '2'],
			'output' => <<<EOF
<!DOCTYPE html>
<html>
<head>
	<title>Veles is a fast PHP framework</title>
</head>
<body>
	<div id="main_wrapper">
		Test complete!
	</div>
	<div id="footer_wrapper">
		Hello World!
	</div>
</body>
</html>

EOF
		];

		return [[$uri, $parse_result, $expected]];
	}

	/**
	 * @covers \Veles\Application\RestApplication::setRoute
	 */
	public function testSetRoute(): void
	{
		$expected = (new Route)->setConfigHandler(
			new RoutesConfig(new IniConfigLoader(TEST_DIR . '/Project/routes.ini'))
		);

		$object = (new RestApplication)->setRoute($expected);

		$msg = 'RestApplication::setRoute() wrong behavior!';
		self::assertAttributeSame($expected, 'route', $object, $msg);
	}

	/**
	 * @covers \Veles\Application\RestApplication::getRoute
	 */
	public function testGetRoute(): void
	{
		$expected = (new Route)->setConfigHandler(
			new RoutesConfig(new IniConfigLoader(TEST_DIR . '/Project/routes.ini'))
		);

		$object = (new RestApplication)->setRoute($expected);

		$actual = $object->getRoute();

		$msg = 'RestApplication::getRoute() returns wrong result!';
		self::assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Application\RestApplication::setRequest
	 */
	public function testSetRequest(): void
	{
		$expected = new HttpGetRequest;

		$object = (new RestApplication)->setRequest($expected);

		$msg = 'RestApplication::setRequest() wrong behavior!';
		self::assertAttributeSame($expected, 'request', $object, $msg);
	}

	/**
	 * @covers \Veles\Application\RestApplication::getRequest
	 */
	public function testGetRequest(): void
	{
		$expected = new HttpGetRequest;

		$object = (new RestApplication)->setRequest($expected);

		$actual = $object->getRequest();

		$msg = 'RestApplication::getRequest() returns wrong result!';
		self::assertSame($expected, $actual, $msg);
	}
}
