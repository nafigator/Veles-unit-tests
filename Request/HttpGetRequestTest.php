<?php
namespace Tests\Request;

use Veles\Request\HttpGetRequest;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-01-18 at 13:08:04.
 * @group request
 */
class HttpGetRequestTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var HttpGetRequest
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new HttpGetRequest;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset($_GET);
	}

	/**
	 * @covers       \Veles\Request\HttpGetRequest::getBody
	 *
	 * @dataProvider getProvider
	 *
	 * @param $expected
	 */
	public function testGetBody($expected)
	{
		$_GET = $expected;

		$actual = $this->object->getBody();
		$msg = 'HttpGetRequest::getBody() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function getProvider()
	{
		return [
			[uniqid()],
			[uniqid()],
			[uniqid()]
		];
	}
}