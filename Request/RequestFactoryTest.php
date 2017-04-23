<?php
namespace Tests\Request;

use Veles\Request\RequestFactory;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-04-23 at 17:41:07.
 * @group request
 */
class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var RequestFactory
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new RequestFactory;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Request\RequestFactory::create
	 *
	 * @param $content_type
	 * @param $expected
	 *
	 * @dataProvider createProvider
	 */
	public function testCreate($content_type, $expected)
	{
		$_SERVER['HTTP_CONTENT_TYPE'] = $content_type;

		$actual = $this->object->create();
		$msg = 'RequestFactory::create() returns wrong result!';
		$this->assertInstanceOf($expected, $actual, $msg);
	}

	public function createProvider()
	{
		return [
			[null, 'Veles\Request\HttpGetRequest'],
			['text/html', 'Veles\Request\HttpGetRequest'],
			['text/html; charset=UTF-8', 'Veles\Request\HttpGetRequest'],
			['application/x-www-form-urlencoded; charset=UTF-8', 'Veles\Request\HttpPostRequest'],
			['application/x-www-form-urlencoded', 'Veles\Request\HttpPostRequest'],
			['multipart/form-data', 'Veles\Request\HttpPostRequest'],
			['multipart/form-data; charset=UTF-8', 'Veles\Request\HttpPostRequest'],
			['application/json', 'Veles\Request\HttpPostRequest']
		];
	}
}
