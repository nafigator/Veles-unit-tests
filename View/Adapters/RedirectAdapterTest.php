<?php
namespace Tests\View\Adapters;

use PHPUnit\Framework\TestCase;
use Veles\View\Adapters\RedirectAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-02-19 at 23:54:30.
 * @group view
 */
class RedirectAdapterTest extends TestCase
{
	/**
	 * @var RedirectAdapter
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new RedirectAdapter;
	}

	public function testShow(): void
	{
		$this->expectOutputString('');
		$this->object->show(null);

		$expected = ['http://ya.ru'];
		$this->object->set($expected);

		$this->expectOutputString('');
		$this->object->show(null);

		$msg = 'RedirectAdapter::show() wrong behavior!';
		self::assertSame(302, http_response_code(), $msg);
	}

	public function testGet(): void
	{
		$expected = '';
		$actual = $this->object->get(null);

		$msg = 'RedirectAdapter::get() wrong behavior!';
		self::assertSame($expected, $actual, $msg);
	}

	public function testIsCached(): void
	{
		$expected = false;
		$actual = $this->object->isCached(null);

		$msg = 'RedirectAdapter::isCached() wrong behavior!';
		self::assertSame($expected, $actual, $msg);
	}
}
