<?php
/**
 * @file      filter_input.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-12-07 12:45
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Routing;

/**
 * @param $type
 * @param $variable_name
 *
 * @return string|null
 */

function filter_input($type, $variable_name)
{
	if (INPUT_SERVER === $type && 'HTTP_X_REQUESTED_WITH' === $variable_name) {
		return $_SERVER['HTTP_X_REQUESTED_WITH'] ?? null;
	}

	return '';
}
