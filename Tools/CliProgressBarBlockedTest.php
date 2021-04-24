<?php
namespace Veles\Tests\Tools;

use PHPUnit\Framework\TestCase;
use Veles\Tools\CliProgressBarBlocked;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-12-06 at 10:18:45.
 * @group tools
 */
class CliProgressBarBlockedTest extends TestCase
{
	/**
	 * @var CliProgressBarBlocked
	 */
	protected $object;
	protected $final = 60;
	protected $width = 60;
	protected $time_before_init;
	protected $time_after_init;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->time_before_init = microtime(true);
		$this->object = new CliProgressBarBlocked($this->final);
		$this->time_after_init = microtime(true);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
	}

	public function testConstruct()
	{
		$expected = $this->final;
		$msg = 'CliProgressBarBlocked::__construct wrong behavior!';
		$this->assertAttributeSame($expected, 'final_value', $this->object, $msg);

		$expected = $this->width;
		$this->assertAttributeSame($expected, 'width', $this->object, $msg);

		$expected = $this->width / 100;
		$this->assertAttributeSame($expected, 'pb_percent', $this->object, $msg);

		$expected = $this->final / 100;
		$this->assertAttributeSame($expected, 'percent', $this->object, $msg);

		$expected = null;
		$this->assertAttributeNotEquals($expected, 'start_time', $this->object, $msg);
		$expected = 'float';
		$this->assertAttributeInternalType($expected, 'start_time', $this->object, $msg);

		$this->assertAttributeGreaterThanOrEqual($this->time_before_init, 'start_time', $this->object, $msg);
		$this->assertAttributeLessThanOrEqual($this->time_after_init, 'start_time', $this->object, $msg);

		$expected = $this->getObjectAttribute($this->object, 'start_time');
		$this->assertAttributeSame($expected, 'last_update_time', $this->object, $msg);
	}

	/**
	 * @covers \Veles\Tools\CliProgressBarBlocked::update
	 */
	public function testUpdate()
	{
		$mem_string = 'mem-string';
		$stat_string = 'stat-string';
		$status = $stat_string . $mem_string;
		$end = "\033[K\r";

		$this->object = $this->getMockBuilder('\Veles\Tools\CliProgressBarBlocked')
			->setConstructorArgs([60])
			->setMethods(['getStatusString', 'getMemString'])
			->getMock();
		$this->object->expects($this->once())
			->method('getStatusString')
			->willReturn($stat_string);
		$this->object->expects($this->once())
			->method('getMemString')
			->willReturn($mem_string);

		$this->expectOutputString("\033[?25l[=>\033[59C]$status$end");
		$this->object->update(1);
	}

	public function testUpdateTwo()
	{
		$mem_string = 'mem-string';
		$stat_string = 'stat-string';
		$status = $stat_string . $mem_string;
		$end = "\033[K\r";

		$this->object = $this->getMockBuilder('\Veles\Tools\CliProgressBarBlocked')
			->setConstructorArgs([60])
			->setMethods(['getStatusString', 'getMemString'])
			->getMock();
		$this->object->expects($this->once())
			->method('getStatusString')
			->willReturn($stat_string);
		$this->object->expects($this->once())
			->method('getMemString')
			->willReturn($mem_string);

		$filename = uniqid('cli_progressbar_blocked_test_construct') . '.txt';
		file_put_contents($filename, 'test' . PHP_EOL);

		$file_handle = fopen($filename, 'r');
		stream_set_blocking($file_handle, 0);
		$reflection = new \ReflectionClass($this->object);
		$stream_prop = $reflection->getProperty('stream');
		$stream_prop->setAccessible(true);
		$stream_prop->setValue($this->object, $file_handle);

		$this->object->update(1);

		$this->expectOutputString("\033[K\033[1A\033[?25l[=>\033[59C]$status$end");

		fclose($file_handle);
		unlink($filename);
	}
}
