<?php
/**
 * Юнит-тест для класса Timer
 * @file    TimerTest.php
 *
 * PHP version 7.1+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    2013-02-06 21:58:55
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\Tools;

use PHPUnit\Framework\TestCase;
use ReflectionObject;
use Veles\Tools\Precision;
use Veles\Tools\Timer;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-06 at 21:58:55.
 * @group timer
 * @group tools
 */
class TimerTest extends TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		Timer::reset();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
		Timer::reset();
	}

	/**
	 * @group        Tools
	 * @dataProvider getProvider
	 * @see          Timer::get
	 */
	public function testGet($timer_precision, $precision): void
	{
		Timer::start();

		$object = new ReflectionObject(new Timer);
		$start_time = $object->getProperty('start_time');
		$start_time->setAccessible(true);
		$start_value = $start_time->getValue();

		Timer::stop();

		$stop_time = $object->getProperty('stop_time');
		$stop_time->setAccessible(true);
		$stop_value = $stop_time->getValue();

		$result = Timer::get($timer_precision);
		$expected = round($stop_value - $start_value, $precision);

		$msg = 'Wrong Timer result';
		self::assertSame($expected, $result, $msg);
	}

	public function getProvider(): array
	{
		return [
			[Precision::SECONDS, 0],
			[Precision::MILLISECONDS, 3],
			[Precision::MICROSECONDS, 6],
			[Precision::NANOSECONDS, 9],
			[Precision::PICOSECONDS, 12],
			[8, 6]
		];
	}

	/**
	 * @group        Tools
	 * @dataProvider getPrecisionProvider
	 * @see          Timer::get
	 */
	public function testGetPrecision($precision): void
	{
		Timer::start();
		Timer::stop();

		$object = new ReflectionObject(new Timer);
		$diff_prop = $object->getProperty('diff');

		$diff_prop->setAccessible(true);
		$diff = $diff_prop->getValue();

		$expected = round($diff, $precision);

		$result = Timer::get($precision);

		$msg = 'Wrong Timer precision result';
		self::assertSame($expected, $result, $msg);
	}

	public function getPrecisionProvider(): array
	{
		return [
			[Precision::SECONDS],
			[Precision::MILLISECONDS],
			[Precision::MICROSECONDS],
			[Precision::NANOSECONDS],
			[Precision::PICOSECONDS]
		];
	}
}
