<?php
namespace Veles\Tests\View\Adapters;

use PHPUnit\Framework\TestCase;
use Veles\View\Adapters\CustomJsonAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-08 at 07:14:04.
 *
 * @group view
 */
class CustomJsonAdapterTest extends TestCase
{
	/**
	 * @var CustomJsonAdapter
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new CustomJsonAdapter;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\View\Adapters\CustomJsonAdapter::show
	 */
	public function testShow()
	{
		$expected = [];

		$msg = 'CustomJsonAdapter::show() wrong behavior!';
		$this->assertAttributeSame($expected, 'variables', $this->object, $msg);

		$this->expectOutputString('');
		$this->object->show(null);

        $expected = '{"prop":"this is json-string"}';
		$this->object->set($expected);

		$this->expectOutputString($expected);
		$this->object->show(null);
	}

	/**
	 * @covers \Veles\View\Adapters\CustomJsonAdapter::set
	 */
	public function testSet()
	{
		$expected = '{"prop":"this is new json-string"}';
		$this->object->set($expected);

		$msg = 'CustomJsonAdapter::show() wrong behavior!';
		$this->assertAttributeSame($expected, 'variables', $this->object, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\CustomJsonAdapter::get
	 */
	public function testGet()
	{
		$expected = '{"prop":100500}';
		$this->object->set($expected);

		$actual = $this->object->get(null);
		$msg = 'CustomJsonAdapter::show() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\CustomJsonAdapter::isCached
	 */
	public function testIsCached()
	{
		$expected = false;

		$actual = $this->object->isCached('path');
		$msg = 'CustomJsonAdapter::isCached() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\CustomJsonAdapter::__construct
	 */
	public function testConstruct()
	{
		$msg = 'CustomJsonAdapter::__construct() wrong behavior!';
		$this->assertAttributeSame($this->object, 'driver', $this->object, $msg);
	}
}
