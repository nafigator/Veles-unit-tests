<?php
/**
 * Function stub for test MemcacheRaw class
 *
 * @file      fsockopen.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2020 Alexander Yancharuk <alex at itvault at info>
 * @date      2017-10-20 13:55
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Cache\Adapters;

function fsockopen($host, $port, $errno, $errstr)
{
	if (false !== ($pos = strpos($host, 'VELES_UNIT_TEST'))) {
		return compact('host', 'port', 'errno', 'errstr');
	}

	throw new \Exception;
}
