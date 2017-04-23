<?php
/**
 * Юнит-тест для класса Timer
 * @file    TimerTest.php
 *
 * PHP version 5.6+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    2013-02-06 21:58:55
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\Tools;

use ReflectionObject;
use Veles\Tools\Timer;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-06 at 21:58:55.
 * @group timer
 * @group tools
 */
class TimerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		Timer::reset();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		Timer::reset();
	}

	/**
	 * @covers \Veles\Tools\Timer::start
	 * @group Tools
	 * @see Timer::start
	 */
	public function testConstants()
	{
		$msg = 'Wrong value of Timer::SECONDS: ' . Timer::SECONDS;
		$this->assertSame(0, Timer::SECONDS, $msg);

		$msg = 'Wrong value of Timer::MILLISECONDS: ' . Timer::MILLISECONDS;
		$this->assertSame(3, Timer::MILLISECONDS, $msg);

		$msg = 'Wrong value of Timer::MICROSECONDS: ' . Timer::MICROSECONDS;
		$this->assertSame(6, Timer::MICROSECONDS, $msg);

		$msg = 'Wrong value of Timer::NANOSECONDS: ' . Timer::NANOSECONDS;
		$this->assertSame(9, Timer::NANOSECONDS, $msg);

		$msg = 'Wrong value of Timer::PICOSECONDS: ' . Timer::PICOSECONDS;
		$this->assertSame(12, Timer::PICOSECONDS, $msg);
	}

	/**
	 * @covers \Veles\Tools\Timer::start
	 * @group Tools
	 * @see Timer::start
	 */
	public function testStart()
	{
		$time_before_start = microtime(true);
		Timer::start();
		$time_after_start = microtime(true);

		$object = new \ReflectionClass('\Veles\Tools\Timer');
		$start_time_prop = $object->getProperty('start_time');

		$msg = 'Property Timer::$start_time not private';
		$this->assertTrue($start_time_prop->isPrivate(), $msg);

		$start_time_prop->setAccessible(true);
		$result = $start_time_prop->getValue();

		$msg = 'Wrong Timer Timer::$start_time type';
		$this->assertInternalType('float', $result, $msg);

		$msg = 'Wrong result of Timer::$start_time property';
		$this->assertAttributeGreaterThanOrEqual($time_before_start, 'start_time', new Timer, $msg);

		$msg = 'Wrong result of Timer::$start_time property';
		$this->assertAttributeLessThanOrEqual($time_after_start, 'start_time', new Timer, $msg);
	}

	/**
	 * @covers \Veles\Tools\Timer::reset
	 * @group Tools
	 * @depends testStart
	 * @see Timer::reset
	 */
	public function testReset()
	{
		Timer::start();
		Timer::stop();
		Timer::reset();
		$expected = 0.0;

		$msg = 'Timer::reset() wrong behavior!';

		$this->assertAttributeSame($expected, 'start_time', new Timer, $msg);
		$this->assertAttributeSame($expected, 'diff', new Timer, $msg);
	}

	/**
	 * @covers  \Veles\Tools\Timer::stop
	 * @group Tools
	 * @depends testStart
	 * @depends testReset
	 * @see Timer::stop
	 */
	public function testStop()
	{
		$time_before_start = microtime(true);
		Timer::start();
		$time_before_stop = microtime(true);
		Timer::stop();
		$time_after_stop = microtime(true);

		$expected = $time_after_stop - $time_before_start;

		$msg = 'Timer::stop() wrong behavior!';
		$this->assertAttributeGreaterThan($time_before_stop, 'stop_time', new Timer, $msg);
		$this->assertAttributeLessThan($time_after_stop, 'stop_time', new Timer, $msg);
		$this->assertAttributeLessThan($expected, 'diff', new Timer, $msg);
		$this->assertAttributeSame(0.0, 'start_time', new Timer, $msg);
	}

	/**
	 * @covers       \Veles\Tools\Timer::get
	 * @group        Tools
	 * @dataProvider getProvider
	 * @depends      testStop
	 * @see          Timer::get
	 *
	 * @param $timer_precision
	 * @param $precision
	 */
	public function testGet($timer_precision, $precision)
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

		$msg = 'Wrong Timer result type';
		$this->assertInternalType('float', $result, $msg);

		$msg = 'Wrong Timer result';
		$this->assertSame($expected, $result, $msg);
	}

	public function getProvider()
	{
		return [
			[Timer::SECONDS, 0],
			[Timer::MILLISECONDS, 3],
			[Timer::MICROSECONDS, 6],
			[Timer::NANOSECONDS, 9],
			[Timer::PICOSECONDS, 12],
			[8, 6]
		];
	}

	/**
	 * @covers       \Veles\Tools\Timer::get
	 * @group        Tools
	 * @depends      testStop
	 * @dataProvider getPrecisionProvider
	 * @see          Timer::get
	 *
	 * @param $precision
	 */
	public function testGetPrecision($precision)
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
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * Data-provider for testGetPrecision
	 */
	public function getPrecisionProvider()
	{
		return [
			[Timer::SECONDS],
			[Timer::MILLISECONDS],
			[Timer::MICROSECONDS],
			[Timer::NANOSECONDS],
			[Timer::PICOSECONDS]
		];
	}
}
