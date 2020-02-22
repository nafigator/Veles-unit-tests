<?php
/**
 * Class for testing ProErrorLogger
 *
 * @file      BadSubject.php
 *
 * PHP version 7.0+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2019 Alexander Yancharuk <alex at itvault at info>
 * @date      2018-03-08 12:37
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Veles\Tests\DataBase\Loggers;

use SplObserver;

class BadSubject implements \SplSubject
{
	private $resource;
	private $stmt;

	public function attach(SplObserver $observer)
	{
	}

	public function detach(SplObserver $observer)
	{
	}


	public function notify()
	{
	}

	/**
	 * @return mixed
	 */
	public function getResource()
	{
		return $this->resource;
	}

	/**
	 * @param mixed $resource
	 */
	public function setResource($resource)
	{
		$this->resource = $resource;
	}

	/**
	 * @return mixed
	 */
	public function getStmt()
	{
		return $this->stmt;
	}

	/**
	 * @param mixed $stmt
	 */
	public function setStmt($stmt)
	{
		$this->stmt = $stmt;
	}
}
