<?php
namespace Veles\Tests\DataBase\Loggers;

use SplObserver;

/**
 * Class FakeSubject
 *
 * Нужен для тестирования класса PdoErrorLogger
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 * @group database
 */
class FakeSubject implements \SplSubject
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
