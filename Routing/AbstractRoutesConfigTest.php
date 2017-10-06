<?php
namespace Veles\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 17:52:00.
 * @group route
 */
class AbstractRoutesConfigTest extends TestCase
{
	/**
	 * @var \Veles\Routing\AbstractRoutesConfig
	 */
	protected $object;
	protected $expected;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->expected = new IniConfigLoader(TEST_DIR . '/Project/routes.ini');
		$this->object = new RoutesConfig($this->expected);
	}

	/**
	 * @covers \Veles\Routing\AbstractRoutesConfig::__construct
	 */
	public function testConstruct()
	{
		$msg = 'AbstractRoutesConfig::__construct() wrong behavior!';
		$this->assertAttributeSame($this->expected, 'loader', $this->object, $msg);
	}
}
