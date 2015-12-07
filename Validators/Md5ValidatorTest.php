<?php
namespace Veles\Tests\Validators;

use Veles\Validators\Md5Validator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-01-13 at 20:51:09.
 */
class Md5ValidatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Md5Validator
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Md5Validator;
	}

	/**
	 * @param $flag
	 * @param $expected
	 * @dataProvider constructProvider
	 */
	public function testConstruct($flag, $expected)
	{
		$obj = new Md5Validator($flag);
		$msg = 'Wrong behavior of Md5Validator::__construct()';
		$this->assertAttributeSame($expected, 'pattern', $obj, $msg);
	}

	public function constructProvider()
	{
		return [
			[true, '/^[a-f\d]{32}$/'],
			[false, '/^[a-f\d]{32}$/i']
		];
	}

	/**
	 * @covers Veles\Validators\Md5Validator::check
	 * @dataProvider checkProvider
	 */
	public function testCheck($value, $expected)
	{
		$result = $this->object->check($value);
		$msg = 'Md5Validator returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function checkProvider()
	{
		return [
			[md5(uniqid()), true],
			[sha1(uniqid()), false]
		];
	}
}