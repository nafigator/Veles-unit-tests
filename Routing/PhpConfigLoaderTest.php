<?php
namespace Veles\Tests\Routing;

use PHPUnit\Framework\TestCase;
use Veles\Routing\PhpConfigLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 18:10:59.
 * @group route
 */
class PhpConfigLoaderTest extends TestCase
{
	/**
	 * @var PhpConfigLoader
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new PhpConfigLoader(TEST_DIR . '/Project/routes.php');
	}

	/**
	 * @covers \Veles\Routing\PhpConfigLoader::load
	 */
	public function testLoad()
	{
		$expected = include TEST_DIR . '/Project/routes.php';
		$result = $this->object->load();

		$msg = 'PhpConfigLoader::load() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}
}
