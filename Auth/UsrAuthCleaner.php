<?php
/**
 * @file    UsrAuthCopy.php
 *
 * PHP version 7.1+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-12-24 16:47
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\Auth;

use Veles\Auth\UsrAuth;

/**
 * Class UsrAuthCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class UsrAuthCleaner extends UsrAuth
{
	protected static $instance;

	public static function unsetInstance(): void
	{
		static::$instance = null;
	}
}
