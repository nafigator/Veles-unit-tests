<?php
namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Veles\Application\Application;
use Veles\Controllers\RestApiController;
use Veles\Exceptions\Http\NotAllowedException;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-12-08 at 10:42:40.
 * @group controllers
 */
class RestApiControllerTest extends TestCase
{
	/**
	 * @var RestApiController
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new RestApiController(new Application);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
		unset($_SERVER['REQUEST_METHOD']);
	}

	/**
	 * @dataProvider indexExceptionProvider
	 */
	public function testIndexException($method): void
	{
		$this->expectException(NotAllowedException::class);
		$_SERVER['REQUEST_METHOD'] = $method;
		$this->object->index();
	}

	public function indexExceptionProvider(): array
	{
		return [
			['HEAD'],
			['TRACE']
		];
	}

	/**
	 * @dataProvider indexProvider
	 */
	public function testIndex($method): void
	{
		$_SERVER['REQUEST_METHOD'] = $method;
		$object = new RestApiExampleController(new Application);

		$expected = [];
		$actual = $object->index();

		$msg = 'RestApiController::index() returns wrong result!';
		self::assertSame($expected, $actual, $msg);
	}

	public function indexProvider(): array
	{
		return [
			['GET'],
			['POST'],
			['PUT'],
			['DELETE']
		];
	}

	public function testPost(): void
	{
		$this->expectException(NotAllowedException::class);

		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->object->index();
	}

	public function testGet(): void
	{
		$this->expectException(NotAllowedException::class);

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$this->object->index();
	}

	public function testPut(): void
	{
		$this->expectException(NotAllowedException::class);

		$_SERVER['REQUEST_METHOD'] = 'PUT';
		$this->object->index();
	}

	public function testDelete(): void
	{
		$this->expectException(NotAllowedException::class);

		$_SERVER['REQUEST_METHOD'] = 'DELETE';
		$this->object->index();
	}
}
