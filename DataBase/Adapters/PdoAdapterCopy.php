<?php
/**
 * @file    PdoAdapterCopy.php
 *
 * PHP version 5.4+
 *
 * @author  Yancharuk Alexander <alex at itvault dot info>
 * @date    2014-09-20 16:50
 * @license The BSD 3-Clause License
 *          <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\DataBase\Adapters;

use Veles\DataBase\Adapters\PdoAdapter;

/**
 * Class PdoAdapterCopy
 * @author  Yancharuk Alexander <alex at itvault dot info>
 */
class PdoAdapterCopy extends PdoAdapter
{
	public static function unsetInstance()
	{
		self::$instance = null;
	}
}
