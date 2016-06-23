<?php
/**
 * This file is used for stubbing curl_errno() function
 *
 * @file      curl_errno.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-06-23 10:48
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest;

function curl_errno($curl)
{
	if (!is_resource($curl)) {
		throw new \InvalidArgumentException('$curl argument must be resource');
	}

	return 555;
}
