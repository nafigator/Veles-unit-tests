<?php
namespace Tests\Request\Validator;

use Veles\Request\Validator\Validator;
use Veles\Request\Validator\Adapters\JsonSchemaAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-01-17 at 15:35:34.
 * @group request
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Validator
	 */
	protected $object;
	protected $adapter;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Validator;
		$this->adapter = $this->getMockBuilder(JsonSchemaAdapter::class)
			->setMethods(['addError', 'getErrors', 'check', 'isValid'])
			->disableOriginalConstructor()
			->getMock();
		$this->object->setAdapter($this->adapter);
	}

	/**
	 * @covers \Veles\Request\Validator\Validator::addError
	 */
	public function testAddError()
	{
		$field    = uniqid();
		$message  = uniqid();
		$array = [['field' => $field, 'message' => $message]];

		$this->adapter->expects($this->once())
			->method('addError');

		$this->object->addError($array);
	}

	/**
	 * @covers \Veles\Request\Validator\Validator::getErrors
	 */
	public function testGetErrors()
	{
		$field    = uniqid();
		$message  = uniqid();
		$expected = [['field' => $field, 'message' => $message]];

		$this->adapter->expects($this->once())
			->method('getErrors')
			->willReturn($expected);

		$actual = $this->object->getErrors();
		$msg = 'Validator::getErrors() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Request\Validator\Validator::check
	 */
	public function testCheck()
	{
		$data        = uniqid();
		$definitions = uniqid();

		$this->adapter->expects($this->once())
			->method('check')
			->with($data, $definitions);

		$this->object->check($data, $definitions);
	}

	/**
	 * @covers \Veles\Request\Validator\Validator::isValid
	 */
	public function testIsValid()
	{
		$expected = true;
		$this->adapter->expects($this->once())
			->method('isValid')
			->willReturn($expected);

		$actual = $this->object->isValid();
		$msg = 'Validator::isValid() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Request\Validator\Validator::getAdapter
	 */
	public function testGetAdapter()
	{
		$expected = new JsonSchemaAdapter(true, false);

		$this->object->setAdapter($expected);

		$actual = $this->object->getAdapter();
		$msg = 'Validator::getAdapter() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Request\Validator\Validator::setAdapter
	 */
	public function testSetAdapter()
	{
		$expected = new JsonSchemaAdapter(true, false);

		$actual = $this->object->setAdapter($expected);

		$msg = 'Validator::setAdapter() returns wrong result!';
		$this->assertSame($this->object, $actual, $msg);

		$msg = 'Validator::setAdapter() wrong behavior!';
		$this->assertAttributeSame($expected, 'adapter', $this->object, $msg);
	}
}