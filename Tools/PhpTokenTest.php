<?php
namespace Veles\Tests\Tools;

use Veles\Tools\PhpToken;
use Veles\Validators\PhpTokenValidator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-09-06 at 09:29:56.
 * @group tools
 */
class PhpTokenTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PhpToken
	 */
	protected $object;
	private static $content = 'this is test content';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$validator = new PhpTokenValidator;
		$this->object = new PhpToken(self::$content, $validator);
    }

	/**
	 * @covers Veles\Tools\PhpToken::setName
	 */
	public function testSetName()
	{
		$expected = uniqid();
		$this->object->setName($expected);

		$msg = 'Wrong behavior of PhpToken::setName()';
		$this->assertAttributeSame($expected, 'name', $this->object, $msg);
	}

	/**
	 * @covers Veles\Tools\PhpToken::getName
	 */
	public function testGetName()
	{
		$this->object->setId(334);
		$expected = token_name(334);

		$result = $this->object->getName();

		$msg = 'Wrong behavior of PhpToken::getName()';
		$this->assertSame($expected, $result, $msg);
	}
}
