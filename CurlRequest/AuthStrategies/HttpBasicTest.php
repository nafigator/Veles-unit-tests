<?php
namespace Veles\Tests\CurlRequest;

use Veles\CurlRequest\AuthStrategies\HttpBasic;
use Veles\CurlRequest\CurlRequest;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-23 at 14:12:01.
 *
 * @group curl-request
 */
class HttpBasicTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var HttpBasic
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new HttpBasic;
	}

	/**
	 * @covers Veles\CurlRequest\AuthStrategies\HttpBasic::setPassword
	 */
	public function testSetPassword()
	{
		$expected = uniqid();

		$actual = $this->object->setPassword($expected);
		$msg = 'HttpBasic::setPassword() wrong behavior!';
		$this->assertAttributeSame($expected, 'password', $this->object, $msg);

		$msg = 'HttpBasic::setPassword() returns wrong result!';
		$this->assertSame($this->object, $actual, $msg);
	}

	/**
	 * @covers Veles\CurlRequest\AuthStrategies\HttpBasic::getPassword
	 *
	 * @depends testSetPassword
	 */
	public function testGetPassword()
	{
		$expected = uniqid();
		$this->object->setPassword($expected);

		$actual = $this->object->getPassword();
		$msg = 'HttpBasic::getPassword() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers Veles\CurlRequest\AuthStrategies\HttpBasic::setLogin
	 */
	public function testSetLogin()
	{
		$expected = uniqid();

		$actual = $this->object->setLogin($expected);
		$msg = 'HttpBasic::setLogin() wrong behavior!';
		$this->assertAttributeSame($expected, 'login', $this->object, $msg);

		$msg = 'HttpBasic::setLogin() returns wrong result!';
		$this->assertSame($this->object, $actual, $msg);
	}

	/**
	 * @covers Veles\CurlRequest\AuthStrategies\HttpBasic::getLogin
	 *
	 * @depends testSetLogin
	 */
	public function testGetLogin()
	{
		$expected = uniqid();
		$this->object->setLogin($expected);

		$actual = $this->object->getLogin();
		$msg = 'HttpBasic::getLogin() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers Veles\CurlRequest\AuthStrategies\HttpBasic::apply
	 *
	 * @depends testGetPassword
	 * @depends testSetPassword
	 * @depends testGetLogin
	 * @depends testSetLogin
	 */
	public function testApply()
	{
		$url      = 'http://my-host.local';
		$login    = uniqid();
		$password = uniqid();

		$this->object->setPassword($password)->setLogin($login);

		$hash = base64_encode(
			$this->object->getLogin() . ':' . $this->object->getPassword()
		);
		$expected = ["Authorization: Basic $hash"];

		$request = new CurlRequest($url);
		$this->object->apply($request);

		$actual = $request->getHeaders();
		$msg = 'HttpBasic::apply() wrong behavior!';
		$this->assertSame($expected, $actual, $msg);
	}
}
