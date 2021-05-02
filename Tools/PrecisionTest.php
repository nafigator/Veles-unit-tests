<?php
namespace Tests\Tools;

use PHPUnit\Framework\TestCase;
use Veles\Tools\Precision;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-03-05 at 20:54:40.
 * @group tools
 */
class PrecisionTest extends TestCase
{
	/**
	 * @var Precision
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new Precision;
	}

	/**
	 * @covers \Veles\Tools\Precision::getValues()
	 */
	public function testConstants()
	{
		$msg = 'Wrong value of Precision::SECONDS: ' . Precision::SECONDS;
		self::assertSame(0, Precision::SECONDS, $msg);

		$msg = 'Wrong value of Precision::MILLISECONDS: ' . Precision::MILLISECONDS;
		self::assertSame(3, Precision::MILLISECONDS, $msg);

		$msg = 'Wrong value of Precision::MICROSECONDS: ' . Precision::MICROSECONDS;
		self::assertSame(6, Precision::MICROSECONDS, $msg);

		$msg = 'Wrong value of Precision::NANOSECONDS: ' . Precision::NANOSECONDS;
		self::assertSame(9, Precision::NANOSECONDS, $msg);

		$msg = 'Wrong value of Precision::PICOSECONDS: ' . Precision::PICOSECONDS;
		self::assertSame(12, Precision::PICOSECONDS, $msg);
	}

	/**
	 * @covers \Veles\Tools\Precision::getValues()
	 */
	public function testGetValues()
	{
		$expected = [
			Precision::SECONDS,
			Precision::MILLISECONDS,
			Precision::MICROSECONDS,
			Precision::NANOSECONDS,
			Precision::PICOSECONDS
		];

		$actual = $this->object->getValues();
		$msg = 'Precision::getValues() returns wrong values';
		self::assertSame($expected, $actual, $msg);
	}
}
