<?php
namespace Veles\Tests\ErrorHandler\Subscribers;

use Exception;
use PHPUnit\Framework\TestCase;
use Tests\ErrorHandler\Subscribers\UpdateTestHandler;
use Veles\ErrorHandler\ExceptionHandler;
use Veles\ErrorHandler\HtmlBuilders\ErrorBuilder;
use Veles\ErrorHandler\Subscribers\ErrorRenderer;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-06 at 08:25:43.
 * @group error-handler
 */
class ErrorRendererTest extends TestCase
{
	/**
	 * @var ErrorRenderer
	 */
	protected $object;
	protected $message = 'THIS IS TEST ERROR!';
	protected $html;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new ErrorRenderer;
		$this->html = <<<EOL
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	2016-10-10 12:23:00<br>
	USER NOTICE<br>
	$this->message<br>
	index.php<br>
	23<br>
	<tr>
		<td>1</td>
		<td>PHPUnit_Framework_TestCase->runTest()</td>
		<td>phar:///usr/local/bin/phpunit/phpunit/Framework/TestCase.php<b>:</b>844</td>
	</tr>
	<tr>
		<td>2</td>
		<td>test()</td>
		<td>phar:///usr/local/bin/phpunit/phpunit/Framework/TestCase.php<b>:</b>822</td>
	</tr>
</body>
</html>

EOL;
	}

	/**
	 * @dataProvider updateProvider
	 */
	public function testUpdate($vars): void
	{
		$handler = $this->getMockBuilder(ExceptionHandler::class)
			->onlyMethods(['getVars'])
			->getMock();

		$handler->expects(self::once())
			->method('getVars')
			->willReturn($vars);

		$builder = new ErrorBuilder;
		$builder->setTemplate('Errors/exception.phtml');

		$exception = new Exception($this->message);
		$handler->run($exception);

		$this->expectOutputString($this->html);

		$this->object->setMessageBuilder($builder);
		$this->object->update($handler);
	}

	public function updateProvider(): array
	{
		return [
			[
				[
					'time'    => '2016-10-10 12:23:00',
					'message' => $this->message,
					'file'    => 'index.php',
					'line'    => 23,
					'stack'   => [
						[
							'file'     => "phar:///usr/local/bin/phpunit/phpunit/Framework/TestCase.php",
							'line'     => 844,
							'function' => "runTest",
							'class'    => "PHPUnit_Framework_TestCase",
							'type'     => "->",
							'args'     => []
						],
						[
							'file'     => "phar:///usr/local/bin/phpunit/phpunit/Framework/TestCase.php",
							'line'     => 822,
							'function' => "test",
							'args'     => []
						]
					],
					'type'    => 1024,
					'defined' => ['exception' => new Exception($this->message)]
				]
			]
		];
	}

	public function testUpdateNull(): void
	{
		$handler  = new UpdateTestHandler;
		$expected = null;
		$actual   = $this->object->update($handler);
		$msg      = 'ErrorRenderer::update() returns wrong result!';

		self::assertSame($expected, $actual, $msg);
	}

	public function testGetMessageBuilder(): void
	{
		$expected = new ErrorBuilder;
		$this->object->setMessageBuilder($expected);

		$result = $this->object->getMessageBuilder();
		$msg = 'ErrorRenderer::getMessageBuilder() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}
}
