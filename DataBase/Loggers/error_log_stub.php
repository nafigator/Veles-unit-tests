<?php
/**
 * File is using for stub error_log() PHP function
 *
 * @file      error_log_stub.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-06-03 21:41
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */
namespace Veles\DataBase\Loggers;

function error_log($message, $type, $path)
{
	echo $message . $type . PHP_EOL . $path;
}