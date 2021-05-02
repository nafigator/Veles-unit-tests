<?php
/**
 * Юнит-тест для класса Helper
 * @file      HelperTest.php
 *
 * PHP version 7.1+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      Вск Янв 20 15:25:01 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests;

use PHPUnit\Framework\TestCase;
use Veles\Helper;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-20 at 12:06:50.
 * @group RootClasses
 */
class HelperTest extends TestCase
{
	/**
	 * @group RootClasses
	 * @dataProvider genStrProvider
	 */
	public function testGenStr($length, $letters): void
	{
		if (null === $length && null === $letters) {
			$length  = 22;
			$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
			$result  = Helper::genStr();
		} else {
			$result = Helper::genStr($length, $letters);
		}

		$result_length = strlen($result);
		$unknown_array = [];

		$msg = "Wrong result length: $result_length";
		self::assertSame($length, $result_length, $msg);

		for ($i = 0; $i < $result_length; ++$i) {
			if (false === strpos($letters, $result[$i])) {
				$unknown_array[] = '"' . $result[$i] . '"';
			}
		}

		$msg = 'Result contains unknown symbols: ' . implode(',', $unknown_array);
		self::assertEmpty($unknown_array, $msg);
	}

	public function genStrProvider(): array
	{
		return [
			[null, null],
			[21, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./'],
			[30, 'ABCDEFGHIJKLMNOPQRSTUVWX%$#'],
			[30, 'A|@абвгдеёжзийклмнопрстуфхцчшщъыьэюя%$#']
		];
	}

	/**
	 * @group RootClasses
	 * @dataProvider validateEmailProvider
	 */
	public function testValidateEmail($email, $expected): void
	{
		$actual = Helper::validateEmail($email);

		$txt_result = $actual ? 'true' : 'false';
		$msg = "Email $email has wrong validation result: $txt_result";
		self::assertSame($expected, $actual, $msg);
	}

	public function validateEmailProvider(): array
	{
		return [
			['nd_lk.test-pro@mail.ru', true],
			['nd/lk@mail.ru', false],
			['false/email@mailer.ru', false],
			['email@wrong-domain', false],
			['email@wrong_domain.wrongLd', false],
			['email@wrong_domain.wro-d', false]
		];
	}

	/**
	 * @group RootClasses
	 * @dataProvider checkEmailDomainProvider
	 */
	public function testCheckEmailDomain($email, $expected): void
	{
		$actual = Helper::checkEmailDomain($email);

		$txt_result = (true === $actual) ? 'true' : 'false';
		$msg = "Email $email has wrong validation result: $txt_result";
		self::assertSame($expected, $actual, $msg);
	}

	public function checkEmailDomainProvider(): array
	{
		return [
			['webmaster@itvault.info', true],
			['false@itvault.info', true]
		];
	}

	/**
	 * @group RootClasses
	 * @dataProvider translitProvider
	 */
	public function testTranslit($text, $expected): void
	{
		$actual = Helper::translit($text);

		$msg = "Text \"$text\" has wrong translit result: \"$actual\"";
		self::assertSame($expected, $actual, $msg);
	}

	public function translitProvider(): array
	{
		return [
			[
				'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёждийклмнопрстуфхцчшщъыьэюя ".,!?()#@*&[]:;<>+',
				'abvgdeyozhzijklmnoprstufhtschshshhyeyuyaabvgdeyozhdijklmnoprstufhtschshshhyeyuya-'
			]
		];
	}

	/**
	 * @group RootClasses
	 * @dataProvider makeAliasProvider
	 */
	public function testMakeAlias($url, $expected): void
	{
		$actual = Helper::makeAlias($url);

		$msg = "URL \"$url\" has wrong make alias result: \"$actual\"";
		self::assertSame($expected, $actual, $msg);
	}

	public function makeAliasProvider(): array
	{
		return [
			['Кровельная черепица', 'krovelnaya-cherepitsa'],
			['Внеземные цивилизации', 'vnezemnye-tsivilizatsii']
		];
	}
}
