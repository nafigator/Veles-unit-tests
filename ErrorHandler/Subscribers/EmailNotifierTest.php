<?php
namespace Veles\Tests\ErrorHandler\Subscribers;

use Tests\ErrorHandler\Subscribers\UpdateTestHandler;
use Veles\ErrorHandler\ExceptionHandler;
use Veles\ErrorHandler\HtmlBuilders\ErrorBuilder;
use Veles\ErrorHandler\Subscribers\EmailNotifier;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-06 at 08:21:33.
 * @group error-handler
 */
class EmailNotifierTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var EmailNotifier
	 */
	protected $object;
	protected $message = 'ERROR UNIT_TEST!';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new EmailNotifier;
	}

	/**
	 * @covers \Veles\ErrorHandler\Subscribers\EmailNotifier::update
	 */
	public function testUpdate()
	{
		$stub = $this->getMockBuilder('\Veles\ErrorHandler\Subscribers\EmailNotifier')
			->setMethods(['getMessageBuilder', 'init', 'send'])
			->getMock();

		$builder = new ErrorBuilder;
		$builder->setTemplate('Errors/exception.phtml');

		$stub->method('getMessageBuilder')->willReturn($builder);
		$stub->expects($this->once())->method('init')->willReturn(null);
		$stub->expects($this->once())->method('send')->willReturn(null);

		$exception = new \Exception($this->message);
		$handler = new ExceptionHandler;
		$handler->run($exception);

		$stub->update($handler);
	}

	public function testUpdateNull()
	{
		$handler  = new UpdateTestHandler;
		$expected = null;
		$actual   = $this->object->update($handler);
		$msg      = 'ErrorRenderer::update() returns wrong result!';

		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\ErrorHandler\Subscribers\EmailNotifier::setMessageBuilder
	 */
	public function testSetMessageBuilder()
	{
		$expected = new ErrorBuilder;
		$this->object->setMessageBuilder($expected);

		$msg = 'EmailNotifier::setMessageBuilder() wrong behavior!';
		$this->assertAttributeSame($expected, 'message_builder', $this->object, $msg);
	}

	/**
	 * @covers \Veles\ErrorHandler\Subscribers\EmailNotifier::getMessageBuilder
	 * @depends testSetMessageBuilder
	 */
	public function testGetMessageBuilder()
	{
		$expected = new ErrorBuilder;
		$this->object->setMessageBuilder($expected);

		$result = $this->object->getMessageBuilder();
		$msg = 'EmailNotifier::getMessageBuilder() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\ErrorHandler\Subscribers\EmailNotifier::init
	 */
	public function testInit()
	{
		$charset  = $this->object->getCharset();
		$encoding = $this->object->getEncoding();

		$expected = 'X-Mailer: PHP/' . phpversion() . "\n";
		$expected .= "MIME-Version: 1.0\n";
		$expected .= "Content-type: text/html; charset=$charset\n";
		$expected .= "Content-Transfer-Encoding: $encoding";

		$this->object->init();

		$msg = 'EmailNotifier::init() wrong behavior!';
		$this->assertAttributeSame($expected, 'headers', $this->object, $msg);
	}

	/**
	 * @covers \Veles\ErrorHandler\Subscribers\EmailNotifier::addHeaders
	 */
	public function testAddHeaders()
	{
		$header = 'User-Agent: Mozilla v.4.13.0';
		$this->object->addHeaders($header);
		$expected = "$header\n";

		$msg = 'EmailNotifier::addHeaders() wrong behavior!';
		$this->assertAttributeSame($expected, 'headers', $this->object, $msg);
	}
}
