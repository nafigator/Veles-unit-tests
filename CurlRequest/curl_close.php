<?php
/**
 * This file is used for stubbing curl_close() function
 *
 * @file      curl_close.php
 *
 * PHP version 7.1+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2021 Alexander Yancharuk
 * @date      2016-06-23 12:30
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest;

function curl_close($curl)
{
	if (!is_resource($curl)) {
		throw new \InvalidArgumentException('$curl argument must be resource');
	}
}
