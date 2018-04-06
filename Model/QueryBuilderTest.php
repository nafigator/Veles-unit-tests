<?php
namespace Veles\Tests\Model;

use PHPUnit\Framework\TestCase;
use Veles\Auth\UsrGroup;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\Db;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;
use Veles\Model\QueryBuilder;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-27 at 16:15:58.
 *
 * @group model
 */
class QueryBuilderTest extends TestCase
{
	/**
	 * @var QueryBuilder
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new QueryBuilder;
	}

	/**
	 * @covers \Veles\Model\QueryBuilder::insert
	 * @covers \Veles\Model\QueryBuilder::sanitize
	 */
	public function testInsert()
	{
		$group = UsrGroup::GUEST;
		$hash  = md5('lalala');

		$adapter = $this->getMockBuilder(PdoAdapter::class)
			->setMethods(['escape'])
			->getMock();
		$adapter->expects($this->exactly(2))
			->method('escape')
			->willReturn('\'escaped-string\'');

		Db::setAdapter($adapter);

		$user        = new UserCopy;
		$user->id    = 1;
		$user->email = 'mail@mail.org';
		$user->hash  = $hash;
		$user->group = $group;
		$user->money = 2.22;
		$user->date  = '1080-12-12';

		$expected = "INSERT \"users\" (\"id\", \"email\", \"hash\", \"group\", \"money\") VALUES (1, 'escaped-string', 'escaped-string', $group, 2.22)";
		$actual = $this->object->insert($user);

		$msg = 'QueryBuilder::insert() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	/**
	 * @covers \Veles\Model\QueryBuilder::update
	 * @covers \Veles\Model\QueryBuilder::sanitize
	 *
	 * @param $user
	 * @param $expected
	 *
	 * @dataProvider updateProvider
	 *
	 * @throws \Exception
	 */
	public function testUpdate($user, $expected)
	{
		$adapter = $this->getMockBuilder(PdoAdapter::class)
			->setMethods(['escape'])
			->getMock();

		$expected_count = $user->last_login
			? 3
			: 2;

		$adapter->expects($this->exactly($expected_count))
			->method('escape')
			->willReturn('\'escaped-string\'');

		Db::setAdapter($adapter);

		$actual = $this->object->update($user);

		$msg = 'QueryBuilder::update() returns wrong result!';
		$this->assertSame($expected, $actual, $msg);
	}

	public function updateProvider()
	{
		$group = UsrGroup::GUEST;
		$hash = md5('lalala');

		$user             = new User;
		$user->id         = 1;
		$user->email      = 'mail@mail.org';
		$user->hash       = $hash;
		$user->group      = $group;
		$user->last_login = '1980-12-01';

		$user1             = new User;
		$user1->id         = 1;
		$user1->email      = 'mail@mail.org';
		$user1->hash       = $hash;
		$user1->group      = $group;
		$user1->last_login = null;

		$expected = "UPDATE \"users\" SET \"email\" = 'escaped-string', \"hash\" = 'escaped-string', \"group\" = 16, \"last_login\" = 'escaped-string' WHERE id = 1";

		$expected1 = "UPDATE \"users\" SET \"email\" = 'escaped-string', \"hash\" = 'escaped-string', \"group\" = 16 WHERE id = 1";

		return [
			[$user, $expected],
			[$user1, $expected1],
		];
	}

	/**
	 * @covers \Veles\Model\QueryBuilder::getById
	 * @covers \Veles\Model\Traits\TableNameHandler::getEscapedTableName()
	 */
	public function testGetById()
	{
		$user = new User;
		$expected = "SELECT * FROM \"users\" WHERE id = 1 LIMIT 1";

		$msg = 'QueryBuilder::getById() returns wrong result!';
		$result = $this->object->getById($user, 1);
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       \Veles\Model\QueryBuilder::delete
	 * @dataProvider deleteProvider
	 *
	 * @param $ids
	 * @param $expected
	 * @param $user
	 *
	 * @throws \Exception
	 */
	public function testDelete($ids, $expected, $user)
	{
		$msg = 'QueryBuilder::delete() returns wrong result!';
		$result = $this->object->delete($user, $ids);
		$this->assertSame($expected, $result, $msg);
	}

	public function deleteProvider()
	{
		$user = new User;
		$user->id = 1;

		return [
			[[1], "DELETE FROM \"users\" WHERE id IN (1)", $user],
			[[1,2,3], "DELETE FROM \"users\" WHERE id IN (1,2,3)", $user]
		];
	}

	/**
	 * @covers       \Veles\Model\QueryBuilder::find
	 * @covers       \Veles\Model\QueryBuilder::extractParams
	 * @dataProvider findProvider
	 *
	 * @param $filter
	 * @param $expected
	 */
	public function testFind($filter, $expected)
	{
		$user = new User;
		$result = $this->object->find($user, $filter);
		$msg = 'QueryBuilder::find() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function findProvider()
	{
		$filter = new DbFilter;
		$filter->setWhere('id = 1');
		return [
			[null, "SELECT \"id\", \"email\", \"hash\", \"group\", \"last_login\" FROM \"users\""],
			[$filter, "SELECT \"id\", \"email\", \"hash\", \"group\", \"last_login\" FROM \"users\" WHERE id = 1"]
		];
	}

	/**
	 * @covers \Veles\Model\QueryBuilder::setPage
	 */
	public function testSetPage()
	{
		$pager = new DbPaginator('');
		$news = new News;
		$expected = 'SELECT SQL_CALC_FOUND_ROWS "id", "title", "content", "author" FROM "news" LIMIT 0, 5';

		$sql = $this->object->find($news, new DbFilter);
		$result = $this->object->setPage($sql, $pager);

		$msg = 'QueryBuilder::setPage returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}
