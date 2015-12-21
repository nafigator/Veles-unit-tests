<?php
namespace Veles\Tests\ErrorHandler;

use Veles\ErrorHandler\FatalErrorHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-08-11 at 20:07:35.
 * @group ErrorHandler
 */
class FatalErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var FatalErrorHandler
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new FatalErrorHandler;
	}

	/**
	 * @covers       Veles\ErrorHandler\FatalErrorHandler::run
	 */
	public function testRun()
	{
		$expected = null;
		$this->object->run();
		$result = $this->object->getVars();

		$msg = 'FatalErrorHandler::run() wrong behavior!';
		$this->assertSame($expected, $result, $msg);

		/** @noinspection PhpUndefinedVariableInspection */
		@$b = $a['none'];

		$time = strftime('%Y-%m-%d %H:%M:%S', time());

		$expected = [
			'type' => 8,
			'message' => 'Undefined variable: a',
			'file' => realpath(__FILE__),
			'line' => 39,
			'time' => $time,
			'stack' => [],
			'defined' => []
		];

		$this->object->setTime($time);
		$this->object->run();
		$result = $this->object->getVars();

		$msg = 'FatalErrorHandler::run() wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}
}
