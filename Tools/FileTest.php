<?php
/**
 * Unit-test for File class
 * @file    TimerTest.php
 *
 * PHP version 7.1+
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @date    2013-07-27 20:49:51
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests\Tools;

use PHPUnit\Framework\TestCase;
use ReflectionObject;
use Veles\Tools\File;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-07-27 at 20:49:51.
 * @group tools
 */
class FileTest extends TestCase
{
	/**
	 * @var File
	 */
	protected $object;

	/**
	 * @covers \Veles\Tools\File::setDir
	 * @group Tools
	 * @see File::setDir
	 */
	public function testSetDir()
	{
		$this->object->setDir('/www/public/upload');

		$object = new ReflectionObject($this->object);
		$prop = $object->getProperty('dir');

		$msg = 'Property File::$dir not protected';
		self::assertTrue($prop->isProtected(), $msg);

		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = "Wrong value of File::setDir: $result";
		self::assertSame($result, '/www/public/upload', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::getDir
	 * @group Tools
	 * @depends testSetDir
	 * @see File::getDir
	 */
	public function testGetDir()
	{
		$this->object->setDir('/www/upload');

		$result = $this->object->getDir();

		$msg = "Wrong value of File::getDir: $result";
		self::assertSame($result, '/www/upload', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::setMime
	 * @group Tools
	 * @see File::setMime
	 */
	public function testSetMime()
	{
		$this->object->setMime('text/plain');

		$object = new ReflectionObject($this->object);
		$prop = $object->getProperty('mime');

		$msg = 'Property File::$mime not protected';
		self::assertTrue($prop->isProtected(), $msg);

		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = "Wrong value of File::setMime: $result";
		self::assertSame($result, 'text/plain', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::getMime
	 * @group Tools
	 * @depends testSetMime
	 * @see File::getMime
	 */
	public function testGetMimeType()
	{
		$this->object->setMime('application/pdf');

		$result = $this->object->getMime();

		$msg = "Wrong value of File::getMime: $result";
		self::assertSame($result, 'application/pdf', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::setName
	 * @group Tools
	 * @see File::setName
	 */
	public function testSetName()
	{
		$this->object->setName('file.txt');

		$object = new ReflectionObject($this->object);
		$prop = $object->getProperty('name');

		$msg = 'Property File::$name not protected';
		self::assertTrue($prop->isProtected(), $msg);

		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = "Wrong value of File::setName: $result";
		self::assertSame($result, 'file.txt', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::getName
	 * @group Tools
	 * @depends testSetName
	 * @see File::getName
	 */
	public function testGetName()
	{
		$this->object->setName('new-file.txt');

		$result = $this->object->getName();

		$msg = "Wrong value of File::getName: $result";
		self::assertSame($result, 'new-file.txt', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::setPath
	 * @group Tools
	 * @depends testSetName
	 * @depends testSetDir
	 * @see File::setPath
	 */
	public function testSetPath()
	{
		$this->object->setPath('/upload/test-file.php');

		$object = new ReflectionObject($this->object);
		$prop = $object->getProperty('path');

		$msg = 'Property File::$path not protected';
		self::assertTrue($prop->isProtected(), $msg);

		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = "Wrong value of File::setPath: $result";
		self::assertSame($result, '/upload/test-file.php', $msg);


		$prop = $object->getProperty('name');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$msg = "Wrong value of File::setName: $result";
		self::assertSame($result, 'test-file.php', $msg);

		$prop = $object->getProperty('dir');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);
		$msg = "Wrong value of File::setDir: $result";
		self::assertSame($result, '/upload', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::getPath
	 * @group Tools
	 * @depends testSetPath
	 * @see File::getPath
	 */
	public function testGetPath()
	{
		$this->object->setPath('/public');

		$result = $this->object->getPath();

		$msg = "Wrong value of File::getPath: $result";
		self::assertSame($result, '/public', $msg);
	}

	/**
	 * @covers \Veles\Tools\File::delete
	 * @group Tools
	 * @param $path
	 * @param $expected
	 * @dataProvider deleteProvider
	 */
	public function testDelete($path, $expected)
	{
		$this->object->setPath($path);

		$result = $this->object->delete();
		$msg = 'File::delete() returns wrong result!';
		self::assertSame($expected, $result, $msg);

		$expected = false;
		$result = file_exists($path);
		$msg = 'Unexpected behavior or File::delete()!';
		self::assertSame($expected, $result, $msg);
	}

	public function deleteProvider()
	{
		$real_file = tempnam(sys_get_temp_dir(), uniqid());
		return [
			['/lalala', false],
			[$real_file, true],
			[uniqid('wrong-file'), false]
		];
	}

	/**
	 * @covers \Veles\Tools\File::deleteDir
	 * @group Tools
	 * @dataProvider deleteDirProvider
	 */
	public function testDeleteDir($path_dir, $path_file, $expected1, $expected2, $path_file_second)
	{
		$this->object->setPath($path_file);

		$result = $this->object->deleteDir();
		$msg = 'File::deleteDir() returns wrong result!';
		self::assertSame($expected1, $result, $msg);

		$result = !file_exists($path_dir) and !file_exists($path_file);
		$msg = 'Unexpected behavior or File::deleteDir()!';
		self::assertSame($expected2, $result, $msg);

		// cleanup
		if (null !== $path_file_second) {
			$file = new File;
			$file->setPath($path_file_second)->delete();
			$file->setPath($path_file)->deleteDir();
		}
	}

	public function deleteDirProvider()
	{
		$real_dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid();
		mkdir($real_dir);
		$real_file = tempnam($real_dir, uniqid());

		$non_empty_dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid();
		mkdir($non_empty_dir);
		$non_empty_file1 = tempnam($non_empty_dir, uniqid());
		$non_empty_file2 = tempnam($non_empty_dir, uniqid());

		$fake_dir = uniqid('wrong-dir');
		$fake_file = $fake_dir . DIRECTORY_SEPARATOR . uniqid();

		return [
			[$real_dir, $real_file, true, true, null],
			[$fake_dir, $fake_file, false, true, null],
			[$non_empty_dir, $non_empty_file1, false, false, $non_empty_file2]
		];
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new File;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
	}
}
