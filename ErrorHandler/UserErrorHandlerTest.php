<?php
namespace Veles\Tests\ErrorHandler;

use PHPUnit\Framework\TestCase;
use Veles\ErrorHandler\UserErrorHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-08-11 at 21:56:30.
 * @group ErrorHandler
 */
class UserErrorHandlerTest extends TestCase
{
	/**
	 * @var UserErrorHandler
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new UserErrorHandler;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\ErrorHandler\UserErrorHandler::run
	 */
	public function testRun()
	{
		$time = strftime('%Y-%m-%d %H:%M:%S', time());
		$file = realpath(__FILE__);
		$msg = 'Undefined variable: a';
		$type = 8;
		$line = 30;

		$expected = [
			'type' => $type,
			'time' => $time,
			'message' => $msg,
			'file' => $file,
			'line' => $line,
			'stack' => array_reverse(debug_backtrace()),
			'defined' => []
		];

		$this->object->setTime($time);
		$this->object->run($type, $msg, $file, $line, []);
		$result = $this->object->getVars();
		// Удаляем последний вызов для корректности теста
		array_pop($result['stack']);

		$msg = 'FatalErrorHandler::run() wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}
}
