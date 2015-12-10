<?php
namespace Veles\Tests\Model;

use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\Db;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;
use Veles\Model\ActiveRecord;
use Veles\Model\QueryBuilder;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-27 at 16:16:41.
 */
class ActiveRecordTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var ActiveRecord
	 */
	protected $object;
	protected static $news_tbl_name;
	protected static $user_tbl_name;

	public static function setUpBeforeClass()
	{
		// Create test table
		$tbl_name = static::$news_tbl_name = News::TBL_NAME;

		Db::setAdapter(PdoAdapter::instance());
		Db::query("
			CREATE TABLE IF NOT EXISTS $tbl_name (
			  id int(10) unsigned NOT NULL AUTO_INCREMENT,
			  title char(30) NOT NULL,
			  content char(60) NOT NULL,
			  author char(30) NOT NULL,
			  PRIMARY KEY (id)
			) ENGINE=INNODB DEFAULT CHARSET=utf8
		");
		for ($i = 1; $i < 21; ++$i) {
			Db::query("
				INSERT INTO $tbl_name
					(id, title, content, author)
				VALUES
					(?, ?, ?, ?)
			", [$i, "title_$i", "content_$i", "author_$i"], 'isss');
		}

		$tbl_name = static::$user_tbl_name = User::TBL_NAME;
		Db::query("
			CREATE TABLE $tbl_name (
			  id int(10) unsigned NOT NULL DEFAULT '0',
			  `group` tinyint(3) unsigned NOT NULL DEFAULT '16',
			  email char(30) NOT NULL,
			  hash char(60) NOT NULL,
			  short_name char(30) NOT NULL,
			  name char(30) NOT NULL DEFAULT 'n\\a',
			  patronymic char(30) NOT NULL DEFAULT 'n\\a',
			  surname char(30) NOT NULL DEFAULT 'n\\a',
			  birth_date date NOT NULL,
			  last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (id),
			  KEY email (email)
			) ENGINE=INNODB DEFAULT CHARSET=utf8
		");
	}

	public static function tearDownAfterClass()
	{
		$table =& static::$news_tbl_name;
		Db::query("DROP TABLE $table");
		$table =& static::$user_tbl_name;
		Db::query("DROP TABLE $table");
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new ActiveRecord;
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
	 */
	public function testGetById($id, $expected)
	{
		$news = new News;
		$result = $news->getById($id);
		$msg = 'ActiveRecords::getById() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$result = ['id' => '', 'title' => '', 'content' => '', 'author' => ''];
		$expected = ($expected)
			? [
				'id'      => "$id",
				'title'   => "title_$id",
				'content' => "content_$id",
				'author'  => "author_$id"
			]
			: $result;

		$news->getProperties($result);
		$msg = 'Wrong ActiveRecords::getById() behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	public function getByIdProvider()
	{
		return [
			[3, true],
			[0, false],
			[500, false],
			[20, true]
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
		$news = new News;
		$news->title = 'title_21';
		$news->content = 'content_21';
		$news->author = 'author_21';

		$expected = 21;
		$result = $news->save();
		$msg = 'ActiveRecord::save() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$news = new News;
		$news->getById(21);
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
		$news->setProperties($properties);

		$expected = new News;
		$expected->id = 21;
		$expected->title = 'title_21';
		$expected->content = 'content_21';
		$expected->author = 'author_21';

		$msg = 'Wrong ActiveRecord::setProperties() behavior!';
		$this->assertEquals($expected, $news, $msg);
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
	 * @covers Veles\Model\ActiveRecord::find
	 * @dataProvider findProvider
	 */
	public function testFind($id, $expected)
	{
		$news = new News;
		$filter = new DbFilter;
		$filter->setWhere("id = $id");
		$result = $news->find($filter);
		$msg = 'ActiveRecord::find returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		if ($expected) {
			$expected = new News;
			$expected->id = $id;
			$expected->title = "title_$id";
			$expected->content = "content_$id";
			$expected->author = "author_$id";
		} else {
			$expected = new News;
		}

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
	 */
	public function testQuery($pager, $expected)
	{
		$tbl = (false === $pager and false === $expected)
			? static::$user_tbl_name
			: static::$news_tbl_name;

		$sql = "SELECT * FROM $tbl";

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
			[false, $expected1],
			[new DbPaginator(''), $expected2],
			[new DbPaginator('', 3), $expected3],
			[false, false]
		];
	}
}
