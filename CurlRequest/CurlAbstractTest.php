<?php
namespace Veles\Tests\CurlRequest;

use Veles\CurlRequest\CurlRequest;

require_once 'curl_errno.php';
require_once 'curl_error.php';
require_once 'curl_getinfo.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-23 at 10:43:20.
 *
 * @group curl-request
 */
class CurlAbstractTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var CurlRequest
	 */
	protected $object;
	/** @var string  */
	protected $uri = 'http://localhost';

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new CurlRequest($this->uri);
	}

	/**
	 * @covers Veles\CurlRequest\CurlAbstract::getErrorCode
	 */
	public function testGetErrorCode()
	{
		$expected = 555;

		$actual = $this->object->getErrorCode();
		$msg = 'CurlAbstract::getErrorCode() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers Veles\CurlRequest\CurlAbstract::getError
	 */
	public function testGetError()
	{
		$expected = 'This is test error message!';

		$actual = $this->object->getError();
		$msg = 'CurlAbstract::getError() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers Veles\CurlRequest\CurlAbstract::getInfo
	 *
	 * @dataProvider getInfoProvider
	 *
	 * @param $expected
	 * @param $option
	 */
	public function testGetInfo($expected, $option)
	{
		$actual = $this->object->getInfo($option);
		$msg = 'CurlAbstract::getInfo() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function getInfoProvider()
	{
		$option1 = null;
		$option2 = 'TEST_OPTION';

		return [
			['This is test info message!', $option1],
			["This is test info message for option: $option2!", $option2]
		];
	}

	/**
	 * @covers Veles\CurlRequest\CurlAbstract::getResource
	 */
	public function testGetResource()
	{
		$actual = $this->object->getResource();
		$msg = 'CurlAbstract::getResource() returns wrong result!';
		$this->assertInternalType('resource', $actual, $msg);
	}
}