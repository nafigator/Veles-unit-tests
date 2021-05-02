<?php
namespace Tests\Request;

use PHPUnit\Framework\TestCase;
use Veles\Request\HttpPostRequest;
use Veles\Request\Validator\Validator;
use Veles\Exceptions\Http\UnprocessableException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-01-18 at 11:11:17.
 * @group request
 */
class HttpPostRequestTest extends TestCase
{
	/**
	 * @var HttpPostRequest
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new HttpPostRequest;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
		unset($_POST);
	}

	/**
	 * @dataProvider postProvider
	 */
	public function testGetBody($expected): void
	{
		$_POST = $expected;

		$actual = $this->object->getBody();
		$msg = 'HttpPostRequest returns wrong result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function postProvider(): array
	{
		return [
			[[uniqid(), uniqid()]],
			[[uniqid()]],
			[[uniqid()]]
		];
	}

	/**
	 * @dataProvider checkProvider
	 */
	public function testCheck($post, $definitions, $validator): void
	{
		$_POST = $post;

		$this->object->setValidator($validator);

		$this->object->check($definitions);
	}

	public function checkProvider(): array
	{
		$post1 = [uniqid()];
		$definitions1 = uniqid();

		$validator1 = $this->getMockBuilder(Validator::class)
			->onlyMethods(['check', 'isValid', 'getData'])
			->getMock();

		$validator1->expects(self::once())
			->method('check')
			->with($post1, $definitions1);

		$validator1->expects(self::once())
			->method('isValid')
			->willReturn(true);

		$validator1->expects(self::once())
			->method('getData')
			->willReturn($post1);

		$post2 = [uniqid()];
		$definitions2 = uniqid();

		$validator2 = $this->getMockBuilder(Validator::class)
			->onlyMethods(['check', 'isValid', 'getData'])
			->getMock();

		$validator2->expects(self::once())
			->method('check')
			->with($post2, $definitions2);

		$validator2->expects(self::once())
			->method('isValid')
			->willReturn(true);

		$validator2->expects(self::once())
			->method('getData')
			->willReturn($post2);

		return [
			[
				$post1, $definitions1, $validator1
			],
			[
				$post2, $definitions2, $validator2
			]
		];
	}

	/**
	 * @dataProvider checkExceptionProvider
	 */
	public function testCheckException($post, $definitions, $validator): void
	{
		$this->expectException(UnprocessableException::class);
		$_POST = $post;

		$this->object->setValidator($validator);
		$this->expectOutputString('{"errors":["ERROR_MSG"]}');

		$this->object->check($definitions);
	}

	public function checkExceptionProvider(): array
	{
		$post1 = [uniqid()];
		$definitions1 = uniqid();
		$error = ['ERROR_MSG'];

		$validator1 = $this->getMockBuilder(Validator::class)
			->onlyMethods(['check', 'isValid', 'getErrors'])
			->getMock();

		$validator1->expects(self::once())
			->method('check')
			->with($post1, $definitions1);

		$validator1->expects(self::once())
			->method('isValid')
			->willReturn(false);

		$validator1->expects(self::once())
			->method('getErrors')
			->willReturn($error);

		return [
			[
				$post1, $definitions1, $validator1
			]
		];
	}
}
