<?php
namespace Veles\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Veles\Routing\IniConfigLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 17:39:24.
 * @group route
 */
class IniConfigLoaderTest extends TestCase
{
	/**
	 * @var IniConfigLoader
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new IniConfigLoader(TEST_DIR . '/Project/routes.ini');
	}

	/**
	 * @covers \Veles\Routing\IniConfigLoader::load
	 * @covers \Veles\Routing\IniConfigLoader::buildTree
	 * @covers \Veles\Routing\IniConfigLoader::processLine
	 */
	public function testLoad()
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

		$actual = $this->object->load();

		$msg = 'IniConfigLoader::load() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}
}
