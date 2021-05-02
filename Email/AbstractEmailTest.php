<?php
namespace Veles\Tests\Email;

use PHPUnit\Framework\TestCase;
use Veles\Email\AbstractEmail;
use Veles\ErrorHandler\Subscribers\EmailNotifier;

require 'mail.php';
require 'phpversion.php';

/**
 * @group email
 */
class AbstractEmailTest extends TestCase
{
	public const RECEIVER = 'master@mail.ru';
	public const SUBJECT = 'Important note';
	public const ENCODED_SUBJECT = '=?ascii?B?SW1wb3J0YW50IG5vdGU=?=';
	public const CHARSET = 'ascii';
	public const MESSAGE = null;
	public const CUSTOM_HEADER = 'X-Application: Veles unit-tests';
	public const HEADERS = 'X-Application: Veles unit-tests
X-Mailer: PHP/Veles test 1.0.0
MIME-Version: 1.0
Content-type: text/html; charset=ascii
Content-Transfer-Encoding: base64';
	public const PHP_VERSION = 'Veles test 1.0.0';

	/**
	 * @var AbstractEmail
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new EmailNotifier;
	}

	/**
	 * @dataProvider sendProvider
	 */
	public function testSend($receivers): void
	{
		$stub = $this
			->getMockBuilder(EmailNotifier::class)
			->onlyMethods(['realSend'])
			->getMock();

		$stub->setReceivers($receivers);
		$stub->expects(self::exactly(count($receivers)))
			->method('realSend')
			->willReturn(true);

		$stub->send();
	}

	public function sendProvider(): array
	{
		return [
			[['receiver@dot.com']],
			[['receiver@dot.com', 'receiver1@dot.com', 'receiver2@dot.com']],
			[[]],
			[[
				'receiver@dot.com',
				'receiver1@dot.com',
				'receiver2@dot.com',
				'receiver3@dot.com',
				'receiver4@dot.com'
			]]
		];
	}

	public function testSetSubject(): void
	{
		$this->object->setReceivers([static::RECEIVER]);
		$this->object->setCharset(static::CHARSET);
		$this->object->setSubject(static::SUBJECT);
		$this->object->addHeaders(static::CUSTOM_HEADER);
		$this->object->init();

		$msg = 'AbstractEmail::setSubject() wrong behavior!';

		self::assertNull($this->object->send(), $msg);
	}

	public function testGetCharset(): void
	{
		$expected = 'utf-8';
		$result = $this->object->getCharset();

		$msg = 'AbstractEmail::getCharset() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	public function testGetEncoding(): void
	{
		$expected = 'base64';
		$this->object->setEncoding($expected);
		$actual = $this->object->getEncoding();

		$msg = 'AbstractEmail::getEncoding() returns wrong result!';
		self::assertSame($expected, $actual, $msg);
	}

}
