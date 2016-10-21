<?php
/**
 * Unit-test for AutoLoader class
 *
 * @file      AutoLoaderTest.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      Вск Янв 20 22:07:49 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Tests;

use PHPUnit_Framework_TestCase;
use Veles\AutoLoader;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 21:31:21.
 * @group RootClasses
 */
class AutoLoaderTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for AutoLoader::init
	 * @group RootClasses
	 * @covers Veles\AutoLoader::init
	 * @see    Veles\AutoLoader::init
	 */
	public function testInit()
	{
		// Удаляем автолоадер из списка зарегистрированных
		spl_autoload_unregister('Veles\AutoLoader::load');

		AutoLoader::init();

		$auto_loaders = spl_autoload_functions();
		$result = array_search(
			['Veles\AutoLoader', 'load'],
			$auto_loaders
		);

		$msg = 'AutoLoader function not registered!';
		$this->assertNotSame(false, $result, $msg);
		$this->assertInternalType('integer', $result, $msg);
	}

	/**
	 * Unit-test for AutoLoader::load
	 * @group RootClasses
	 * @covers Veles\AutoLoader::load
	 * @see    AutoLoader::load()
	 */
	public function testLoad()
	{
		AutoLoader::load('Veles\Tests\AutoLoaderFake');

		$result = array_search('Veles\Tests\AutoLoaderFake', get_declared_classes());

		$msg = 'Class AutoLoaderFake did not loaded';
		self::assertTrue(false !== $result, $msg);
	}
}
