<?php
namespace Veles\Tests\Validators;

use Veles\Validators\PhpTokenValidator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-22 at 23:26:24.
 * @group validators
 */
class PhpTokenValidatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PhpTokenValidator
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new PhpTokenValidator;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\Validators\PhpTokenValidator::check
	 * @dataProvider checkProvider
	 */
	public function testCheck($data, $expected)
	{
		$result = $this->object->check($data);

		$msg = 'PhpTokenValidator returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function checkProvider()
	{
		return [
			['simple string', true],
			[[1, 2, 3], true],
			[[1, 2], false],
			[new \StdClass, false]
		];
	}
}
