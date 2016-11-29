<?php
namespace Veles\Tests\DataBase\Loggers;

use Veles\DataBase\Loggers\PdoErrorLogger;

require 'error_log_stub.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-20 at 13:07:32.
 * @group database
 */
class PdoErrorLoggerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PdoErrorLogger
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new PdoErrorLogger;
	}

	/**
	 * @covers \Veles\DataBase\Loggers\PdoErrorLogger::setPath
	 */
	public function testSetPath()
	{
		$msg = 'Wrong initial value of PdoErrorLogger::path';
		$this->assertAttributeSame(null, 'path', $this->object, $msg);

		$expected = '/this/is/path';
		$this->object->setPath($expected);

		$msg = 'Wrong behavior of PdoErrorLogger::setPath()';
		$this->assertAttributeSame($expected, 'path', $this->object, $msg);
	}

	/**
	 * @covers \Veles\DataBase\Loggers\PdoErrorLogger::getPath
	 * @depend testSetPath
	 */
	public function testGetPath()
	{
		$expected = '/this/is/path';
		$this->object->setPath($expected);

		$result = $this->object->getPath();
		$msg = 'Wrong result of PdoErrorLogger::getPath()';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       \Veles\DataBase\Loggers\PdoErrorLogger::update
	 * @dataProvider updateProvider
	 *
	 * @param $subject
	 * @param $error
	 */
	public function testUpdate($subject, $error)
	{
		$log_path = __DIR__ . '/' . uniqid() . '.log';
		$this->object->setPath($log_path);

		$expected = empty($error)
			? ''
			: implode('; ', $error) . PHP_EOL . 3 . PHP_EOL . $log_path;

		$this->expectOutputString($expected);
		$this->object->update($subject);
	}

	public function updateProvider()
	{
		$subject_1 = new FakeSubject();
		$conn_good = new FakeStmt();
		$conn_good->setErrorCode('00000');
		$subject_1->setResource($conn_good);
		$subject_1->setStmt($conn_good);

		$info2 = [555, 555, 'This is first error!'];
		$subject_2 = new FakeSubject();
		$conn_bad  = new FakeStmt();
		$conn_bad->setErrorCode('11000');
		$conn_bad->setErrorInfo($info2);
		$subject_2->setResource($conn_good);
		$subject_2->setStmt($conn_bad);

		$info3 = [777, 777, 'This is second error!'];
		$subject_3 = new FakeSubject();
		$conn_bad1 = new FakeStmt();
		$conn_bad1->setErrorCode('11000');
		$conn_bad1->setErrorInfo($info3);
		$subject_3->setResource($conn_bad1);
		$subject_3->setStmt($conn_good);

		return [
			[$subject_1, []],
			[$subject_2, $info2],
			[$subject_3, $info3]
		];
	}
}
