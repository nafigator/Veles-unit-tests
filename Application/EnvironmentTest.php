<?php
namespace Tests\Application;

use Veles\Application\Environment;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-11-05 at 10:23:51.
 * @group application
 */
class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Environment
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Environment;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\Application\Environment::setStaticPath
	 */
	public function testSetStaticPath()
	{
		$expected = uniqid();
		$this->object->setStaticPath($expected);

		$msg = 'Environment::setStaticPath() wrong behavior!';
		$this->assertAttributeSame($expected, 'static_path', $this->object, $msg);
	}

	/**
	 * @covers \Veles\Application\Environment::getStaticPath
	 */
	public function testGetStaticPath()
	{
		$expected = uniqid();
		$this->object->setStaticPath($expected);

		$actual = $this->object->getStaticPath();

		$msg = 'Environment::getStaticPath() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Application\Environment::setName
	 */
	public function testSetName()
	{
		$expected = uniqid();
		$this->object->setName($expected);

		$msg = 'Environment::setName() wrong behavior!';
		$this->assertAttributeSame($expected, 'name', $this->object, $msg);
	}

	/**
	 * @covers \Veles\Application\Environment::getName
	 */
	public function testGetName()
	{
		$expected = uniqid();
		$this->object->setName($expected);

		$actual = $this->object->getName();

		$msg = 'Environment::getName() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}
}
