<?php
namespace Veles\Tests\ErrorHandler;

use PHPUnit\Framework\TestCase;
use Veles\ErrorHandler\BaseErrorHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-08-11 at 19:33:00.
 * @group ErrorHandler
 */
class BaseErrorHandlerTest extends TestCase
{
	/**
	 * @var BaseErrorHandler
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new BaseErrorHandler;
	}

	public function testGetVars(): void
	{
		$expected = [];
		$result = $this->object->getVars();

		$msg = 'BaseErrorHandler::getVars() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	/**
	 * @dataProvider getTimeProvider
	 */
	public function testGetTime($time, $expected): void
	{
		$this->object->setTime($time);

		$msg = 'BaseErrorHandler::getTime() wrong behavior!';

		$result = $this->object->getTime();
		self::assertGreaterThanOrEqual($expected, $result, $msg);

		$expected = strftime('%Y-%m-%d %H:%M:%S', time());
		self::assertLessThanOrEqual($expected, $result, $msg);
	}

	public function getTimeProvider(): array
	{
		$time = strftime('%Y-%m-%d %H:%M:%S', time());

		return [
			[$time, $time],
			[null, $time]
		];
	}
}
