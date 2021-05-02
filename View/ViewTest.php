<?php
/**
 * Unit-test for View class
 * @file    ViewTest.php
 *
 * PHP version 7.1+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    Вск Янв 20 18:40:31 2013
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\View;

use Exception;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use Veles\View\Adapters\NativeAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 18:39:47.
 * @group view
 */
class ViewTest extends TestCase
{
	/**
	 * Container for View object
	 * @var View
	 */
	protected $object;

	/**
	 * File name of template
	 * @var string
	 */
	protected $tpl;

	/**
	 * Final HTML output
	 * @var string
	 */
	protected $html;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new View;
		$this->tpl = 'Frontend/index.phtml';

		$this->html = <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Veles is a fast PHP framework</title>
</head>
<body>
	<div id="main_wrapper">
		Test complete!
	</div>
	<div id="footer_wrapper">
		Hello World!
	</div>
</body>
</html>

EOF;
	}

	protected function tearDown(): void
	{
		View::setAdapter(NativeAdapter::instance());
	}

	public function testGetAdapter(): void
	{
		$expected = NativeAdapter::instance();
		$_SERVER['REQUEST_URI'] = 'index.html';

		$actual = View::getAdapter();
		$msg = 'Wrong View::getAdapter() result';
		self::assertSame($expected, $actual, $msg);

		$expected = NativeAdapter::instance();
		View::unsetAdapter();
		View::setAdapter($expected);

		$actual = View::getAdapter();

		self::assertSame($expected, $actual, $msg);
	}

	public function testGetAdapterException(): void
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('View adapter not set!');

		View::unsetAdapter();
		View::getAdapter();
	}

	/**
	 * @dataProvider setProvider
	 */
	public function testSet($vars): void
	{
		$this->object::set($vars);

		$this->expectOutputString($this->html);

		$this->object::show($this->tpl);
	}

	public function setProvider(): array
	{
		return [
			[
				['a' => 'Test', 'b' => 'complete', 'c' => 'Hello']
			]
		];
	}

	/**
	 * @dataProvider delProvider
	 */
	public function testDel($vars, $del, $expected): void
	{
		View::set($vars);
		View::del($del);

		$object = new ReflectionObject(View::getAdapter());

		$prop = $object->getProperty('variables');
		$prop->setAccessible(true);
		$result = $prop->getValue(View::getAdapter());
		$msg = 'Wrong View::del() behavior!';

		foreach ($expected as $var => $value) {
			self::assertSame($value, isset($result[$var]), $msg);
		}
	}

	public function delProvider(): array
	{
		return [
			[
				['variable-1' => 'string', 'variable-2' => 'string'],
				['variable-1'],
				['variable-1' => false, 'variable-2' => true]
			],
			[
				['variable-3' => 'string', 'variable-4' => 'string'],
				['variable-4'],
				['variable-3' => true, 'variable-4' => false]
			]
		];
	}

	public function testIsCached(): void
	{
		$adapter = View::getAdapter();
		$tpl = $adapter->getTemplateDir();

		$expected = $adapter->isCached($tpl);
		$result = View::isCached($tpl);

		$msg = 'Wrong View::isCached() result!';
		self::assertSame($expected, $result, $msg);
	}

	public function testShow(): void
	{
		$this->expectOutputString($this->html);

		$this->object::show($this->tpl);
	}

	public function testGet(): void
	{
		$expected =& $this->html;

		$actual = $this->object::get($this->tpl);

		$msg = 'Wrong content of HTML in View::get()';
		self::assertSame($expected, $actual, $msg);
	}
}
