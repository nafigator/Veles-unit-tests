<?php
namespace Tests\View\Adapters;

use Veles\View\Adapters\RedirectAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-02-19 at 23:54:30.
 * @group view
 */
class RedirectAdapterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var RedirectAdapter
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new RedirectAdapter;
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
		$expected = $this->object;
		$msg = 'Unexpected RedirectAdapter::__construct() behavior!';
		$this->assertAttributeSame($expected, 'driver', $this->object, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\RedirectAdapter::show
	 */
	public function testShow()
	{
		$expected = [];

		$msg = 'RedirectAdapter::show() wrong behavior!';
		$this->assertAttributeSame($expected, 'variables', $this->object, $msg);

		$this->expectOutputString('');
		$this->object->show(null);

		$expected = ['http://ya.ru'];
		$this->object->set($expected);

		$this->expectOutputString('');
		$this->object->show(null);

		$msg = 'RedirectAdapter::__construct() wrong behavior!';
		$this->assertSame(302, http_response_code(), $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\RedirectAdapter::get
	 */
	public function testGet()
	{
		$expected = '';
		$actual = $this->object->get(null);

		$msg = 'RedirectAdapter::get() wrong behavior!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\RedirectAdapter::isCached
	 */
	public function testIsCached()
	{
		$expected = false;
		$actual = $this->object->isCached(null);

		$msg = 'RedirectAdapter::isCached() wrong behavior!';
		$this->assertSame($expected, $actual, $msg);
	}
}
