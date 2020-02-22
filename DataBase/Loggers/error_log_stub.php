<?php
/**
 * File is using for stub error_log() PHP function
 *
 * @file      error_log_stub.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk
 * @date      2016-06-03 21:41
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */
namespace Veles\DataBase\Loggers;

function error_log($message, $type, $path)
{
	echo $message . $type . PHP_EOL . $path;
}
