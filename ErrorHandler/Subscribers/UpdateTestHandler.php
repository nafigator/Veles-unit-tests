<?php
/**
 * @file      UpdateTestHandler.php
 *
 * PHP version 5.6+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2017 Alexander Yancharuk <alex at itvault at info>
 * @date      2016-12-07 12:01
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */
namespace Tests\ErrorHandler\Subscribers;

use SplObserver;
use SplSubject;

/**
 * Class   UpdateTestHandler
 *
 * @author Yancharuk Alexander <alex at itvault at info>
 */
class UpdateTestHandler implements SplSubject
{
	public function attach(SplObserver $observer)
	{
	}

	public function detach(SplObserver $observer)
	{
	}

	public function notify()
	{
	}
}
