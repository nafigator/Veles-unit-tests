<?php
namespace Veles\Tests\View\Adapters;

use Veles\View\Adapters\NativeAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-20 at 17:47:01.
 * @group view
 */
class NativeAdapterTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var NativeAdapter
	 */
	protected $object;
	/** @var  string */
	protected $html;
	protected $dir;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = NativeAdapter::instance();
		$this->dir = TEST_DIR . '/Project/View/';
		$this->html = <<<EOF
<!DOCTYPE html>
<html>
<head>
	<title>Veles is a fast PHP framework</title>
</head>
<body>
	<div id="main_wrapper">
		la lala!
	</div>
	<div id="footer_wrapper">
		Hello World!
	</div>
</body>
</html>

EOF;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\View\Adapters\NativeAdapter::setTemplateDir
	 */
	public function testSetTemplateDir()
	{
		$expected = '/templates/dir';
		$this->object->setTemplateDir($expected);

		$msg = 'Wrong NativeAdapter::setTemplateDir property value!';
		$this->assertAttributeEquals(
			$expected, 'template_dir', $this->object, $msg
		);
	}

	/**
	 * @covers \Veles\View\Adapters\NativeAdapter::getTemplateDir
	 * @depends testSetTemplateDir
	 */
	public function testGetTemplateDir()
	{
		$expected = '/templates/dir';
		$this->object->setTemplateDir($expected);

		$actual = $this->object->getTemplateDir();

		$msg = 'Wrong NativeAdapter::getTemplateDir() result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\NativeAdapter::show
	 */
	public function testShow()
	{
		$this->object->setTemplateDir($this->dir);
		$this->object->set(['a' => 'la', 'b' => 'lala', 'c' => 'Hello']);

		$this->expectOutputString($this->html);

		$this->object->show('Frontend/index.phtml');
	}

	/**
	 * @covers \Veles\View\Adapters\NativeAdapter::get
	 */
	public function testGet()
	{
		$this->object->setTemplateDir($this->dir);
		$this->object->set(['a' => 'la', 'b' => 'lala', 'c' => 'Hello']);

		$result = $this->object->get('Frontend/index.phtml');
		$msg = 'Wrong NativeAdapter::get() result!';
		$this->assertSame($this->html, $result, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\NativeAdapter::isCached
	 */
	public function testIsCached()
	{
		$expected = false;
		$result = $this->object->isCached('Frontend/index.phtml');

		$msg = 'Wrong NativeAdapter::isCached() result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\NativeAdapter::__construct
	 */
	public function testConstruct()
	{
		$expected = $this->object;
		$result = $this->object->getDriver();

		$msg = 'Wrong NativeAdapter::__construct() behavior!';
		$this->assertSame($expected, $result, $msg);
	}
}
