<?php
/**
 * This file is used for stubbing curl_getinfo() function
 *
 * @file      get_info.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-06-23 11:01
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\CurlRequest;

function curl_getinfo($curl, $option = null)
{
	if (!is_resource($curl)) {
		throw new \InvalidArgumentException('$curl argument must be resource');
	}

	return null === $option
		? 'This is test info message!'
		: "This is test info message for option: $option!";
}
