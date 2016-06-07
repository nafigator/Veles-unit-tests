<?php
namespace Veles\Tests\Model;

use Veles\DataBase\Db;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;
use Veles\Model\ActiveRecord;
use Veles\Model\QueryBuilder;
use Veles\Model\User;
use Veles\Tests\DataBase\DbCopy;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-27 at 16:16:41.
 *
 * @group model
 */
class ActiveRecordTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var ActiveRecord
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new ActiveRecord;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		DbCopy::unsetAdapter();
	}

	/**
	 * @covers Veles\Model\ActiveRecord::getMap
	 */
	public function testGetMap()
	{
		$news = new News;
		$expected = [
			'id'      => 'int',
			'title'   => 'string',
			'content' => 'string',
			'author'  => 'string'
		];
		$result = $news->getMap();
		$msg = 'ActiveRecord::getMap() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       Veles\Model\ActiveRecord::getById
	 * @dataProvider getByIdProvider
	 *
	 * @param $id
	 * @param $expected
	 * @param $db_result
	 */
	public function testGetById($id, $expected, $db_result)
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter->expects($this->once())
			->method('row')
			->willReturn($db_result);

		Db::setAdapter($adapter);

		$news = new News;
		$actual = $news->getById($id);
		$msg = 'ActiveRecords::getById() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);

		$actual = ['id' => '', 'title' => '', 'content' => '', 'author' => ''];
		$expected = ($expected)
			? [
				'id'      => "$id",
				'title'   => "title_$id",
				'content' => "content_$id",
				'author'  => "author_$id"
			]
			: $actual;

		$news->getProperties($actual);
		$msg = 'Wrong ActiveRecords::getById() behavior!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function getByIdProvider()
	{
		$found1 = [
			'id'      => "3",
			'title'   => "title_3",
			'content' => "content_3",
			'author'  => "author_3"
		];

		$found2 = [
			'id'      => "20",
			'title'   => "title_20",
			'content' => "content_20",
			'author'  => "author_20"
		];

		$not_found = [];

		return [
			[3, true, $found1],
			[0, false, $not_found],
			[500, false, $not_found],
			[20, true, $found2]
		];
	}

	/**
	 * @covers Veles\Model\ActiveRecord::getAll
	 */
	public function testGetAll()
	{
		$expected = [];

		for ($i = 1; $i <= 5; ++$i) {
			$expected[] = [
				'id'      => "$i",
				'title'   => "title_$i",
				'content' => "content_$i",
				'author'  => "author_$i"
			];
		}

		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['rows', 'getFoundRows'])
			->getMock();
		$adapter->expects($this->at(0))
			->method('rows')
			->willReturn($expected);
		$adapter->expects($this->at(1))
			->method('rows')
			->willReturn([]);
		$adapter->expects($this->once())
			->method('getFoundRows')
			->willReturn(5);

		Db::setAdapter($adapter);

		$pager = new DbPaginator('paginator_default.phtml');

		$news = new News;
		$result = $news->getAll(false, $pager);
		$msg = 'ActiveRecord::getAll() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$expected = false;
		$user = new User;
		$result = $user->getAll();
		$msg = 'ActiveRecord::getAll() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Model\ActiveRecord::save
	 * @covers Veles\Model\ActiveRecord::update
	 * @covers Veles\Model\ActiveRecord::insert
	 */
	public function testSave()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['query', 'escape', 'getLastInsertId'])
			->getMock();
		$adapter->expects($this->exactly(2))
			->method('query')
			->willReturn(true);
		$adapter->expects($this->once())
			->method('getLastInsertId')
			->willReturn(21);
		$adapter->expects($this->exactly(6))
			->method('escape')
			->willReturn('string');

		Db::setAdapter($adapter);

		$news = new News;
		$news->title = 'title_21';
		$news->content = 'content_21';
		$news->author = 'author_21';

		$expected = true;
		$result = $news->save();
		$msg = 'ActiveRecord::save() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$expected = 21;
		$msg = 'ActiveRecord::save() wrong behavior!';
		$this->assertAttributeSame($expected, 'id', $news, $msg);

		$news->title = 'updated_title_21';

		$expected = true;
		$result = $news->save();
		$msg = 'ActiveRecord::save() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Model\ActiveRecord::delete
	 */
	public function testDelete()
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['query'])
			->getMock();
		$adapter->expects($this->once())
			->method('query')
			->willReturn(true);

		Db::setAdapter($adapter);

		$news = new News;
		$news->id = 21;

		$expected = true;
		$result = $news->delete();
		$msg = 'ActiveRecord::delete() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Model\ActiveRecord::setProperties
	 */
	public function testSetProperties()
	{
		$news = new News;
		$properties = [
			'id' => 21,
			'title' => 'title_21',
			'content' => 'content_21',
			'author' => 'author_21'
		];
		$actual = $news->setProperties($properties);

		$expected = new News;
		$expected->id = 21;
		$expected->title = 'title_21';
		$expected->content = 'content_21';
		$expected->author = 'author_21';

		$msg = 'Wrong ActiveRecord::setProperties() behavior!';
		$this->assertEquals($expected, $news, $msg);

		$expected = $news;
		$msg = 'ActiveRecord::setProperties() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers Veles\Model\ActiveRecord::getProperties
	 */
	public function testGetProperties()
	{
		$expected = [
			'id' => '3',
			'title' => 'title_3',
			'content' => 'content_3',
			'author' => 'author_3'
		];

		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter->expects($this->once())
			->method('row')
			->willReturn($expected);

		Db::setAdapter($adapter);

		$news = new News;
		$news->getById(3);
		$result = [
			'id' => '',
			'title' => '',
			'content' => '',
			'author' => ''
		];
		$news->getProperties($result);
		$msg = 'ActiveRecord::getProperties() wrong behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       Veles\Model\ActiveRecord::find
	 * @dataProvider findProvider
	 *
	 * @param $id
	 * @param $expected
	 */
	public function testFind($id, $expected)
	{
		if ($expected) {
			$expected = new News;
			$expected->id = $id;
			$expected->title = "title_$id";
			$expected->content = "content_$id";
			$expected->author = "author_$id";
		} else {
			$expected = new News;
		}

		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['row'])
			->getMock();
		$adapter->expects($this->once())
			->method('row')
			->willReturn($expected);

		Db::setAdapter($adapter);

		$news = new News;
		$filter = new DbFilter;
		$filter->setWhere("id = $id");
		$result = $news->find($filter);
		$msg = 'ActiveRecord::find returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$msg = 'Wrong ActiveRecord::find() behavior!';
		$this->assertEquals($expected, $news, $msg);
	}

	public function findProvider()
	{
		return [
			[3, true],
			[200, false]
		];
	}

	/**
	 * @covers Veles\Model\ActiveRecord::setBuilder
	 */
	public function testSetBuilder()
	{
		$news = new News;
		$builder = new QueryBuilder;
		$news->setBuilder($builder);
		$msg = 'Wrong ActiveRecord::setBuilder behavior!';
		$this->assertAttributeSame($builder, 'builder', $news, $msg);
	}

	/**
	 * @covers       Veles\Model\ActiveRecord::query
	 * @dataProvider queryProvider
	 *
	 * @param $pager
	 * @param $expected
	 * @param $found_rows
	 */
	public function testQuery($pager, $expected, $found_rows)
	{
		$adapter = $this->getMockBuilder('\Veles\DataBase\Adapters\PdoAdapter')
			->setMethods(['rows', 'getFoundRows'])
			->getMock();
		$adapter->expects($this->once())
			->method('rows')
			->willReturn($expected);

		if ($found_rows) {
			$adapter->expects($this->once())
				->method('getFoundRows')
				->willReturn($found_rows);
		}

		Db::setAdapter($adapter);

		$sql = "SELECT * FROM user";

		$news = new News;
		$result = $news->query($sql, $pager);
		$msg = 'ActiveRecord::query() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function queryProvider()
	{
		$expected1 = [];

		for ($i = 1; $i < 21; $i++) {
			$expected1[] = [
				'id'      => "$i",
				'title'   => "title_$i",
				'content' => "content_$i",
				'author'  => "author_$i"
			];
		}

		$expected2 = [];

		for ($i = 1; $i < 6; $i++) {
			$expected2[] = [
				'id'      => "$i",
				'title'   => "title_$i",
				'content' => "content_$i",
				'author'  => "author_$i"
			];
		}

		$expected3 = [];

		for ($i = 11; $i < 16; $i++) {
			$expected3[] = [
				'id'      => "$i",
				'title'   => "title_$i",
				'content' => "content_$i",
				'author'  => "author_$i"
			];
		}

		return [
			[false, $expected1, 0],
			[new DbPaginator(''), $expected2, 5],
			[new DbPaginator('', 3), $expected3, 5],
			[false, false, 0]
		];
	}
}
