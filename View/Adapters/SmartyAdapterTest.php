<?php
namespace Veles\Tests\View\Adapters;

use PHPUnit\Framework\TestCase;
use Veles\View\Adapters\SmartyAdapter;

include_once 'Smarty/Smarty.class.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-06-08 at 07:47:07.
 *
 * @group view
 */
class SmartyAdapterTest extends TestCase
{
	/**
	 * @var SmartyAdapter
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new SmartyAdapter;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::__construct
	 */
	public function testConstruct()
	{
		$msg = 'SmartyAdapter::__construct() wrong behavior!';
		$this->assertAttributeInstanceOf('\Smarty', 'driver', $this->object, $msg);
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::set
	 */
	public function testSet()
	{
		$vars = ['variable-1' => 100, 'variable-2' => 200];

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['assign'])
			->getMock();
		$driver->expects($this->exactly(2))
			->method('assign')
			->withConsecutive(['variable-1', 100], ['variable-2', 200]);

		$this->object->setDriver($driver);
		$this->object->set($vars);
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::del
	 */
	public function testDel()
	{
		$vars = ['variable-1', 'variable-2'];

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['clearAssign'])
			->getMock();
		$driver->expects($this->exactly(2))
			->method('clearAssign')
			->withConsecutive(['variable-1'], ['variable-2']);

		$this->object->setDriver($driver);
		$this->object->del($vars);
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::show
	 */
	public function testShow()
	{
		$path = '/path/to/template';

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['display'])
			->getMock();
		$driver->expects($this->once())
			->method('display')
			->with($path);

		$this->object->setDriver($driver);
		$this->object->show($path);
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::get
	 */
	public function testGet()
	{
		$path = '/path/to/template';

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['fetch'])
			->getMock();
		$driver->expects($this->once())
			->method('fetch')
			->with($path);

		$this->object->setDriver($driver);
		$this->object->get($path);
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::clearCache
	 */
	public function testClearCache()
	{
		$path = 'template';

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['clearCache'])
			->getMock();
		$driver->expects($this->once())
			->method('clearCache')
			->with($path);

		$this->object->setDriver($driver);
		$this->object->clearCache($path);
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::clearAllCache
	 */
	public function testClearAllCache()
	{
		$expired = 500;

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['clearAllCache'])
			->getMock();
		$driver->expects($this->exactly(2))
			->method('clearAllCache')
			->withConsecutive([$expired],[null]);

		$this->object->setDriver($driver);
		$this->object->clearAllCache($expired);
		$this->object->clearAllCache();
	}

	/**
	 * @covers \Veles\View\Adapters\SmartyAdapter::isCached
	 */
	public function testIsCached()
	{
		$template = 'template';

		$driver = $this->getMockBuilder('\Smarty')
			->disableOriginalConstructor()
			->setMethods(['isCached'])
			->getMock();
		$driver->expects($this->once())
			->method('isCached')
			->with($template);

		$this->object->setDriver($driver);
		$this->object->isCached($template);
	}
}
