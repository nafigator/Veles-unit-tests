<?php
namespace Veles\Tests\Routing;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-21 at 18:06:33.
 * @group route
 */
class RouteRegexTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Veles\Routing\RouteRegex
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new RouteRegexChild;
		$this->object->setParams(null);
	}

	/**
	 * @covers       Veles\Routing\RouteRegex::check
	 * @covers       Veles\Routing\RouteRegex::unsetNumericKeys
	 * @dataProvider testCheckProvider
	 *
	 * @param $pattern
	 * @param $url
	 * @param $expected
	 * @param $params
	 */
	public function testCheck($pattern, $url, $expected, $params)
	{
		$result = $this->object->check($pattern, $url);
		$msg = 'Wrong RouteRegex::check() behavior!';
		$this->assertSame($expected, $result, $msg);

		$msg = 'RouteRegex does not match url params!';
		$this->assertAttributeSame($params, 'params', $this->object, $msg);
	}

	public function testCheckProvider()
	{
		return [
			['#^\/article\/(?<id>[\d\w\-]+).html$#', '/article/234.html', true, ['id' => '234']],
			['#^\/article\/(?<id>[\d\w\-]+).html$#', '/article/lal-4.html', true, ['id' => 'lal-4']],
			['#^\/article\/([\d\w\-]+).html$#', '/article/html', false, null],
			['#^\/article\/([\d\w\-]+).html$#', 'index.html', false, null],
			['#^\/article\/([\d\w\-]+).html$#', '/article/lal 4.html', false, null]
		];
	}

	/**
	 * @covers Veles\Routing\RouteRegex::getParams
	 */
	public function testGetParams()
	{
		$pattern = '#^\/article\/(?<id>[\d\w\-]+).html$#';
		$url = '/article/234.html';
		$expected = ['id' => '234'];

		$this->object->check($pattern, $url);
		$result = $this->object->getParams();

		$msg = 'RouteRegex::getParams() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}
