<?php
/**
 * @file      NativeAdapterChild.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2018 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-12-07 15:54
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */
namespace Veles\Tests\View\Adapters;

use Veles\View\Adapters\NativeAdapter;

/**
 * Class   NativeAdapterChild
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class NativeAdapterChild extends NativeAdapter
{
	public static function unsetInstance()
	{
		static::$instance = null;
	}
}
