<?php
namespace Veles\Tests\Routing;

use Veles\Routing\IniConfigLoader;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 16:56:38.
 * @group route
 */
class RoutesConfigTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var RoutesConfig
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$routes_loader = new IniConfigLoader(TEST_DIR . '/Project/routes.ini');
		$this->object = new RoutesConfig($routes_loader);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\Routing\RoutesConfig::getData
	 */
	public function testGetData()
	{
		$expected = [
			''         => [
				'Home'  => [
					'class'      => 'Veles\Routing\RouteStatic',
					'view'       => 'Veles\View\Adapters\NativeAdapter',
					'route'      => '/',
					'tpl'        => 'Frontend/index.phtml',
					'controller' => 'Frontend\Home',
					'action'     => 'index',
				],
				'Home1' => [
					'class'      => 'Veles\Routing\RouteStatic',
					'view'       => 'Veles\View\Adapters\NativeAdapter',
					'route'      => '/index.html',
					'tpl'        => 'Frontend/index.phtml',
					'controller' => 'Frontend\Home',
					'action'     => 'index',
				],
			],
			'page'     => [
				'Home2' => [
					'class'      => 'Veles\Routing\RouteRegex',
					'view'       => 'Veles\View\Adapters\NativeAdapter',
					'route'      => '#^\\/page\\/(?<page>\\d+)$#',
					'tpl'        => 'Frontend/index.phtml',
					'controller' => 'Frontend\Home',
					'action'     => 'index',
				],
			],
			'book'     => [
				'TestMap' => [
					'class'      => 'Veles\Routing\RouteRegex',
					'view'       => 'Veles\View\Adapters\NativeAdapter',
					'route'      => '#^\\/book\\/(?<book_id>\\d+)\\/user\\/(?<user_id>\\d+)$#',
					'tpl'        => 'Frontend/index.phtml',
					'controller' => 'Frontend\Home',
					'action'     => 'book',
				],
			],
			'contacts' => [
				'Contacts' => [
					'class'      => 'Veles\Routing\RouteStatic',
					'route'      => '/contacts',
					'controller' => 'Frontend\Contacts',
					'action'     => 'getAddress',
					'ajax'       => '1',
				],
			],
			'user'     => [
				'User' => [
					'class' => 'Veles\Routing\RouteStatic',
					'route' => '/user',
				],
			],
		];
		$actual = $this->object->getData();
		$msg = 'RoutesConfig::getData() returns wrong value!';
		$this->assertSame($expected, $actual, $msg);

		$actual = $this->object->getData();
		$this->assertSame($expected, $actual, $msg);
	}
}
