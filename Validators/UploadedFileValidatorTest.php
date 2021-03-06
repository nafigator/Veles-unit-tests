<?php
namespace Veles\Tests\Validators;

use PHPUnit\Framework\TestCase;
use Veles\Validators\UploadedFileValidator;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-12-11 at 13:44:04.
 * @group validators
 */
class UploadedFileValidatorTest extends TestCase
{
	/**
	 * @var UploadedFileValidator
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp(): void
	{
		$this->object = new UploadedFileValidator;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown(): void
	{
	}

	public static function tearDownAfterClass(): void
	{
		system('rm -rf ' . sys_get_temp_dir() . '/VelesUploads-File*');
	}

	/**
	 * @dataProvider checkProvider
	 */
	public function testCheck($name, $expected): void
	{
		$validator = new UploadedFileValidator('gif');
		$result = $validator->check($name);

		$msg = 'UploadedFileValidator::check() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	public function checkProvider(): array
	{
		$files = [];
		$tmp_dir = sys_get_temp_dir();

		for ($i = 0; $i <= 5; ++$i) {
			$files[$i]['tmp_name'] = tempnam($tmp_dir, 'VelesUploads-File');
			if ($i === 4) {
				$files[$i]['name'] = uniqid('xxx-');
			} elseif ($i === 5) {
				$files[$i]['name'] = uniqid('xxx-') . '.txt';
			} else {
				$files[$i]['name'] = uniqid('xxx-') . '.gif';
			}
			$_FILES["uploaded_file_$i"]['name'] = $files[$i]['name'];
			$_FILES["uploaded_file_$i"]['tmp_name'] = $files[$i]['tmp_name'];
			$_FILES["uploaded_file_$i"]['size'] = 0;
			$_FILES["uploaded_file_$i"]['type'] = 'image/gif; charset=binary';
			$_FILES["uploaded_file_$i"]['error'] = UPLOAD_ERR_OK;
			if ($i === 5) {
				file_put_contents(
					$files[$i]['tmp_name'], "lalala"
				);
			} else {
				file_put_contents(
					$files[$i]['tmp_name'], "GIF89a����!�,D;"
				);
			}
		}

		return [
			['uploaded_file_0', true],
			['uploaded_file_1', true],
			['uploaded_file_2', true],
			['uploaded_file_3', true],
			['uploaded_file_4', false],
			['uploaded_file_5', false]
		];
	}

	/**
	 * @dataProvider getMimeByExtensionProvider
	 */
	public function testGetMimeByExtension($extension, $expected): void
	{
		$result = $this->object->getMimeByExtension($extension);
		$msg = 'UploadedFileValidator::getMimeByExtension() returns wrong result!';
		self::assertSame($expected, $result, $msg);
	}

	public function getMimeByExtensionProvider(): array
	{
		return [
			['gif', 'image/gif; charset=binary'],
			['png', 'image/png; charset=binary'],
			['jpeg', 'image/jpeg; charset=binary'],
			['jpg', 'image/jpeg; charset=binary']
		];
	}
}
