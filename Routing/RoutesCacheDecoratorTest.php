<?php
namespace Veles\Tests\Routing;

use Veles\Routing\IniConfigLoader;
use Veles\Routing\RoutesCacheDecorator;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 20:32:26.
 * @group cache
 */
class RoutesCacheDecoratorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var RoutesCacheDecorator
	 */
	protected $object;
	protected $config;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object = new RoutesCacheDecorator($this->config);
		$this->object->setPrefix('VELES-UNIT-TESTS::ROUTES-CONFIG');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	public function testConstruct()
	{
		$msg = 'RoutesCacheDecorator::__construct wrong behavior!';
		$this->assertAttributeSame($this->config, 'config', $this->object, $msg);
	}

	/**
	 * @covers \Veles\Routing\RoutesCacheDecorator::getData
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
			'fake-route' => [
				'Key'  => 'value'
			]
		];

		$msg = 'RoutesCacheDecorator::getData returns wrong result!';
		// test without cache
		$actual = $this->object->getData();
		$this->assertSame($expected, $actual, $msg);
		// test with cache
		$actual = $this->object->getData();
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Routing\RoutesCacheDecorator::getPrefix
	 */
	public function testGetPrefix()
	{
		$expected = 'VELES-UNIT-TESTS::ROUTES-CONFIG';
		$actual = $this->object->getPrefix();

		$msg = 'RoutesCacheDecorator::getPrefix() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Routing\RoutesCacheDecorator::setPrefix
	 */
	public function testSetPrefix()
	{
		$expected = 'VELES-UNIT-TESTS::ROUTES-CONFIG-OTHER';
		$this->object->setPrefix($expected);

		$msg = 'RoutesCacheDecorator::setPrefix() wrong behavior!';
		$this->assertAttributeSame($expected, 'prefix', $this->object, $msg);
	}

	/**
	 * @covers       \Veles\Routing\RoutesCacheDecorator::getSection
	 *
	 * @dataProvider getSectionProvider
	 *
	 * @param $name
	 * @param $expected
	 */
	public function testGetSection($name, $expected)
	{
		$actual = $this->object->getSection($name);
//var_export($actual);exit;
		$msg = 'RoutesCacheDecorator::setPrefix() wrong behavior!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function getSectionProvider()
	{
		return [
			[
				'',
				[
					'Home'  => [
						'class'      => 'Veles\\Routing\\RouteStatic',
						'view'       => 'Veles\\View\\Adapters\\NativeAdapter',
						'route'      => '/',
						'tpl'        => 'Frontend/index.phtml',
						'controller' => 'Frontend\\Home',
						'action'     => 'index',
					],
					'Home1' => [
						'class'      => 'Veles\\Routing\\RouteStatic',
						'view'       => 'Veles\\View\\Adapters\\NativeAdapter',
						'route'      => '/index.html',
						'tpl'        => 'Frontend/index.phtml',
						'controller' => 'Frontend\\Home',
						'action'     => 'index',
					],
				]
			],
			[
				'page',
				[
					'Home2' => [
						'class'      => 'Veles\\Routing\\RouteRegex',
						'view'       => 'Veles\\View\\Adapters\\NativeAdapter',
						'route'      => '#^\\/page\\/(?<page>\\d+)$#',
						'tpl'        => 'Frontend/index.phtml',
						'controller' => 'Frontend\\Home',
						'action'     => 'index',
					],
				]
			]
		];
	}
}
