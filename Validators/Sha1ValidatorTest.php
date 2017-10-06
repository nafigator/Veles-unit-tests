<?php
namespace Veles\Tests\Validators;

use PHPUnit\Framework\TestCase;
use Veles\Validators\Sha1Validator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-10-08 at 18:42:09.
 * @group validators
 */
class Sha1ValidatorTest extends TestCase
{
	/**
	 * @var Sha1Validator
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Sha1Validator;
	}

	/**
	 * @param $flag
	 * @param $expected
	 * @dataProvider constructProvider
	 */
	public function testConstruct($flag, $expected)
	{
		$obj = new Sha1Validator($flag);
		$msg = 'Wrong behavior of Sha1Validator::__construct()';
		$this->assertAttributeSame($expected, 'pattern', $obj, $msg);
	}

	public function constructProvider()
	{
		return [
			[true, '/^[a-f\d]{40}$/'],
			[false, '/^[a-f\d]{40}$/i']
		];
	}

	/**
	 * @covers \Veles\Validators\Sha1Validator::check
	 * @dataProvider checkProvider
	 */
	public function testCheck($value, $expected)
	{
		$result = $this->object->check($value);
		$msg = 'Sha1Validator returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function checkProvider()
	{
		return [
			[sha1(uniqid()), true],
			[md5(uniqid()), false]
		];
	}
}
