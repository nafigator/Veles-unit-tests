<?php
namespace Tests\Request;

use PHPUnit\Framework\TestCase;
use Veles\Request\HttpJsonRequest;
use Veles\Request\Validator\Validator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-01-29 at 21:29:45.
 * @group request
 */
class HttpJsonRequestTest extends TestCase
{
	/**
	 * @var HttpJsonRequest
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new HttpJsonRequest;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
	}

	/**
	 * @covers \Veles\Request\HttpJsonRequest::getBody
	 */
	public function testGetBody()
	{
		$filename = uniqid() . '.txt';
		$json = '{"message": "this is text"}';
		$expected = ['message' => 'this is text'];

		file_put_contents($filename, $json);
		$this->object->setStream($filename);

		$result = $this->object->getBody();
		unlink($filename);

		$msg = 'HttpJsonRequest::getBody() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\Request\HttpJsonRequest::check
	 */
	public function testCheck()
	{
		$definitions = [
			'message' => [
				'filter'  => FILTER_VALIDATE_REGEXP,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => [
					'regexp'   => '/^this is tests string$/'
				]
			],
			'value' => [
				'filter'  => FILTER_VALIDATE_INT,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => [
					'min_range' => 1,
					'max_range' => PHP_INT_MAX
				]
			]
		];
		$json = '{"message": "this is tests string", "value": 1234}';
		$expected = ['message' => 'this is tests string', 'value' => 1234];

		$this->object = $this->getMockBuilder(HttpJsonRequest::class)
			->setMethods(['getBody'])
			->getMock();

		$this->object->expects($this->once())
			->method('getBody')
			->willReturn(json_decode($json, true));

		$validator = $this->getMockBuilder(Validator::class)
			->setMethods(['check', 'isValid'])
			->getMock();

		$validator->expects($this->once())
			->method('check')
			->with(json_decode($json, true), $definitions);

		$validator->expects($this->once())
			->method('isValid')
			->willReturn(true);

		$this->object->setValidator($validator);

		$this->object->check($definitions);

		$msg = 'HttpJsonRequest::check() wrong behavior!';
		$this->assertAttributeSame($expected, 'data', $this->object, $msg);
	}

	/**
	 * @covers \Veles\Request\HttpJsonRequest::check
	 *
	 * @expectedException \Veles\Exceptions\Http\UnprocessableException
	 */
	public function testCheckException()
	{
		$definitions = [
			'message' => [
				'filter'  => FILTER_VALIDATE_REGEXP,
				'flag'    => FILTER_REQUIRE_SCALAR,
				'options' => [
					'regexp'   => '/^this is tests string$/'
				]
			]
		];

		$errors = ['ERROR_MSG'];
		$json   = '{"message": "this is tests string"}';

		$this->object = $this->getMockBuilder(HttpJsonRequest::class)
			->setMethods(['getBody'])
			->getMock();

		$this->object->expects($this->once())
			->method('getBody')
			->willReturn(json_decode($json, true));

		$validator = $this->getMockBuilder(Validator::class)
			->setMethods(['check', 'isValid', 'getErrors'])
			->getMock();

		$validator->expects($this->once())
			->method('check')
			->with(json_decode($json, true), $definitions);

		$validator->expects($this->once())
			->method('isValid')
			->willReturn(false);

		$validator->expects($this->once())
			->method('getErrors')
			->willReturn($errors);

		$this->object->setValidator($validator);
		$this->expectOutputString('{"errors":["ERROR_MSG"]}');

		$this->object->check($definitions);
	}
}
