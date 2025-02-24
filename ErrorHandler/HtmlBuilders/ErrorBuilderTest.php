<?php
namespace Veles\Tests\ErrorHandler\HtmlBuilders;

use Exception;
use PHPUnit\Framework\TestCase;
use Veles\ErrorHandler\ExceptionHandler;
use Veles\ErrorHandler\FatalErrorHandler;
use Veles\ErrorHandler\HtmlBuilders\ErrorBuilder;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-06 at 08:29:36.
 * @group error-handler
 */
class ErrorBuilderTest extends TestCase
{
	/**
	 * @var ErrorBuilder
	 */
	protected $object;
	protected $message = 'Test exception!';
	protected $html;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new ErrorBuilder;
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
		<td></td>
	</tr>
</body>
</html>

EOL;
	}

	/**
	 * @dataProvider getHtmlProvider
	 */
	public function testGetHtml($vars): void
	{
		$handler = $this->getMockBuilder(ExceptionHandler::class)
			->onlyMethods(['getVars'])
			->getMock();

		$handler->expects(self::once())
			->method('getVars')
			->willReturn($vars);

		$this->object->setTemplate('Errors/exception.phtml');
		$this->object->setHandler($handler);

		$expected = $this->html;
		$actual = $this->object->getHtml();

		$msg = 'ErrorBuilder::getHtml() returns wrong result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function getHtmlProvider(): array
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
							'function' => "test",
							'args'     => []
						],
					],
					'type'    => 1024,
					'defined' => ['exception' => new Exception($this->message)]
				],
			],
		];
	}

	public function testGetHandler(): void
	{
		$expected = new FatalErrorHandler;
		$this->object->setHandler($expected);

		$result = $this->object->getHandler();

		$msg = 'ErrorBuilder::getHandler() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	public function testGetTemplate(): void
	{
		$expected = uniqid();
		$this->object->setTemplate($expected);
		$result = $this->object->getTemplate();
		$msg = 'ErrorBuilder::setTemplate() wrong behavior!';
		self::assertSame($expected, $result, $msg);
	}
}
